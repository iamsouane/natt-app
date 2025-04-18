<footer class="sticky-footer bg-white border-top py-3">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-between text-center text-md-left">
            <div class="col-md-6 mb-2 mb-md-0">
                <span class="text-muted">&copy; {{ now()->year }} <strong>NATT - APP</strong>. Tous droits réservés.</span>
            </div>
            <div class="col-md-6 text-md-right">
                <a href="{{ route('about') }}" class="text-muted mx-2">À propos</a>
                <a href="{{ route('contact') }}" class="text-muted mx-2">Contact</a>
                <a href="{{ route('politique') }}" class="text-muted mx-2">Politique de confidentialité</a>
            </div>
        </div>
    </div>
</footer>