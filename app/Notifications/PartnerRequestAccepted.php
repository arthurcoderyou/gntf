<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Models\PlayerRegistration;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\TournamentEventCategoryOptions;
use Illuminate\Notifications\Messages\MailMessage;

class PartnerRequestAccepted extends Notification  #implements ShouldQueue
{
    use Queueable;
 

    protected $partner;
    protected $option;
    protected $playerRegistration;

    public function __construct($partner,TournamentEventCategoryOptions $option, PlayerRegistration $playerRegistration)
    {
        $this->partner = $partner;
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
            ->subject('Your Doubles Partner Request Has Been Accepted!')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('Your request to partner with ' . $this->partner->name . ' has been accepted for the tournament event: ' . $this->option->tournament_event_category->name . '.')
            ->action('View Your Registration', $url)
            ->line('Good luck with your tournament!');
    }
}
