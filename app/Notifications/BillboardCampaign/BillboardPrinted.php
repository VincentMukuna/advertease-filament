<?php

namespace App\Notifications\BillboardCampaign;

use App\Models\Billboard;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class BillboardPrinted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Billboard $billboard, public Campaign $campaign)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Billboard Printed')
            ->line('Billboard '.$this->billboard->number.' for campaign '.$this->campaign->number.' has been printed and is being installed. We will notify you when it has been activated.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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

    public function toDtatabase(User $user): array
    {
        return \Filament\Notifications\Notification::make()
            ->title('Billboard printed')
            ->body('Billboard '.Str::limit($this->billboard->title, 30).' has been printed for your campaign '.Str::limit($this->campaign->title, 30.).'. You will be notified when installation is complete.')
            ->getDatabaseMessage();

    }
}
