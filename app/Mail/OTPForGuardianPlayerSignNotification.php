<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\PlayerRegistration;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OTPForGuardianPlayerSignNotification extends Mailable
{
    use Queueable, SerializesModels;

    public PlayerRegistration $player_registration;
    public string $otp_code;

    /**
     * Create a new message instance.
     */
    public function __construct(PlayerRegistration $player_registration, string $otp_code)
    {
        $this->player_registration = $player_registration;
        $this->otp_code = $otp_code;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Guardian OTP Code for Tournament {$this->player_registration->tournament->name}"
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.otp.player_guardian_sign_otp_mail',
            with: [
                'player_registration' => $this->player_registration,
                'otp_code' => $this->otp_code,
                'url' => route('player_registration.show', $this->player_registration->id),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
