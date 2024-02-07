<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

class PaymentController extends Controller
{
    public function showPlans()
    {
        $subPlans = DB::table('sub_plans')
            ->get();

        return view('payment.plans', compact('subPlans'));
    }

    public function payment(Request $req)
    {
        if (Auth::user()->role == 'subscriber' && $req->type == 'plan') {
            session()->flash('errorOnTrans', 'شما یک اشتراک فعال دارید!');
            return redirect()->back();
        }
        $targetItem = null;
        if ($req->type == 'plan') {
            $targetItem = DB::table('sub_plans')
                ->where('id', $req->id)
                ->first();
        } else if ($req->type == 'beatsPack') {
            $targetItem = DB::table('beats_pack')
                ->where('id', $req->id)
                ->first();
        }
        if ($targetItem) {
            try {
                $api = 'test';
                $amount = $targetItem->price_T;
                $redirect = route('home.payment_verify');
                $result = $this->send($api, $amount * 10, $redirect);
                $result = json_decode($result);
                if ($result->status) {
                    $NewTransaction = $this->createTransaction($req->id, $req->type, $result->token, $amount);
                    if (array_key_exists('error', $NewTransaction)) {
                        session()->flash('errorOnTrans', 'خرید با مشکل مواجه شد!');
                        return redirect()->back();
                    }
                    $go = "https://pay.ir/pg/$result->token";
                    return redirect()->to($go);
                } else {
                    session()->flash('errorOnTrans', 'خرید با مشکل مواجه شد!');
                }
            } catch (\Throwable $th) {
                session()->flash('errorOnTrans', 'خرید با مشکل مواجه شد!');
                return redirect()->back();
            }
        }
    }

    public function paymentVerify(Request $request)
    {
        try {
            $api = 'test';
            $token = $request->token;
            $result = json_decode($this->verify($api, $token));
            if (isset($result->status)) {
                if ($result->status == 1) {
                    $updateTransaction = $this->updateTransaction($token);
                    if (array_key_exists('error', $updateTransaction)) {
                        session()->flash('errorOnTrans', 'خرید با مشکل مواجه شد!');
                        return redirect()->back();
                    }
                    session()->flash('doneTrans', 'خرید با موفقیت انجام شد!');
                    return redirect('home');
                } else {
                    session()->flash('errorOnTrans', 'خرید با مشکل مواجه شد!');
                }
            } else {
                if ($_GET['status'] == 0) {
                    session()->flash('errorOnTrans', 'خرید با مشکل مواجه شد!');
                    return redirect()->back();
                }
            }
        } catch (\Throwable $th) {
            session()->flash('errorOnTrans', 'خرید با مشکل مواجه شد!');
            return redirect()->back();
        }
    }

    public function send($api, $amount, $redirect, $mobile = null, $factorNumber = null, $description = null)
    {
        return $this->curl_post('https://pay.ir/pg/send', [
            'api'          => $api,
            'amount'       => $amount,
            'redirect'     => $redirect,
            'mobile'       => $mobile,
            'factorNumber' => $factorNumber,
            'description'  => $description,
        ]);
    }

    public function curl_post($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
        ]);
        $res = curl_exec($ch);
        curl_close($ch);

        return $res;
    }

    public function verify($api, $token)
    {
        return $this->curl_post('https://pay.ir/pg/verify', [
            'api'   => $api,
            'token' => $token,
        ]);
    }

    public function createTransaction($item_id, $type, $token, $price)
    {
        try {
            DB::beginTransaction();

            if ($type == 'plan') {
                DB::table('transaction')
                    ->insert([
                        'user_id' => Auth::user()->id,
                        'token' => $token,
                        'status' => 0,
                        'price_T' => $price,
                        'plan_item_id' => $item_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            } else if ($type == 'beatsPack') {
                DB::table('transaction')
                    ->insert([
                        'user_id' => Auth::user()->id,
                        'token' => $token,
                        'status' => 0,
                        'price_T' => $price,
                        'beatsPack_item_id' => $item_id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return ['error' => $th->getMessage()];
        }
        return ['success' => 'done!'];
    }

    public function updateTransaction($token)
    {
        try {
            DB::beginTransaction();

            $trans = DB::table('transaction')->where('token', $token)->first();
            $type = ($trans->plan_item_id) ? 'plan' : 'beatsPack';
            DB::table('transaction')
                ->where('id', $trans->id)
                ->update([
                    'status' => 1,
                    'updated_at' => Carbon::now()
                ]);

            $user = User::findOrFail($trans->user_id);
            if ($type == 'plan') {
                $duration = DB::table('sub_plans')->find($trans->plan_item_id)->duration_D;
                $user->update([
                    'role' => 'subscriber',
                    'subscribe_ends' => Carbon::now()->addDays($duration),
                ]);
            } else if ($type == 'beatsPack') {
                $packSize = DB::table('beats_pack')->find($trans->beatsPack_item_id)->pack_size;
                $user->update([
                    'music_limit' => $user->music_limit + $packSize,
                ]);
            }

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            return ['error' => $th->getMessage()];
        }
        return ['success' => 'done!'];
    }
}
