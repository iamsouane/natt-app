@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Tirages</h1>

        @can('create', App\Models\Tirage::class) <!-- Vérification si l'utilisateur peut créer un tirage -->
            <a href="{{ route('tirages.create') }}" class="btn btn-primary mb-3">Créer un Tirage</a>
        @endcan

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tontine</th>
                    <th>Gagnant</th>
                    <th>Date du tirage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tirages as $tirage)
                    <tr>
                        <td>{{ $tirage->id }}</td>
                        <td>{{ $tirage->tontine->libelle }}</td>
                        <td>{{ $tirage->user->prenom }} {{ $tirage->user->nom }}</td>
                        <td>{{ $tirage->date_tirage }}</td>
                        <td>
                            <a href="{{ route('tirages.show', $tirage) }}" class="btn btn-info btn-sm">Voir</a>

                            @can('update', $tirage) <!-- Vérification si l'utilisateur peut modifier ce tirage -->
                                <a href="{{ route('tirages.edit', $tirage) }}" class="btn btn-warning btn-sm">Modifier</a>
                            @endcan

                            @can('delete', $tirage) <!-- Vérification si l'utilisateur peut supprimer ce tirage -->
                                <form action="{{ route('tirages.destroy', $tirage) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce tirage ?')">Supprimer</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Aucun tirage trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination (si vous utilisez paginate) -->
        @if ($tirages instanceof \Illuminate\Pagination\LengthAwarePaginator)
            {{ $tirages->links() }}
        @endif
    </div>
@endsection
