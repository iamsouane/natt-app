<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Heure et date -->
    <div class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 text-gray-600">
        <span id="datetime" class="font-weight-bold"></span>
    </div>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        @if(Auth::check())
        <!-- User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                @php
                    $image = Auth::user()->participant && Auth::user()->participant->image_cni 
                        ? asset('storage/' . Auth::user()->participant->image_cni) 
                        : asset('img/undraw_profile.svg');
                @endphp
                <img class="img-profile rounded-circle" src="{{ $image }}" width="40" height="40">
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
                <!-- Déconnexion avec formulaire POST -->
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Déconnexion
                </a>
            </div>
        </li>
        @endif
    </ul>
</nav>

<!-- Script pour afficher l'heure et la date -->
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