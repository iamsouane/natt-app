<!-- NAVBAR -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Heure et date -->
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-4 my-2 my-md-0 mw-100 text-gray-600">
        <span id="datetime" class="font-weight-bold"></span>
    </div>

    <!-- TOPBAR NAVBAR -->
    <ul class="navbar-nav ml-auto">
        @if(Auth::check())
        <!-- PROFIL UTILISATEUR CONNECTÉ -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                @php
                    $photoProfil = Auth::user()->participant && Auth::user()->participant->image_cni
                        ? asset('storage/' . Auth::user()->participant->image_cni)
                        : asset('img/undraw_profile.svg');
                @endphp
                <img class="img-profile rounded-circle" src="{{ $photoProfil }}" alt="Photo de profil">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">
                <a class="dropdown-item" href="{{ route('participant.profile.edit') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>
                <a class="dropdown-item" href="{{ route('participant.historique') }}">
                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                    Historique
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Déconnexion
                </a>
            </div>
        </li>
        @endif
    </ul>
</nav>

<!-- LOGOUT MODAL -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Prêt à partir ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à terminer votre session actuelle.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Déconnexion</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SCRIPT DATE ET HEURE -->
<script>
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        };
        document.getElementById('datetime').textContent = now.toLocaleDateString('fr-FR', options);
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

<!-- STYLES CSS -->
<style>
    .navbar {
        background-color: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        padding: 0.8rem 1.5rem;
        font-family: 'Segoe UI', sans-serif;
        z-index: 1001;
    }

    #datetime {
        font-size: 1.1rem;
        color: #0077b6;
        text-shadow: 0 0 3px rgba(0, 119, 182, 0.3);
        font-weight: 600;
        transition: transform 0.3s ease, color 0.3s ease;
    }

    #datetime:hover {
        transform: scale(1.05);
        color: #005f7f;
    }

    .navbar .navbar-nav .nav-link span {
        font-weight: 600;
        font-size: 0.95rem;
    }

    .img-profile {
        width: 48px !important;
        height: 48px !important;
        object-fit: cover;
        border: 2px solid #0077b6;
        box-shadow: 0 2px 4px rgba(0, 119, 182, 0.2);
        transition: transform 0.3s ease;
    }

    .img-profile:hover {
        transform: scale(1.05);
    }

    .dropdown-menu {
        border-radius: 10px;
        padding: 0.5rem 0;
        animation: fadeIn 0.3s ease-in-out;
    }

    .dropdown-item i {
        color: #0077b6;
    }

    .dropdown-item:hover {
        background-color: #f0f8ff;
        color: #0077b6;
    }

    @keyframes fadeIn {
        0% { opacity: 0; transform: translateY(-10px); }
        100% { opacity: 1; transform: translateY(0); }
    }
</style>