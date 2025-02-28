{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
@component('mail::message')
# Tournament Registration OTP Code

Hello {{ $player_registration->user->name }},

You are required to verify your tournament registration for **{{ $player_registration->tournament->name }}**.

## **Your OTP Code:**
**{{ $otp_code }}**  
(This code is valid for 10 minutes.)

Use this OTP code to complete your registration process.

@component('mail::button', ['url' => $url])
    Verify Registration
@endcomponent

If you did not request this OTP, please ignore this email.

Thanks,  
{{ config('app.name') }}
@endcomponent