@extends('layouts.app')

@section('title', 'Créer une Tontine')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle text-primary mr-2"></i>Créer une Tontine
        </h1>
        <a href="{{ route('tontines.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Retour
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">

        <div class="col-lg-10 mx-auto">

            <!-- Illustration -->
            <div class="text-center mb-4">
                <svg width="200" height="150" viewBox="0 0 200 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50C100 22.3858 122.386 0 150 0C177.614 0 200 22.3858 200 50C200 77.6142 177.614 100 150 100C122.386 100 100 77.6142 100 50Z" fill="#4e73df" fill-opacity="0.1"/>
                    <path d="M0 100C0 72.3858 22.3858 50 50 50C77.6142 50 100 72.3858 100 100C100 127.614 77.6142 150 50 150C22.3858 150 0 127.614 0 100Z" fill="#1cc88a" fill-opacity="0.1"/>
                    <path d="M50 0C77.6142 0 100 22.3858 100 50C100 77.6142 77.6142 100 50 100C22.3858 100 0 77.6142 0 50C0 22.3858 22.3858 0 50 0Z" fill="#f6c23e" fill-opacity="0.1"/>
                    <path d="M150 50C150 72.3858 172.386 50 200 50C200 72.3858 177.614 50 150 50Z" fill="#e74a3b" fill-opacity="0.1"/>
                    <path d="M100 100C100 122.386 122.386 100 150 100C177.614 100 200 122.386 200 100C200 122.386 177.614 100 150 100C122.386 100 100 122.386 100 100Z" fill="#36b9cc" fill-opacity="0.1"/>
                    <path d="M0 50C0 72.3858 22.3858 50 50 50C77.6142 50 100 72.3858 100 50C100 72.3858 77.6142 50 50 50C22.3858 50 0 72.3858 0 50Z" fill="#5a5c69" fill-opacity="0.1"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M100 50C100 22.3858 122.386 0 150 0C177.614 0 200 22.3858 200 50C200 77.6142 177.614 100 150 100C122.386 100 100 77.6142 100 50ZM150 75C161.598 75 171 65.598 171 54C171 42.402 161.598 33 150 33C138.402 33 129 42.402 129 54C129 65.598 138.402 75 150 75Z" fill="#4e73df"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M0 100C0 72.3858 22.3858 50 50 50C77.6142 50 100 72.3858 100 100C100 127.614 77.6142 150 50 150C22.3858 150 0 127.614 0 100ZM50 125C61.598 125 71 115.598 71 104C71 92.402 61.598 83 50 83C38.402 83 29 92.402 29 104C29 115.598 38.402 125 50 125Z" fill="#1cc88a"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M50 0C77.6142 0 100 22.3858 100 50C100 77.6142 77.6142 100 50 100C22.3858 100 0 77.6142 0 50C0 22.3858 22.3858 0 50 0ZM50 25C61.598 25 71 35.402 71 47C71 58.598 61.598 69 50 69C38.402 69 29 58.598 29 47C29 35.402 38.402 25 50 25Z" fill="#f6c23e"/>
                </svg>
            </div>

            <!-- Messages d'erreur -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <h5 class="alert-heading">
                        <i class="fas fa-exclamation-triangle mr-1"></i>Erreurs de validation
                    </h5>
                    <ul class="mb-0 pl-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <!-- Formulaire -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <h6 class="m-0 font-weight-bold">Informations de la tontine</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('tontines.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <!-- Fréquence -->
                                <div class="form-group">
                                    <label for="frequence" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-calendar-alt mr-1 text-primary"></i>Fréquence
                                    </label>
                                    <select name="frequence" id="frequence" class="form-control" required>
                                        <option value="JOURNALIERE" {{ old('frequence') === 'JOURNALIERE' ? 'selected' : '' }}>Journalière</option>
                                        <option value="HEBDOMADAIRE" {{ old('frequence') === 'HEBDOMADAIRE' ? 'selected' : '' }}>Hebdomadaire</option>
                                        <option value="MENSUELLE" {{ old('frequence') === 'MENSUELLE' ? 'selected' : '' }}>Mensuelle</option>
                                    </select>
                                </div>

                                <!-- Dates -->
                                <div class="form-group">
                                    <label for="date_debut" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-calendar-day mr-1 text-primary"></i>Date de début
                                    </label>
                                    <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ old('date_debut') }}" required>
                                </div>

                                <!-- Montant total -->
                                <div class="form-group">
                                    <label for="montant_total" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-money-bill-wave mr-1 text-primary"></i>Montant total (FCFA)
                                    </label>
                                    <input type="number" name="montant_total" id="montant_total" class="form-control" value="{{ old('montant_total') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Libellé -->
                                <div class="form-group">
                                    <label for="libelle" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-tag mr-1 text-primary"></i>Libellé
                                    </label>
                                    <input type="text" name="libelle" id="libelle" class="form-control" value="{{ old('libelle') }}" required>
                                </div>

                                <!-- Date de fin -->
                                <div class="form-group">
                                    <label for="date_fin" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-calendar-check mr-1 text-primary"></i>Date de fin
                                    </label>
                                    <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ old('date_fin') }}" required>
                                </div>

                                <!-- Montant de base -->
                                <div class="form-group">
                                    <label for="montant_de_base" class="font-weight-bold text-gray-800">
                                        <i class="fas fa-coins mr-1 text-primary"></i>Montant de base (FCFA)
                                    </label>
                                    <input type="number" name="montant_de_base" id="montant_de_base" class="form-control" value="{{ old('montant_de_base') }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description" class="font-weight-bold text-gray-800">
                                <i class="fas fa-align-left mr-1 text-primary"></i>Description
                            </label>
                            <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                        </div>

                        <!-- Participants -->
                        <div class="form-group">
                            <label for="nbre_participant" class="font-weight-bold text-gray-800">
                                <i class="fas fa-users mr-1 text-primary"></i>Nombre de participants
                            </label>
                            <input type="number" name="nbre_participant" id="nbre_participant" class="form-control" value="{{ old('nbre_participant') }}" required>
                        </div>

                        <!-- Images -->
                        <div class="form-group">
                            <label for="images" class="font-weight-bold text-gray-800">
                                <i class="fas fa-images mr-1 text-primary"></i>Images (optionnel)
                            </label>
                            <div class="custom-file">
                                <input type="file" name="images[]" id="images" class="custom-file-input" multiple accept="image/*">
                                <label class="custom-file-label" for="images">Choisir des fichiers...</label>
                            </div>
                            <small class="form-text text-muted">Formats acceptés: JPEG, PNG, GIF. Taille max: 2MB par image.</small>
                        </div>

                        <!-- Boutons -->
                        <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                            <a href="{{ route('tontines.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Créer la tontine
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->

<style>
    .custom-file-label::after {
        content: "Parcourir";
    }
    .card {
        border-radius: 0.5rem;
    }
    .form-control, .custom-file-input {
        border-radius: 0.35rem;
    }
    textarea.form-control {
        min-height: 120px;
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
            label.textContent = 'Choisir des fichiers...';
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