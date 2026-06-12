<x-mail::message>
# Message Received

Hi {{ $contactMessage->first_name }},

We received your {{ $contactMessage->department }} message and saved it in the QuickCart backend.

<x-mail::panel>
{{ $contactMessage->message }}
</x-mail::panel>

Our support team will reply soon.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
