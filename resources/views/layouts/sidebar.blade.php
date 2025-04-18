<ul class="navbar-nav bg-gradient-modern sidebar sidebar-dark accordion shadow" id="accordionSidebar" style="background: linear-gradient(135deg, #0077b6, #00b4d8);">

    <!-- Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-4" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/natt_app.png') }}" alt="Logo NATT-APP" style="width: 40px; height: 40px;" class="rounded-circle shadow-sm bg-white p-1">
        </div>
        <div class="sidebar-brand-text mx-3 fw-bold text-white">NATT-APP</div>
    </a>

    <hr class="sidebar-divider my-0">

    <!-- Accueil -->
    <li class="nav-item">
        <a class="nav-link d-flex align-items-center" href="{{ route('home') }}">
            <i class="fas fa-home fa-fw me-2"></i>
            <span>Accueil</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    @auth
        @if (auth()->user()->profil === 'SUPER_ADMIN' || auth()->user()->profil === 'GERANT')
            <div class="sidebar-heading text-uppercase small text-white-50">
                Espace Admin
            </div>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="{{ route('tontines.index') }}">
                    <i class="fas fa-coins fa-fw me-2"></i>
                    <span>Tontines</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="{{ route('tirages.index') }}">
                    <i class="fas fa-gift fa-fw me-2"></i>
                    <span>Tirages</span>
                </a>
            </li>

            <hr class="sidebar-divider">
        @endif

        @if (auth()->user()->profil === 'PARTICIPANT')
            <div class="sidebar-heading text-uppercase small text-white-50">
                Espace Participant
            </div>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="{{ route('participant.index') }}">
                    <i class="fas fa-eye fa-fw me-2"></i>
                    <span>Voir Tontines</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link d-flex align-items-center" href="{{ route('participant.cotisations.index') }}">
                    <i class="fas fa-wallet fa-fw me-2"></i>
                    <span>Mes Cotisations</span>
                </a>
            </li>

            <hr class="sidebar-divider">
        @endif
    @endauth

    @guest
        <div class="sidebar-heading text-uppercase small text-white-50">
            Authentification
        </div>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="{{ route('auth.create') }}">
                <i class="fas fa-sign-in-alt fa-fw me-2"></i>
                <span>Connexion</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="{{ route('inscription.index') }}">
                <i class="fas fa-user-plus fa-fw me-2"></i>
                <span>Inscription</span>
            </a>
        </li>
    @endguest

    @auth
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a class="nav-link d-flex align-items-center text-danger" href="#" data-toggle="modal" data-target="#logoutModal">
                <i class="fas fa-sign-out-alt fa-fw me-2"></i>
                <span>Déconnexion</span>
            </a>
        </li>
    @endauth

    <hr class="sidebar-divider d-none d-md-block">

    <!-- Toggle Button -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0 bg-light" id="sidebarToggle"></button>
    </div>
</ul>