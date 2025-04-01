@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gestion des Tontines</h1>

    @foreach ($tontinesData as $tontineData)
        <h3>Tontine : {{ $tontineData['tontine'] }}</h3>

        <table class="table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Séances Cotisées</th>
                    <th>Séances Restantes</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tontineData['participants'] as $participant)
                    <tr>
                        <td>{{ $participant['nom'] }}</td>
                        <td>{{ $participant['email'] }}</td>
                        <td>{{ $participant['cotisations_effectuees'] }} / {{ $tontineData['nbre_seances'] }}</td>
                        <td>{{ $participant['seances_restantes'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</div>
@endsection