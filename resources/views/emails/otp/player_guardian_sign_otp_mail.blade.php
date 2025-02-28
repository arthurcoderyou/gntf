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

Hello there, Here is your guardian otp code for {{ $player_registration->user->name }},

Player had joined a junior event and required to verify parent consent on tournament registration for **{{ $player_registration->tournament->name }}**.

## **Guardian OTP Code:**
**{{ $otp_code }}**  
(This code is valid for 10 minutes.)

Use this OTP code to complete the player registration process.
 

If you did not request this OTP, please ignore this email.

Thanks,  
{{ config('app.name') }}
@endcomponent