<?php

namespace App\Notifications;

use App\Models\PlayerRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OTPForPlayerSignNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $player_registration;
    public string $otp_code;

    /**
     * Create a new notification instance.
     */
    public function __construct(PlayerRegistration $player_registration,string $otp_code)
    {
        $this->player_registration = $player_registration;
        $this->otp_code = $otp_code;
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
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');

 

        $email = (new MailMessage)
            ->subject("Player Registration OTP Code for Tournament {$this->player_registration->tournament->name}")
            ->markdown('emails.otp.player_sign_otp_mail', [
                'player_registration' => $this->player_registration, 
                'otp_code' => $this->otp_code,
                'url' => route('player_registration.show', $this->player_registration->id),
            ]);

         
        return $email;


        // $guardianEmail = $this->player_registration->user->guardian_email; // Use guardian email

        // return (new MailMessage)
        //     ->to($guardianEmail) // Explicitly set recipient email
        //     ->subject("Player Guardian Registration OTP Code for Tournament {$this->player_registration->tournament->name}")
        //     ->markdown('emails.otp.player_sign_otp_mail', [
        //         'player_registration' => $this->player_registration, 
        //         'otp_code' => $this->otp_code,
        //         'url' => route('player_registration.show', $this->player_registration->id),
        //     ]);

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
