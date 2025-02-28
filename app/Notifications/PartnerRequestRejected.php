<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\PlayerRegistration;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\TournamentEventCategoryOptions;
use Illuminate\Notifications\Messages\MailMessage;

class PartnerRequestRejected extends Notification # implements ShouldQueue
{
    use Queueable;

    protected $option;
    protected $playerRegistration;

    public function __construct(TournamentEventCategoryOptions $option, PlayerRegistration $playerRegistration)
    {
        $this->option = $option;
        $this->playerRegistration = $playerRegistration;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = route('player_registration.show', ['player_registration' => $this->playerRegistration->id]);

        return (new MailMessage)
            ->subject('Your Doubles Partner Request Has Been Rejected')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your request to partner with ' . auth()->user()->name . ' for the tournament event: ' . $this->option->tournament_event_category->name . ' has been rejected.')
            ->line('You may select another partner for this event.')
            ->action('View Registration Details', $url)
            ->line('Thank you for your understanding.');
    }
}
