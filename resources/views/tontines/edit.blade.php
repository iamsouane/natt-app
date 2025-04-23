@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Illustration en haut --}}
        <div class="text-center mb-4">
            <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#0d6efd" viewBox="0 0 24 24">
                <path fill-rule="evenodd" d="M11.32 6.176H5c-1.105 0-2 .949-2 2.118v10.588C3 20.052 3.895 21 5 21h11c1.105 0 2-.948 2-2.118v-7.75l-3.914 4.144A2.46 2.46 0 0 1 12.81 16l-2.681.568c-1.75.37-3.292-1.263-2.942-3.115l.536-2.839c.097-.512.335-.983.684-1.352l2.914-3.086Z" clip-rule="evenodd"/>
                <path fill-rule="evenodd" d="M19.846 4.318a2.148 2.148 0 0 0-.437-.692 2.014 2.014 0 0 0-.654-.463 1.92 1.92 0 0 0-1.544 0 2.014 2.014 0 0 0-.654.463l-.546.578 2.852 3.02.546-.579a2.14 2.14 0 0 0 .437-.692 2.244 2.244 0 0 0 0-1.635ZM17.45 8.721 14.597 5.7 9.82 10.76a.54.54 0 0 0-.137.27l-.536 2.84c-.07.37.239.696.588.622l2.682-.567a.492.492 0 0 0 .255-.145l4.778-5.06Z" clip-rule="evenodd"/>
              </svg>                          
        </div>

        <div class="bg-white shadow-lg rounded-3 p-4">
            <h2 class="mb-4 text-primary">Modifier la Tontine : <strong>{{ $tontine->libelle }}</strong></h2>

            <form action="{{ route('tontines.update', $tontine) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group mb-3">
                    <label for="libelle" class="form-label">Libellé</label>
                    <input type="text" class="form-control rounded-pill shadow-sm" id="libelle" name="libelle" value="{{ old('libelle', $tontine->libelle) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="frequence" class="form-label">Fréquence</label>
                    <select class="form-control rounded-pill shadow-sm" id="frequence" name="frequence" required>
                        <option value="JOURNALIERE" {{ old('frequence', $tontine->frequence) == 'JOURNALIERE' ? 'selected' : '' }}>Journalière</option>
                        <option value="HEBDOMADAIRE" {{ old('frequence', $tontine->frequence) == 'HEBDOMADAIRE' ? 'selected' : '' }}>Hebdomadaire</option>
                        <option value="MENSUELLE" {{ old('frequence', $tontine->frequence) == 'MENSUELLE' ? 'selected' : '' }}>Mensuelle</option>
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label for="date_debut" class="form-label">Date de début</label>
                    <input type="date" class="form-control rounded-pill shadow-sm" id="date_debut" name="date_debut" value="{{ old('date_debut', $tontine->date_debut) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="date_fin" class="form-label">Date de fin</label>
                    <input type="date" class="form-control rounded-pill shadow-sm" id="date_fin" name="date_fin" value="{{ old('date_fin', $tontine->date_fin) }}" required>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control rounded shadow-sm" id="description" name="description" rows="3" required>{{ old('description', $tontine->description) }}</textarea>
                </div>

                <div class="form-group mb-3">
                    <label for="montant_total" class="form-label">Montant total</label>
                    <input type="number" class="form-control rounded-pill shadow-sm" id="montant_total" name="montant_total" value="{{ old('montant_total', $tontine->montant_total) }}" required min="1">
                </div>

                <div class="form-group mb-3">
                    <label for="montant_de_base" class="form-label">Montant de base</label>
                    <input type="number" class="form-control rounded-pill shadow-sm" id="montant_de_base" name="montant_de_base" value="{{ old('montant_de_base', $tontine->montant_de_base) }}" required min="1">
                </div>

                <div class="form-group mb-3">
                    <label for="nbre_participant" class="form-label">Nombre de participants</label>
                    <input type="number" class="form-control rounded-pill shadow-sm" id="nbre_participant" name="nbre_participant" value="{{ old('nbre_participant', $tontine->nbre_participant) }}" required min="1">
                </div>

                <div class="form-group mb-4">
                    <label for="images" class="form-label">Images (optionnelles)</label>
                    <input type="file" class="form-control-file" id="images" name="images[]" multiple>
                    @if ($tontine->images->count())
                        <p class="mt-2 text-muted">Images actuelles :</p>
                        <div class="row">
                            @foreach ($tontine->images as $image)
                                <div class="col-md-3 mb-2">
                                    <img src="{{ asset('storage/tontines/' . $image->nom_image) }}" class="img-fluid rounded shadow-sm" style="height: 100px;" data-toggle="modal" data-target="#imageModal" onclick="document.getElementById('modalImage').src='{{ asset('storage/tontines/' . $image->nom_image) }}'">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Mettre à jour</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary rounded-pill px-4">Retour</a>
                </div>
            </form>
        </div>

        {{-- Modale --}}
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Aperçu de l'image</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Image" class="img-fluid rounded shadow-sm" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection