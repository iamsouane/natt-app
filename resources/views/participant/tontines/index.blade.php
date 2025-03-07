@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Tontines Disponibles</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Fréquence</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tontines as $tontine)
                    <tr>
                        <td>{{ $tontine->libelle }}</td>
                        <td>{{ $tontine->frequence }}</td>
                        <td>{{ $tontine->date_debut }}</td>
                        <td>{{ $tontine->date_fin }}</td>
                        <td>
                            <a href="{{ route('participant.tontines.show', $tontine) }}" class="btn btn-info btn-sm">Voir</a>
                            <a href="{{ route('participant.cotisations.create', $tontine) }}" class="btn btn-success btn-sm">Participer</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucune tontine disponible.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection