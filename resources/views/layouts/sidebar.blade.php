<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Natt-app</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Accueil</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Affichage conditionnel pour SUPER_ADMIN et GERANT -->
    @auth
        @if (auth()->user()->profil === 'SUPER_ADMIN' || auth()->user()->profil === 'GERANT')
            <!-- Heading -->
            <div class="sidebar-heading">
                Gestion
            </div>

            <!-- Nav Item - Tontines -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tontines.index') }}">
                    <i class="fas fa-fw fa-coins"></i>
                    <span>Tontines</span>
                </a>
            </li>

            <!-- Nav Item - Tirages -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tirages.index') }}">
                    <i class="fas fa-fw fa-gift"></i>
                    <span>Tirages</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
        @endif

        <!-- Affichage conditionnel pour PARTICIPANT -->
        @if (auth()->user()->profil === 'PARTICIPANT')
            <!-- Heading -->
            <div class="sidebar-heading">
                Fonctionnalités du Participant
            </div>

            <!-- Nav Item - Voir Tontines -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('tontines.index') }}">
                    <i class="fas fa-fw fa-eye"></i>
                    <span>Voir Tontines</span>
                </a>
            </li>

            <!-- Nav Item - Voir Cotisations -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('participant.cotisations.index') }}">
                    <i class="fas fa-fw fa-eye"></i>
                    <span>Mes cotisations</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
        @endif
    @endauth

    <!-- Heading -->
    <div class="sidebar-heading">
        Authentification
    </div>

    <!-- Nav Item - Connexion -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('auth.create') }}">
            <i class="fas fa-fw fa-sign-in-alt"></i>
            <span>Connexion</span>
        </a>
    </li>

    <!-- Nav Item - Inscription -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('inscription.index') }}">
            <i class="fas fa-fw fa-user-plus"></i>
            <span>Inscription</span>
        </a>
    </li>

    <!-- Déconnexion -->
    @auth
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Nav Item - Déconnexion -->
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link btn btn-link" style="cursor: pointer;">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Déconnexion</span>
                </button>
            </form>
        </li>
    @endauth

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
