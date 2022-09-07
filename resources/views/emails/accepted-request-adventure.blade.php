@component('mail::message')
Bonjour {{ $user_to['firstname'] }} {{ $user_to['name'] }}, <br>

La demande pour la croisière : {{ $adventure['name'] }} à été accéptée <br>

Dates : du {{ date('d/m/Y', strtotime($adventure['departure_date'])) }} au {{ date('d/m/Y', strtotime($adventure['arrival_date'])) }} <br>

Pour : {{ $adventure_booking['places_needed'] }} / personnes

<hr/> <br>

Sailing dream experience<br>
Contact : 05 02 03 04 05
{{-- @component('mail::button', ['url' => route('dashboard', app()->getLocale())])
    Acces au site
@endcomponent --}}

@endcomponent

