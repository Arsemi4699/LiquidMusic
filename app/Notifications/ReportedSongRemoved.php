<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportedSongRemoved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $target_name;
    public function __construct($music_name)
    {
        $this->target_name = $music_name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('موزیک شما حذف شد!')
            ->line('موزیک ارسالی شما به نام ' . $this->target_name . ' حذف شد!')
            ->line('موزیک شما پس از گزارش کاربران سرویس و بررسی توسط ادمین نامناسب و خلاف قوانین سرویس شناخته شد و از سرویس حذف شد.')
            ->line('لطفا در ارسال موزیک های خود دقت فرمایید.')
            ->line('با تشکر از فعالیت شما در سرویس Liquid Music.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
