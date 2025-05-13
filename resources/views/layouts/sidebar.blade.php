<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background: linear-gradient(135deg, #224abe 0%, #4e73df 100%);">

    <!-- Brand Logo -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-4" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <div class="position-relative">
                <img src="{{ asset('img/natt_app.png') }}" alt="Logo NATT-APP" 
                     class="rounded-circle shadow-lg" 
                     style="width: 50px; height: 50px; border: 2px solid rgba(255,255,255,0.2);">
                <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                    <span class="visually-hidden">Nouveautés</span>
                </span>
            </div>
        </div>
        <div class="sidebar-brand-text mx-2">
            <span class="fw-bold" style="font-size: 1.1rem;">NATT-APP</span>
            <small class="d-block text-white-50" style="font-size: 0.7rem; line-height: 1;">Gestion de tontines</small>
        </div>
    </a>

    <hr class="sidebar-divider my-0 bg-white-10">

    <!-- Accueil -->
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center py-3" href="{{ route('home') }}">
            <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                <i class="fas fa-home fa-sm text-white"></i>
            </div>
            <span class="fw-medium">Accueil</span>
        </a>
    </li>

    <hr class="sidebar-divider bg-white-10">

    @auth
        @if (auth()->user()->profil === 'SUPER_ADMIN' || auth()->user()->profil === 'GERANT')
            <!-- Section Admin -->
            <div class="sidebar-heading px-3 py-2 text-uppercase small text-white-50 fw-bold">
                <i class="fas fa-lock-open me-1"></i> Administration
            </div>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center py-3" href="{{ route('tontines.index') }}">
                    <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-coins fa-sm text-white"></i>
                    </div>
                    <span>Tontines</span>
                    <span class="badge bg-info ms-auto">New</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center py-3" href="{{ route('tirages.index') }}">
                    <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-gift fa-sm text-white"></i>
                    </div>
                    <span>Tirages</span>
                </a>
            </li>

            <hr class="sidebar-divider bg-white-10">
        @endif

        @if (auth()->user()->profil === 'PARTICIPANT')
            <!-- Section Participant -->
            <div class="sidebar-heading px-3 py-2 text-uppercase small text-white-50 fw-bold">
                <i class="fas fa-user-circle me-1"></i> Mon Espace
            </div>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center py-3" href="{{ route('participant.index') }}">
                    <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-eye fa-sm text-white"></i>
                    </div>
                    <span>Mes Tontines</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center py-3" href="{{ route('participant.cotisations.index') }}">
                    <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-wallet fa-sm text-white"></i>
                    </div>
                    <span>Cotisations</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center py-3" href="{{ route('participant.historique') }}">
                    <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="fas fa-history fa-sm text-white"></i>
                    </div>
                    <span>Historique</span>
                </a>
            </li>

            <hr class="sidebar-divider bg-white-10">
        @endif
    @endauth

    @guest
        <!-- Section Invité -->
        <div class="sidebar-heading px-3 py-2 text-uppercase small text-white-50 fw-bold">
            <i class="fas fa-door-open me-1"></i> Accès
        </div>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center py-3" href="{{ route('auth.create') }}">
                <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-sign-in-alt fa-sm text-white"></i>
                </div>
                <span>Connexion</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center py-3" href="{{ route('inscription.index') }}">
                <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-user-plus fa-sm text-white"></i>
                </div>
                <span>Inscription</span>
                <span class="badge bg-success ms-auto">Nouveau</span>
            </a>
        </li>
    @endguest

    @auth
        <!-- Section Compte -->
        <div class="sidebar-heading px-3 py-2 text-uppercase small text-white-50 fw-bold">
            <i class="fas fa-cog me-1"></i> Compte
        </div>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center py-3" href="{{ 
                auth()->user()->profil === 'PARTICIPANT' ? 
                route('participant.profile.edit') : 
                '#' 
            }}">
                <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-user-cog fa-sm text-white"></i>
                </div>
                <span>Profil</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center py-3 text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                <div class="icon-circle bg-white-10 me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="fas fa-sign-out-alt fa-sm text-danger"></i>
                </div>
                <span>Déconnexion</span>
            </a>
        </li>
    @endauth

    <hr class="sidebar-divider d-none d-md-block bg-white-10">

    <!-- Toggle Button -->
    <div class="text-center d-none d-md-inline py-3">
        <button class="rounded-circle border-0 bg-white-10 text-white" id="sidebarToggle" style="width: 40px; height: 40px;">
            <i class="fas fa-angle-double-left"></i>
        </button>
    </div>
</ul>

<style>
    .sidebar {
        transition: all 0.3s ease;
    }
    
    .sidebar-brand {
        transition: all 0.3s ease;
    }
    
    .sidebar-brand:hover {
        transform: scale(1.05);
    }
    
    .icon-circle {
        transition: all 0.2s ease;
    }
    
    .nav-item:hover .icon-circle {
        background: rgba(255,255,255,0.2) !important;
        transform: scale(1.1);
    }
    
    .nav-link {
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
    }
    
    .nav-link:hover {
        background: rgba(255,255,255,0.05);
        border-left: 3px solid #fff;
    }
    
    .nav-link.active {
        background: rgba(255,255,255,0.1);
        border-left: 3px solid #fff;
    }
    
    .bg-white-10 {
        background: rgba(255,255,255,0.1);
    }
</style>

<script>
    // Activer les tooltips
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

    // Gérer l'état actif des liens
    document.querySelectorAll('.nav-link').forEach(link => {
        if(link.href === window.location.href) {
            link.classList.add('active');
        }
    });
</script>