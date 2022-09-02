@component('mail::message')
Bonjour, <br>

Une demande de réservation de {{ $data['name'] }} {{ $data['firstname'] }} <br>

Pour ce bateau : {{ $boat->name }} <br>

Nationalité : {{ $data['nationality'] }} <br>

Dates : du {{ date('d/m/Y', strtotime($data['start_date'])) }} au {{ date('d/m/Y', strtotime($data['end_date'])) }} <br>

@if ($data['with_skipper'] == 1)
<b>Avec Skipper</b>
@elseif ($data['with_skipper'] == 0)
<b>Sans Skipper</b>
@endif

Description : {{ $data['description'] }} <br>

Email : {{ $data['email'] }}, Phone : {{ $data['tel'] }}

{{-- @component('mail::button', ['url' => route('http://localhost:8080/')])
    Acces au site
@endcomponent --}}

@endcomponent

