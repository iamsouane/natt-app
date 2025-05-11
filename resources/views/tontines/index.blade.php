@extends('layouts.app')

@section('title', 'Liste des Tontines')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users-cog text-primary mr-2"></i>Liste des Tontines
        </h1>
        
        <div class="d-flex">
            @can('create', App\Models\Tontine::class)
                <a href="{{ route('tontines.create') }}" class="btn btn-primary btn-sm shadow-sm mr-2">
                    <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Nouvelle Tontine
                </a>
            @endcan
            
            @can('send-emails', App\Models\Tontine::class)
                <form action="{{ route('tontines.sendEmails') }}" method="POST" class="mb-0">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm shadow-sm">
                        <i class="fas fa-envelope fa-sm text-white-50 mr-1"></i> Envoyer emails
                    </button>
                </form>
            @endcan
        </div>
    </div>

    <!-- Messages d'alerte -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Toutes les tontines</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Libellé</th>
                            <th>Fréquence</th>
                            <th>Période</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Images</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tontines as $tontine)
                            <tr>
                                <td class="font-weight-bold">{{ $tontine->libelle }}</td>
                                <td>
                                    <span class="badge badge-{{ 
                                        $tontine->frequence == 'JOURNALIERE' ? 'info' : 
                                        ($tontine->frequence == 'HEBDOMADAIRE' ? 'primary' : 'success') 
                                    }}">
                                        {{ $tontine->frequence }}
                                    </span>
                                </td>
                                <td>
                                    <small class="d-block">{{ \Carbon\Carbon::parse($tontine->date_debut)->format('d/m/Y') }}</small>
                                    <small class="d-block">{{ \Carbon\Carbon::parse($tontine->date_fin)->format('d/m/Y') }}</small>
                                </td>
                                <td class="text-right">
                                    {{ number_format($tontine->montant_total, 0, ',', ' ') }} FCFA
                                </td>
                                <td>
                                    @php
                                        $nbTirages = $tontine->tirages()->count();
                                        $estTerminee = $nbTirages >= $tontine->nbre_cotisation;
                                    @endphp
                                    @if($estTerminee)
                                        <span class="badge badge-danger">Terminée</span>
                                    @else
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    @if($tontine->images->count() > 0)
                                        <div class="d-flex flex-wrap">
                                            @foreach ($tontine->images->take(3) as $image)
                                                <img src="{{ asset('storage/tontines/' . $image->nom_image) }}" 
                                                     alt="{{ $image->nom_image }}" 
                                                     class="img-thumbnail m-1 cursor-pointer"
                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                     data-toggle="modal"
                                                     data-target="#imageModal"
                                                     onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                                            @endforeach
                                            @if($tontine->images->count() > 3)
                                                <span class="badge badge-light align-self-center ml-1">
                                                    +{{ $tontine->images->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-muted">Aucune image</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('tontines.show', $tontine) }}" 
                                           class="btn btn-sm btn-circle btn-outline-info mr-1"
                                           data-toggle="tooltip" title="Voir détails">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @can('update', $tontine)
                                            <a href="{{ route('tontines.edit', $tontine) }}" 
                                               class="btn btn-sm btn-circle btn-outline-warning mr-1"
                                               data-toggle="tooltip" title="Modifier">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endcan
                                        
                                        @can('delete', $tontine)
                                            <button class="btn btn-sm btn-circle btn-outline-danger" 
                                                    data-toggle="modal" 
                                                    data-target="#deleteModal{{ $tontine->id }}"
                                                    data-toggle="tooltip" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>

                            <!-- Modal de suppression -->
                            <div class="modal fade" id="deleteModal{{ $tontine->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-exclamation-triangle mr-2"></i>Confirmation
                                            </h5>
                                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Êtes-vous sûr de vouloir supprimer la tontine :</p>
                                            <p class="font-weight-bold mb-1">{{ $tontine->libelle }}</p>
                                            <p class="text-muted small">
                                                Créée le {{ $tontine->created_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times mr-1"></i> Annuler
                                            </button>
                                            <form action="{{ route('tontines.destroy', $tontine) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                                    <p class="text-muted">Aucune tontine disponible</p>
                                    @can('create', App\Models\Tontine::class)
                                        <a href="{{ route('tontines.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus mr-1"></i> Créer une tontine
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-image mr-2"></i>Aperçu de l'image
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" class="img-fluid" alt="Image agrandie">
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .btn-circle {
        width: 30px;
        height: 30px;
        padding: 0;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .table td, .table th {
        vertical-align: middle;
    }
</style>

<script>
    // Initialiser les tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection