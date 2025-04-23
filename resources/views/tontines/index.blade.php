@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4 text-primary fw-bold">Liste des Tontines</h1>

    @can('create', App\Models\Tontine::class)
        <a href="{{ route('tontines.create') }}" class="btn btn-outline-primary rounded-pill shadow-sm mb-3">
            <i class="fas fa-plus me-2"></i>Créer une Tontine
        </a>
    @endcan

    @if (session('success'))
        <div class="alert alert-success rounded shadow-sm">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger rounded shadow-sm">{{ session('error') }}</div>
    @endif

    @can('send-emails', App\Models\Tontine::class)
        <form action="{{ route('tontines.sendEmails') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-success rounded-pill shadow-sm mb-3">
                <i class="fas fa-envelope me-2"></i>Envoyer les emails
            </button>
        </form>
    @endcan

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle rounded shadow-sm bg-white">
            <thead class="table-light">
                <tr class="text-center">
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
                        <td class="fw-semibold">{{ $tontine->libelle }}</td>
                        <td>{{ $tontine->frequence }}</td>
                        <td>{{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</td>
                        <td class="text-center">
                            @foreach ($tontine->images as $image)
                                <img src="{{ asset('storage/tontines/' . $image->nom_image) }}"
                                     alt="{{ $image->nom_image }}"
                                     class="img-thumbnail mx-1 mb-1"
                                     style="max-width: 80px; cursor: pointer;"
                                     data-bs-toggle="modal"
                                     data-bs-target="#imageModal"
                                     onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                            @endforeach
                        </td>
                        <td class="text-center">
                            <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-info btn-sm rounded-pill mb-1">
                                <i class="fas fa-eye"></i>
                            </a>
                            @can('update', $tontine)
                                <a href="{{ route('tontines.edit', $tontine) }}" class="btn btn-warning btn-sm rounded-pill mb-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                            @endcan
                            @can('delete', $tontine)
                                <button class="btn btn-danger btn-sm rounded-pill mb-1" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tontine->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            @endcan
                        </td>
                    </tr>

                    <!-- Modal suppression -->
                    <div class="modal fade" id="deleteModal{{ $tontine->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $tontine->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content rounded-3 shadow-sm">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="deleteModalLabel{{ $tontine->id }}">Confirmation de suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                </div>
                                <div class="modal-body">
                                    Êtes-vous sûr de vouloir supprimer la tontine <strong>{{ $tontine->libelle }}</strong> ?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Annuler</button>
                                    <form action="{{ route('tontines.destroy', $tontine) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-pill">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal image preview -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-3 shadow-sm">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Image">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection