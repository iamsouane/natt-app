<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Rechercher..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        @if(Auth::check())
        <!-- Notifications -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                @php
                    $unreadNotifications = Auth::user()->unreadNotifications()->latest()->limit(5)->get();
                @endphp
                @if($unreadNotifications->count() > 0)
                    <span class="badge badge-danger badge-counter">{{ $unreadNotifications->count() }}</span>
                @endif
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notifications récentes
                </h6>

                @forelse($unreadNotifications as $notification)
                <a class="dropdown-item d-flex align-items-center" 
                   href="{{ route('notifications.index') }}"
                   onclick="event.preventDefault(); document.getElementById('mark-as-read-{{ $notification->id }}').submit();">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-info text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">{{ $notification->created_at->format('d/m/Y H:i') }}</div>
                        <span class="font-weight-bold">{{ $notification->data['message'] ?? 'Aucun message disponible' }}</span>
                    </div>
                </a>
                <form id="mark-as-read-{{ $notification->id }}" method="POST" action="{{ route('notifications.markAsRead', $notification->id) }}" style="display: none;">
                    @csrf
                    @method('PATCH')
                </form>
                @empty
                <span class="dropdown-item text-center small text-gray-500">Aucune notification non lue</span>
                @endforelse

                <a class="dropdown-item text-center small text-primary" href="{{ route('notifications.index') }}">Voir toutes les notifications</a>
            </div>
        </li>

        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profil
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Paramètres
                </a>
                <a class="dropdown-item" href="#">
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