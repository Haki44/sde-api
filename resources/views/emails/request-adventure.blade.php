@component('mail::message')
Bonjour, <br>

Une demande de réservation de {{ $data['name'] }} {{ $data['firstname'] }} <br>

Pour cette aventure : {{ $adventure->name }} <br>

Nationalité : {{ $data['nationality'] }} <br>

Places demandés : {{ $data['places_needed'] }} <br>

Description : {{ $data['description'] }} <br>

Email : {{ $data['email'] }}, Phone : {{ $data['tel'] }}

{{-- @component('mail::button', ['url' => route('dashboard', app()->getLocale())])
    Acces au site
@endcomponent --}}

@endcomponent

