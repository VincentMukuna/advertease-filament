<?php

namespace App\Notifications\BillboardCampaign;

use App\Models\Billboard;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BillboardAttachedToCampaign extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Billboard $billboard,
        public Campaign $campaign
    ) {
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
            ->subject('New billboard request')
            ->greeting('Hello! ')
            ->line('Your billboard '.$this->billboard->number.' has been attached to a new campaign: '.$this->campaign->number.' .');
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

    public function toDatabase(User $notifiable): array
    {
        return \Filament\Notifications\Notification::make()
            ->title('New billboard request')
            ->body('Your billboard '.$this->billboard->number.' has been attached to a new campaign: '.$this->campaign->number.' .')
            ->getDatabaseMessage();
    }
}
