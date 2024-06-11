<?php

namespace App\Notifications\BillboardCampaign;

use App\Filament\Resources\CampaignResource;
use App\Models\Billboard;
use App\Models\BillboardCampaign;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignBillboardMaintenanceEnd extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    private Billboard $billboard;

    private Campaign $campaign;

    /**
     * Create a new notification instance.
     */
    public function __construct(public BillboardCampaign $billboardCampaign)
    {
        $this->campaign = $billboardCampaign->campaign;
        $this->billboard = $billboardCampaign->billboard;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Billboard Maintenance End')
            ->greeting('Hello! ')
            ->line('Billboard '.$this->billboard->number.' for your campaign '.$this->campaign->number.' has finished being maintained. Charges will be incurred as usual going forward.')
            ->action('View Campaign', CampaignResource::getUrl('edit', ['record' => $this->campaign->id]))
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

    public function toDatabase(User $notifiable): array
    {
        return \Filament\Notifications\Notification::make()
            ->title('Billboard Maintenance End')
            ->body('Billboard '.$this->billboard->number.' for your campaign '.$this->campaign->number.' has finished being maintained. Charges will be incurred as usual going forward.')
            ->getDatabaseMessage();
    }
}
