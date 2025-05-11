@extends('layouts.app')

@section('title', 'Modifier la Tontine')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit text-primary mr-2"></i>Modifier la Tontine
        </h1>
        <a href="{{ url()->previous() }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Retour
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-10 mx-auto">

            <!-- Illustration -->
            <div class="text-center mb-4">
                <svg width="150" height="150" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="#4e73df" fill-opacity="0.1"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.7071 4.29289C12.3166 3.90237 11.6834 3.90237 11.2929 4.29289L7.29289 8.29289C6.90237 8.68342 6.90237 9.31658 7.29289 9.70711C7.68342 10.0976 8.31658 10.0976 8.70711 9.70711L11 7.41421V15C11 15.5523 11.4477 16 12 16C12.5523 16 13 15.5523 13 15V7.41421L15.2929 9.70711C15.6834 10.0976 16.3166 10.0976 16.7071 9.70711C17.0976 9.31658 17.0976 8.68342 16.7071 8.29289L12.7071 4.29289Z" fill="#4e73df"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7 13C7.55228 13 8 13.4477 8 14V17C8 17.5523 8.44772 18 9 18H15C15.5523 18 16 17.5523 16 17V14C16 13.4477 16.4477 13 17 13C17.5523 13 18 13.4477 18 14V17C18 18.6569 16.6569 20 15 20H9C7.34315 20 6 18.6569 6 17V14C6 13.4477 6.44772 13 7 13Z" fill="#4e73df"/>
                </svg>
            </div>

            <!-- Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Modification de : {{ $tontine->libelle }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tontines.update', $tontine) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Libellé -->
                                <div class="form-group">
                                    <label for="libelle" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-tag mr-1 text-primary"></i>Libellé
                                    </label>
                                    <input type="text" class="form-control" id="libelle" name="libelle" 
                                           value="{{ old('libelle', $tontine->libelle) }}" required>
                                </div>

                                <!-- Fréquence -->
                                <div class="form-group">
                                    <label for="frequence" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-calendar-alt mr-1 text-primary"></i>Fréquence
                                    </label>
                                    <select class="form-control" id="frequence" name="frequence" required>
                                        <option value="JOURNALIERE" {{ old('frequence', $tontine->frequence) == 'JOURNALIERE' ? 'selected' : '' }}>Journalière</option>
                                        <option value="HEBDOMADAIRE" {{ old('frequence', $tontine->frequence) == 'HEBDOMADAIRE' ? 'selected' : '' }}>Hebdomadaire</option>
                                        <option value="MENSUELLE" {{ old('frequence', $tontine->frequence) == 'MENSUELLE' ? 'selected' : '' }}>Mensuelle</option>
                                    </select>
                                </div>

                                <!-- Dates -->
                                <div class="form-group">
                                    <label for="date_debut" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-calendar-day mr-1 text-primary"></i>Date de début
                                    </label>
                                    <input type="date" class="form-control" id="date_debut" name="date_debut" 
                                           value="{{ old('date_debut', $tontine->date_debut) }}" required>
                                </div>

                                <!-- Montant total -->
                                <div class="form-group">
                                    <label for="montant_total" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-money-bill-wave mr-1 text-primary"></i>Montant total (FCFA)
                                    </label>
                                    <input type="number" class="form-control" id="montant_total" name="montant_total" 
                                           value="{{ old('montant_total', $tontine->montant_total) }}" required min="1">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Date de fin -->
                                <div class="form-group">
                                    <label for="date_fin" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-calendar-check mr-1 text-primary"></i>Date de fin
                                    </label>
                                    <input type="date" class="form-control" id="date_fin" name="date_fin" 
                                           value="{{ old('date_fin', $tontine->date_fin) }}" required>
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-align-left mr-1 text-primary"></i>Description
                                    </label>
                                    <textarea class="form-control" id="description" name="description" 
                                              rows="3" required>{{ old('description', $tontine->description) }}</textarea>
                                </div>

                                <!-- Montant de base -->
                                <div class="form-group">
                                    <label for="montant_de_base" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-coins mr-1 text-primary"></i>Montant de base (FCFA)
                                    </label>
                                    <input type="number" class="form-control" id="montant_de_base" name="montant_de_base" 
                                           value="{{ old('montant_de_base', $tontine->montant_de_base) }}" required min="1">
                                </div>

                                <!-- Participants -->
                                <div class="form-group">
                                    <label for="nbre_participant" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-users mr-1 text-primary"></i>Nombre de participants
                                    </label>
                                    <input type="number" class="form-control" id="nbre_participant" name="nbre_participant" 
                                           value="{{ old('nbre_participant', $tontine->nbre_participant) }}" required min="1">
                                </div>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="form-group mt-4">
                            <label for="images" class="font-weight-bold text-gray-800">
                                <i class="fas fa-images mr-1 text-primary"></i>Images
                            </label>
                            
                            <!-- Images existantes -->
                            @if ($tontine->images->count())
                                <div class="mb-3">
                                    <p class="text-muted mb-2">Images actuelles :</p>
                                    <div class="row">
                                        @foreach ($tontine->images as $image)
                                            <div class="col-md-2 col-4 mb-3">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/tontines/' . $image->nom_image) }}" 
                                                         class="img-fluid rounded shadow-sm cursor-pointer"
                                                         style="height: 100px; width: 100%; object-fit: cover;"
                                                         data-toggle="modal" 
                                                         data-target="#imageModal"
                                                         onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                                                    <a href="{{ route('tontines.deleteImage', $image->id) }}" 
                                                       class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1"
                                                       onclick="return confirm('Supprimer cette image ?')">
                                                        <i class="fas fa-times"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <!-- Nouvelle image -->
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="images" name="images[]" multiple>
                                <label class="custom-file-label" for="images">Ajouter des images...</label>
                            </div>
                            <small class="form-text text-muted">Formats acceptés: JPEG, PNG, GIF. Taille max: 2MB par image.</small>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-5 pt-4 border-top">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Enregistrer
                            </button>
                            <a href="{{ route('tontines.show', $tontine) }}" class="btn btn-secondary">
                                <i class="fas fa-eye mr-1"></i> Voir la tontine
                            </a>
                        </div>
                    </form>
                </div>
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
    .custom-file-label::after {
        content: "Parcourir";
    }
    .cursor-pointer {
        cursor: pointer;
    }
    textarea.form-control {
        min-height: 120px;
    }
    .card {
        border-radius: 0.5rem;
    }
</style>

<script>
    // Afficher le nom des fichiers sélectionnés
    document.querySelector('.custom-file-input').addEventListener('change', function(e) {
        var files = e.target.files;
        var label = document.querySelector('.custom-file-label');
        
        if (files.length > 1) {
            label.textContent = files.length + ' fichiers sélectionnés';
        } else if (files.length === 1) {
            label.textContent = files[0].name;
        } else {
            label.textContent = 'Ajouter des images...';
        }
    });

    // Initialiser les animations AOS
    document.addEventListener('DOMContentLoaded', function() {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    });
</script>
@endsection