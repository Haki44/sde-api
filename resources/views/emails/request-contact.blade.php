@component('mail::message')
Bonjour, <br>

Une demande de contact de {{ $data['name'] }} {{ $data['firstname'] }} <br>

Description : {{ $data['description'] }} <br>

Email : {{ $data['email'] }}, Phone : {{ $data['tel'] }}

{{-- @component('mail::button', ['url' => route('dashboard', app()->getLocale())])
    Acces au site
@endcomponent --}}

@endcomponent

