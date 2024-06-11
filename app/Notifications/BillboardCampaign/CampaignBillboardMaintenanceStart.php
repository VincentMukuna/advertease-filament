<?php

namespace App\Notifications\BillboardCampaign;

use App\DTO\MaintenanceScheduleDTO;
use App\Filament\Resources\CampaignResource;
use App\Models\Billboard;
use App\Models\BillboardCampaign;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignBillboardMaintenanceStart extends Notification
{
    use Queueable;

    private Billboard $billboard;

    private Campaign $campaign;

    /**
     * Create a new notification instance.
     */
    public function __construct(public BillboardCampaign $billboardCampaign, private MaintenanceScheduleDTO $schedule)
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
            ->subject('Billboard Maintenance')
            ->greeting('Hello! ')
            ->line('Billboard '.$this->billboard->number.' for your campaign '.$this->campaign->number.' is under scheduled maintenance until '.$this->schedule->end_date.' No charges will be incurred during this period.')
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
            ->title('Billboard Maintenance')
            ->body('Billboard '.$this->billboard->number.' for your campaign '.$this->campaign->number.' is under scheduled maintenance until '.$this->schedule->end_date.' No charges will be incurred during this period.')
            ->getDatabaseMessage();
    }
}
