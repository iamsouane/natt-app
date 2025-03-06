@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Tontines</h1>
        <a href="{{ route('tontines.create') }}" class="btn btn-primary mb-3">Créer une Tontine</a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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
                @foreach ($tontines as $tontine)
                    <tr>
                        <td>{{ $tontine->libelle }}</td>
                        <td>{{ $tontine->frequence }}</td>
                        <td>{{ $tontine->date_debut }}</td>
                        <td>{{ $tontine->date_fin }}</td>
                        <td>
                            <!-- Bouton "Voir" -->
                            <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-info btn-sm">Voir</a>

                            <!-- Bouton "Modifier" -->
                            <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning btn-sm">Modifier</a>

                            <!-- Bouton "Supprimer" -->
                            <form action="{{ route('tontines.destroy', $tontine) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tontine ?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection