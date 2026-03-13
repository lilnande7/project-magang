<x-mail::message>
# Pesan Baru dari {{ $data['name'] }}

**Email Pengirim:** {{ $data['email'] }}

@if(!empty($data['phone']))
**Nomor Kontak:** {{ $data['phone'] }}
@endif

@component('mail::panel')
{{ $data['message'] }}
@endcomponent

@if(!empty($data['ip']))
<small>IP: {{ $data['ip'] }} | Agent: {{ $data['user_agent'] ?? '-' }}</small>
@endif

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
