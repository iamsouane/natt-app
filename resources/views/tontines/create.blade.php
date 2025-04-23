@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            background-color: #ffffff;
            animation: fadeInUp 0.6s ease;
        }

        .form-label {
            color: #0077b6;
            font-weight: 600;
        }

        .form-control {
            border-radius: 0.75rem;
            transition: 0.3s ease;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.05);
        }

        .form-control:focus {
            border-color: #0077b6;
            box-shadow: 0 0 0 0.2rem rgba(0, 119, 182, 0.2);
        }

        .btn-primary {
            background-color: #0077b6;
            border-color: #0077b6;
            border-radius: 0.75rem;
            padding: 0.6rem 2rem;
        }

        .btn-primary:hover {
            background-color: #005f87;
        }

        .btn-secondary {
            border-radius: 0.75rem;
        }

        h1 {
            font-weight: bold;
            color: #023e8a;
        }

        .svg-container {
            max-width: 250px;
            margin: 0 auto 1.5rem;
            display: flex;
            justify-content: center;
        }

        .illustration {
            width: 100%;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <div class="container py-5">
        <div class="svg-container">
            <!-- Illustration SVG moderne -->
            
        </div>

        <h1 class="text-center mb-4">🎯 Créer une Tontine</h1>

        @if ($errors->any())
            <div class="alert alert-danger rounded-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card p-4 mx-auto" style="max-width: 800px;">
            <form action="{{ route('tontines.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="frequence" class="form-label">Fréquence</label>
                    <select name="frequence" id="frequence" class="form-control" required>
                        <option value="JOURNALIERE" {{ old('frequence') === 'JOURNALIERE' ? 'selected' : '' }}>Journalière</option>
                        <option value="HEBDOMADAIRE" {{ old('frequence') === 'HEBDOMADAIRE' ? 'selected' : '' }}>Hebdomadaire</option>
                        <option value="MENSUELLE" {{ old('frequence') === 'MENSUELLE' ? 'selected' : '' }}>Mensuelle</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="libelle" class="form-label">Libellé</label>
                    <input type="text" name="libelle" id="libelle" class="form-control" value="{{ old('libelle') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="date_debut" class="form-label">Date de début</label>
                        <input type="date" name="date_debut" id="date_debut" class="form-control" value="{{ old('date_debut') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="date_fin" class="form-label">Date de fin</label>
                        <input type="date" name="date_fin" id="date_fin" class="form-control" value="{{ old('date_fin') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="montant_total" class="form-label">Montant total</label>
                        <input type="number" name="montant_total" id="montant_total" class="form-control" value="{{ old('montant_total') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="montant_de_base" class="form-label">Montant de base</label>
                        <input type="number" name="montant_de_base" id="montant_de_base" class="form-control" value="{{ old('montant_de_base') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="nbre_participant" class="form-label">Nombre de participants</label>
                    <input type="number" name="nbre_participant" id="nbre_participant" class="form-control" value="{{ old('nbre_participant') }}" required>
                </div>

                <hr class="my-4">

                <div class="mb-3">
                    <label for="images" class="form-label">Images de la tontine</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                    <small class="form-text text-muted">Vous pouvez sélectionner plusieurs fichiers (JPEG, PNG, etc.).</small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('tontines.index') }}" class="btn btn-secondary">Annuler</a>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
@endsection