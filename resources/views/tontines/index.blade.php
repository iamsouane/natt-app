@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3">Liste des Tontines</h1>
    <div class="d-flex justify-content-start align-items-center gap-2 mb-4">

        @can('create', App\Models\Tontine::class)
            <a href="{{ route('tontines.create') }}" class="btn btn-primary rounded-pill mr-2">
                <i class="fas fa-plus mr-1"></i> Créer une Tontine
            </a>
        @endcan
    
        @can('send-emails', App\Models\Tontine::class)
            <form action="{{ route('tontines.sendEmails') }}" method="POST" class="mb-0">
                @csrf
                <button type="submit" class="btn btn-success rounded-pill">
                    <i class="fas fa-envelope"></i> Envoyer les emails
                </button>
            </form>
        @endcan
    
    </div>    
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Libellé</th>
                            <th>Fréquence</th>
                            <th>Date début</th>
                            <th>Date fin</th>
                            <th>Images</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tontines as $tontine)
                            <tr>
                                <td>{{ $tontine->libelle }}</td>
                                <td>{{ $tontine->frequence }}</td>
                                <td>{{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</td>
                                <td class="d-flex flex-wrap gap-2">
                                    @foreach ($tontine->images as $image)
                                        <img src="{{ asset('storage/tontines/' . $image->nom_image) }}" 
                                             alt="{{ $image->nom_image }}" 
                                             class="img-thumbnail"
                                             style="width: 60px; height: 60px; cursor: pointer;"
                                             data-toggle="modal"
                                             data-target="#imageModal"
                                             onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-outline-info btn-sm rounded-pill mb-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('update', $tontine)
                                        <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-outline-warning btn-sm rounded-pill mb-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can('delete', $tontine)
                                        <button class="btn btn-outline-danger btn-sm rounded-pill mb-1" data-toggle="modal" data-target="#deleteModal{{ $tontine->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endcan
                                </td>
                            </tr>

                            <!-- Modal de suppression -->
                            <div class="modal fade" id="deleteModal{{ $tontine->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $tontine->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">Supprimer la Tontine</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span>&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            Êtes-vous sûr de vouloir supprimer cette tontine <strong>{{ $tontine->libelle }}</strong> ?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <form action="{{ route('tontines.destroy', $tontine) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Aucune tontine disponible.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal d'image -->
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aperçu de l'image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Image" class="img-fluid rounded shadow" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection