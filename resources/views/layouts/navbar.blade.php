<!-- NAVBAR -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm" style="height: 70px;">

    <!-- Sidebar Toggle (Topbar) - Mobile -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fas fa-bars text-primary"></i>
    </button>

    <!-- Logo & App Name - Mobile -->
    <a class="navbar-brand d-md-none" href="{{ route('home') }}">
        <img src="{{ asset('img/natt_app.png') }}" alt="Logo" style="height: 40px;">
    </a>

    <!-- Search Bar - Desktop -->
    <div class="d-none d-md-inline-block form-inline ml-3 mr-auto">
        <div class="input-group" style="width: 300px;">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..." 
                   aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- TOPBAR NAVBAR -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Date & Time -->
        <div class="d-none d-sm-inline-block mx-3">
            <div class="text-center">
                <div id="current-date" class="text-primary font-weight-bold small"></div>
                <div id="current-time" class="text-gray-600 font-weight-bold"></div>
            </div>
        </div>

        <!-- User Dropdown -->
        @auth
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="d-none d-lg-inline mr-2 text-right">
                    <div class="text-primary font-weight-bold small">{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</div>
                    <div class="text-gray-600 small">
                        @if(Auth::user()->profil === 'SUPER_ADMIN')
                            Super Admin
                        @elseif(Auth::user()->profil === 'GERANT')
                            Gérant
                        @else
                            Participant
                        @endif
                    </div>
                </div>
                @if(Auth::user()->participant && Auth::user()->participant->image_cni)
                    <img class="img-profile rounded-circle shadow-sm" src="{{ asset('storage/' . Auth::user()->participant->image_cni) }}" 
                         alt="Photo de profil" style="width: 45px; height: 45px; object-fit: cover;">
                @else
                    <div class="img-profile rounded-circle shadow-sm" style="width: 45px; height: 45px; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="#4e73df"/>
                            <path d="M12 6C9.79 6 8 7.79 8 10C8 12.21 9.79 14 12 14C14.21 14 16 12.21 16 10C16 7.79 14.21 6 12 6ZM12 12C10.9 12 10 11.1 10 10C10 8.9 10.9 8 12 8C13.1 8 14 8.9 14 10C14 11.1 13.1 12 12 12Z" fill="#4e73df"/>
                            <path d="M12 16C9.33 16 4 17.34 4 20V22H20V20C20 17.34 14.67 16 12 16ZM6 20C6.22 19.28 9.31 18 12 18C14.7 18 17.8 19.29 18 20H6Z" fill="#4e73df"/>
                        </svg>
                    </div>
                @endif
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                @if(auth()->user()->profil === 'PARTICIPANT')
                    <a class="dropdown-item" href="{{ route('participant.profile.edit') }}">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profil
                    </a>
                @else
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profil (Admin)
                    </a>
                @endif

                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Paramètres
                </a>
                
                @if(auth()->user()->profil === 'PARTICIPANT')
                    <a class="dropdown-item" href="{{ route('participant.historique') }}">
                        <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                        Historique
                    </a>
                @endif
                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Déconnexion
                </a>
            </div>
        </li>
        @else
        <li class="nav-item">
            <a href="{{ route('auth.create') }}" class="btn btn-primary btn-sm px-3">
                <i class="fas fa-sign-in-alt mr-2"></i>Connexion
            </a>
        </li>
        @endauth
    </ul>
</nav>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Prêt à partir ?</h5>
                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <i class="fas fa-sign-out-alt fa-3x text-gray-400 mb-3"></i>
                    <p>Sélectionnez "Déconnexion" ci-dessous si vous êtes prêt à mettre fin à votre session actuelle.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Navbar Styles */
    .navbar {
        transition: all 0.3s;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .img-profile {
        transition: all 0.3s;
        border: 2px solid rgba(78, 115, 223, 0.3);
    }
    
    .img-profile:hover {
        transform: scale(1.1);
        border-color: #4e73df;
    }
    
    .icon-circle {
        height: 2.5rem;
        width: 2.5rem;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    // Update date and time
    function updateDateTime() {
        const now = new Date();
        
        // Date options
        const dateOptions = { 
            weekday: 'long', 
            day: 'numeric', 
            month: 'long', 
            year: 'numeric' 
        };
        
        // Time options
        const timeOptions = { 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit' 
        };
        
        document.getElementById('current-date').textContent = now.toLocaleDateString('fr-FR', dateOptions);
        document.getElementById('current-time').textContent = now.toLocaleTimeString('fr-FR', timeOptions);
    }
    
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>