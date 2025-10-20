@component('mail::message')
# Kode Verifikasi Email

Halo,

Gunakan kode OTP berikut untuk memverifikasi email Anda:

@component('mail::panel')
# {{ $code }}
@endcomponent

Kode ini berlaku selama {{ $ttl }} menit.

Jika Anda tidak meminta kode ini, abaikan email ini.

Salam,
{{ $app }}
@endcomponent
