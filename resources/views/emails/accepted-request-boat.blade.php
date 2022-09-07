@component('mail::message')
Bonjour {{ $user_to['firstname'] }} {{ $user_to['name'] }}, <br>

Votre demande de location de bateau pour : {{ $boat['name'] }} à été accéptée <br>

Dates : du {{ date('d/m/Y', strtotime($boat_booking['start_date'])) }} au {{ date('d/m/Y', strtotime($boat_booking['end_date'])) }} <br>

@if ($boat_booking['with_skipper'] == 1)
<b>Avec Skipper</b>
@elseif ($boat_booking['with_skipper'] == 0)
<b>Sans Skipper</b>
@endif

<hr/> <br>

Sailing dream experience<br>
Contact : 05 02 03 04 05
{{-- @component('mail::button', ['url' => route('dashboard', app()->getLocale())])
    Acces au site
@endcomponent --}}

@endcomponent

