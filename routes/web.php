<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Song\Create as SongCreate;
use App\Livewire\Song\Update as SongUpdate;
use App\Http\Controllers\PlayListController;
use App\Http\Controllers\MusicListController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\ArtistListController;
use App\Http\Controllers\BeatsCloudController;
use App\Http\Controllers\LikedMusicsController;
use App\Http\Controllers\ViewedMusicsController;
use App\Http\Controllers\Auth\AdminLoginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landingPage');
})->name('root')->middleware('CheckLogin');
Route::get('/policy', [HomeController::class, 'policy'])->name('policy');
Auth::routes(['verify' => true]);

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware('verified', 'CheckUserRole');
Route::get('/reportMusic/{id}', [ReportController::class, 'reportMusic'])->name('ReportMusic')->middleware('verified', 'CheckUserRole');
Route::post('/reportMusic', [ReportController::class, 'submitReportMusic'])->name('SubmitReportMusic')->middleware('verified', 'CheckUserRole');

Route::get('/ArtistList', [ArtistListController::class, 'index'])->name('artistList')->middleware('verified', 'CheckUserRole');
Route::get('/Artist/{id}', [ArtistListController::class, 'show'])->name('user.artistShow')->middleware('verified', 'CheckUserRole');
Route::get('/FollowededArtist', [ArtistListController::class, 'showFollowed'])->name('FollowededArtist')->middleware('verified', 'CheckUserRole');

Route::get('/MusicList', [MusicListController::class, 'index'])->name('MusicList')->middleware('verified', 'CheckUserRole');
Route::get('/LikedMusics', [MusicListController::class, 'LikedMusics'])->name('LikedMusics')->middleware('verified', 'CheckUserRole');
Route::get('/ViewedMusics', [MusicListController::class, 'ViewedMusics'])->name('ViewedMusics')->middleware('verified', 'CheckUserRole');

Route::get('/AddToPlayList/{id}', [PlayListController::class, 'AddToPlayList'])->name('AddToPlayList')->middleware('verified', 'CheckUserRole');
Route::get('/NewPlaylist', [PlayListController::class, 'create'])->name('NewPlayList')->middleware('verified', 'CheckUserRole');
Route::get('/Playlists', [PlayListController::class, 'index'])->name('PlayLists')->middleware('verified', 'CheckUserRole');
Route::get('/Playlist/{id}', [PlayListController::class, 'showAPlaylist'])->name('APlayList')->middleware('verified', 'CheckUserRole');
Route::delete('/Playlists', [PlayListController::class, 'deletePlayList'])->name('DeletePlayList')->middleware('verified', 'CheckUserRole');

Route::get('/BeatsCloud', [BeatsCloudController::class, 'index'])->name('BeatsCloud')->middleware('verified', 'CheckUserRole');
Route::get('/NewBeatsCloud', [BeatsCloudController::class, 'create'])->name('NewBeats')->middleware('verified', 'CheckUserRole');

Route::get('/studio', [StudioController::class, 'index'])->name('studioDashboard')->middleware('verified', 'CheckArtistRole');
Route::get('/studio/profile', [StudioController::class, 'profile'])->name('studioProfile')->middleware('verified', 'CheckArtistRole');
Route::put('/studio/profile/updateName', [StudioController::class, 'profileUpdateName'])->name('studioProfileUpdateName')->middleware('verified', 'CheckArtistRole');
Route::put('/studio/profile/updateImg', [StudioController::class, 'profileUpdateImg'])->name('studioProfileUpdateImg')->middleware('verified', 'CheckArtistRole');
Route::get('/studio/musicCenter', [StudioController::class, 'MusicCneter'])->name('musicCenter')->middleware('verified', 'CheckArtistRole');
Route::get('/studio/musicCenter/createMusic', SongCreate::class)->name('song.create')->middleware('verified', 'CheckArtistRole');
Route::get('/studio/musicCenter/editMusic{id}', SongUpdate::class)->name('song.update')->middleware('verified', 'CheckArtistRole');
Route::delete('/studio/musicCenter/deleteMusic{id}', [StudioController::class, 'deleteMusic'])->name('studioDeleteMusic')->middleware('verified', 'CheckArtistRole');
Route::get('/studio/billing', [StudioController::class, 'billing'])->name('studioBilling')->middleware('verified', 'CheckArtistRole');
Route::put('/studio/billing/setInfo', [StudioController::class, 'setMonetizeRequest'])->name('MonetizeRequest')->middleware('verified', 'CheckArtistRole');
Route::put('/studio/billing/resetInfo', [StudioController::class, 'resetMonetizeRequest'])->name('resetMonetizeRequest')->middleware('verified', 'CheckArtistRole');
Route::put('/studio/billing/payoff', [StudioController::class, 'setPayoff'])->name('setPayoff')->middleware('verified', 'CheckArtistRole');

Route::get('/subscriptionPlans', [PaymentController::class, 'showPlans'])->name('subscriptionPlans')->middleware('verified', 'CheckUserRole');
Route::post('/payment', [PaymentController::class, 'payment'])->name('payment')->middleware('verified', 'CheckUserRole');
Route::get('/payment-verify', [PaymentController::class, 'paymentVerify'])->name('home.payment_verify')->middleware('verified', 'CheckUserRole');



Route::get('/admin/login', [AdminLoginController::class, 'index'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.loginCheck');

Route::get('/admin/dashboard', [AdminPanelController::class, 'index'])->name('admin.dashboard')->middleware('CheckAdminRole');
Route::get('/admin/reports', [AdminPanelController::class, 'reports'])->name('admin.report')->middleware('CheckAdminRole');
Route::get('/admin/financial', [AdminPanelController::class, 'financial'])->name('admin.financial')->middleware('CheckAdminRole:2');
Route::get('/admin/adminManager', [AdminPanelController::class, 'adminManager'])->name('admin.adminManager')->middleware('CheckAdminRole:3');
Route::get('/admin/plansManager', [AdminPanelController::class, 'plansManager'])->name('admin.plansManager')->middleware('CheckAdminRole:3');

Route::delete('/admin/deleteReportedMusic', [AdminPanelController::class, 'deleteReportedMusic'])->name('admin.DeleteReportedMusic')->middleware('CheckAdminRole');

Route::get('/admin/addNewAdmin', [AdminPanelController::class, 'addNewAdmin'])->name('admin.addNewAdmin')->middleware('CheckAdminRole:3');
Route::post('/admin/addNewAdmin', [AdminPanelController::class, 'createAdmin'])->name('admin.createAdmin')->middleware('CheckAdminRole:3');
Route::get('/admin/editAdmin{id}', [AdminPanelController::class, 'editAdmin'])->name('admin.editAdmin')->middleware('CheckAdminRole:3');
Route::post('/admin/editAdmin{id}', [AdminPanelController::class, 'updateAdmin'])->name('admin.updateAdmin')->middleware('CheckAdminRole:3');
Route::delete('/admin/deleteAdmin', [AdminPanelController::class, 'deleteAdmin'])->name('admin.deleteAdmin')->middleware('CheckAdminRole:3');

Route::get('/admin/plan/addNewPlans', [AdminPanelController::class, 'addNewPlans'])->name('admin.addNewPlans')->middleware('CheckAdminRole:3');
Route::post('/admin/plan/addNewPlans', [AdminPanelController::class, 'createPlans'])->name('admin.createPlans')->middleware('CheckAdminRole:3');
Route::get('/admin/plan/editPlans{id}', [AdminPanelController::class, 'editPlans'])->name('admin.editPlans')->middleware('CheckAdminRole:3');
Route::post('/admin/plan/editPlans{id}', [AdminPanelController::class, 'updatePlans'])->name('admin.updatePlans')->middleware('CheckAdminRole:3');
Route::delete('/admin/plan/deletePlans', [AdminPanelController::class, 'deletePlans'])->name('admin.deletePlans')->middleware('CheckAdminRole:3');
Route::get('/admin/beatsPack/addNewPacks', [AdminPanelController::class, 'addNewPacks'])->name('admin.addNewPacks')->middleware('CheckAdminRole:3');
Route::post('/admin/beatsPack/addNewPacks', [AdminPanelController::class, 'createPacks'])->name('admin.createPacks')->middleware('CheckAdminRole:3');
Route::get('/admin/beatsPack/editPacks{id}', [AdminPanelController::class, 'editPacks'])->name('admin.editPacks')->middleware('CheckAdminRole:3');
Route::post('/admin/beatsPack/editPacks{id}', [AdminPanelController::class, 'updatePacks'])->name('admin.updatePacks')->middleware('CheckAdminRole:3');
Route::delete('/admin/beatsPack/deletePacks', [AdminPanelController::class, 'deletePacks'])->name('admin.deletePacks')->middleware('CheckAdminRole:3');

Route::put('/admin/financial/RejectBank', [AdminPanelController::class, 'rejectBank'])->name('admin.RejectBank')->middleware('CheckAdminRole:2');
Route::put('/admin/financial/AcceptBank', [AdminPanelController::class, 'acceptBank'])->name('admin.AcceptBank')->middleware('CheckAdminRole:2');
Route::put('/admin/financial/AcceptPayoff', [AdminPanelController::class, 'acceptPayoff'])->name('admin.AcceptPayoff')->middleware('CheckAdminRole:2');
