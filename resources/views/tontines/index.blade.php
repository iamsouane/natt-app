@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Liste des Tontines</h1>

        @can('create', App\Models\Tontine::class)
            <a href="{{ route('tontines.create') }}" class="btn btn-primary mb-3">Créer une Tontine</a>
        @endcan

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @can('send-emails', App\Models\Tontine::class)
            <form action="{{ route('tontines.sendEmails') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success mb-3">Envoyer les emails</button>
            </form>
        @endcan

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Libellé</th>
                    <th>Fréquence</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tontines as $tontine)
                    <tr>
                        <td>{{ $tontine->libelle }}</td>
                        <td>{{ $tontine->frequence }}</td>
                        <td>{{ \Carbon\Carbon::parse($tontine->date_debut)->format('m/d/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($tontine->date_fin)->format('m/d/Y') }}</td>
                        <td>
                            @foreach ($tontine->images as $image)
                                <img src="{{ asset('storage/tontines/' . $image->nom_image) }}" 
                                     alt="{{ $image->nom_image }}" 
                                     style="width: 100px; height: auto; margin-bottom: 5px; cursor: pointer;"
                                     data-toggle="modal" 
                                     data-target="#imageModal" 
                                     onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-info btn-sm">Voir</a>
                            @can('update', $tontine)
                                <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning btn-sm">Modifier</a>
                            @endcan
                            @can('delete', $tontine)
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $tontine->id }}">
                                    Supprimer
                                </button>
                            @endcan
                        </td>
                    </tr>

                    <!-- Modale de confirmation de suppression -->
                    <div class="modal fade" id="deleteModal{{ $tontine->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $tontine->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $tontine->id }}">Confirmer la suppression</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer cette tontine ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                    <form action="{{ route('tontines.destroy', $tontine) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modale Bootstrap pour l'aperçu de l'image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- L'image s'affiche ici -->
                    <img id="modalImage" src="" alt="Image" class="img-fluid" />
                </div>
            </div>
        </div>
    </div>
@endsection