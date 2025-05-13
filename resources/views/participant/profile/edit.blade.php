@extends('layouts.app')

@section('title', 'Modifier mon profil - NATT-APP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Card Header -->
            <div class="d-flex align-items-center mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mr-3">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <h2 class="mb-0 text-primary font-weight-bold">
                    <i class="fas fa-user-edit mr-2"></i>Modifier mon profil
                </h2>
            </div>

            <!-- Profile Card -->
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Success Message -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-2x mr-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">Succès!</h5>
                                    <p class="mb-0">{{ session('success') }}</p>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle fa-2x mr-3"></i>
                                <div>
                                    <h5 class="alert-heading mb-1">Erreurs!</h5>
                                    <ul class="mb-0 pl-3">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('participant.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Profile Picture -->
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="profile-picture-wrapper mx-auto">
                                    @if($user->participant && $user->participant->image_cni)
                                        <img src="{{ asset('storage/' . $user->participant->image_cni) }}" 
                                             id="profileImage" 
                                             class="img-fluid rounded-circle shadow" 
                                             alt="Photo de profil">
                                    @else
                                        <div class="profile-default bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">
                                            <i class="fas fa-user fa-3x"></i>
                                        </div>
                                    @endif
                                    <label for="image" class="btn btn-sm btn-primary mt-3">
                                        <i class="fas fa-camera mr-2"></i>Changer
                                    </label>
                                    <input type="file" name="image" id="image" class="d-none" accept="image/*">
                                </div>
                            </div>

                            <!-- Form Fields -->
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="nom" class="font-weight-bold">Nom</label>
                                    <input type="text" 
                                           id="nom" 
                                           name="nom" 
                                           class="form-control form-control-lg" 
                                           value="{{ old('nom', $user->nom) }}" 
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="prenom" class="font-weight-bold">Prénom</label>
                                    <input type="text" 
                                           id="prenom" 
                                           name="prenom" 
                                           class="form-control form-control-lg" 
                                           value="{{ old('prenom', $user->prenom) }}" 
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="email" class="font-weight-bold">Email</label>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           class="form-control form-control-lg" 
                                           value="{{ old('email', $user->email) }}" 
                                           required
                                           disabled>
                                    <small class="text-muted">Contactez l'administrateur pour modifier votre email</small>
                                </div>

                                <hr class="my-4">

                                <h5 class="font-weight-bold mb-3">
                                    <i class="fas fa-lock mr-2"></i>Modifier le mot de passe
                                </h5>

                                <div class="form-group">
                                    <label for="current_password" class="font-weight-bold">Mot de passe actuel</label>
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password" 
                                           class="form-control" 
                                           placeholder="Entrez votre mot de passe actuel">
                                </div>

                                <div class="form-group">
                                    <label for="password" class="font-weight-bold">Nouveau mot de passe</label>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control" 
                                           placeholder="Laissez vide si inchangé">
                                </div>

                                <div class="form-group mb-4">
                                    <label for="password_confirmation" class="font-weight-bold">Confirmation</label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="form-control" 
                                           placeholder="Confirmez le nouveau mot de passe">
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-block shadow-sm">
                                    <i class="fas fa-save mr-2"></i>Enregistrer les modifications
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .profile-picture-wrapper {
        width: 200px;
        height: 200px;
        position: relative;
    }

    .profile-picture-wrapper img,
    .profile-default {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border: 5px solid #fff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .profile-default {
        font-size: 5rem;
    }

    .form-control-lg {
        border-radius: 0.5rem;
        padding: 1rem 1.25rem;
    }

    .card {
        border-radius: 1rem;
        overflow: hidden;
        border: none;
    }

    .alert {
        border-radius: 0.75rem;
        border-left: 5px solid;
    }

    .alert-success {
        border-left-color: #28a745;
    }

    .alert-danger {
        border-left-color: #dc3545;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview image before upload
        const profileImage = document.getElementById('profileImage');
        const imageInput = document.getElementById('image');
        
        if (imageInput && profileImage) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        profileImage.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Password toggle visibility
        const passwordFields = ['current_password', 'password', 'password_confirmation'];
        
        passwordFields.forEach(field => {
            const input = document.getElementById(field);
            if (input) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('input-group-append');
                
                const toggleBtn = document.createElement('button');
                toggleBtn.classList.add('btn', 'btn-outline-secondary');
                toggleBtn.type = 'button';
                toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
                
                toggleBtn.addEventListener('click', function() {
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
                });

                input.parentNode.classList.add('input-group');
                wrapper.appendChild(toggleBtn);
                input.parentNode.appendChild(wrapper);
            }
        });
    });
</script>
@endsection