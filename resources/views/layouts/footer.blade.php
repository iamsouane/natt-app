<footer class="sticky-footer bg-white border-top py-3">
    <div class="container">
        <div class="row align-items-center justify-content-between text-center text-md-left">
            <!-- Texte à gauche -->
            <div class="col-md-6 mb-3 mb-md-0">
                <span class="text-muted">&copy; {{ now()->year }} <strong>NATT - APP</strong>. Tous droits réservés.</span>
            </div>

            <!-- Liens à droite -->
            <div class="col-md-6 text-md-right">
                <a href="{{ route('about') }}" class="text-primary mx-3 hover-text-dark">À propos</a>
                <a href="{{ route('contact') }}" class="text-primary mx-3 hover-text-dark">Contact</a>
                <a href="{{ route('politique') }}" class="text-primary mx-3 hover-text-dark">Politique de confidentialité</a>
            </div>
        </div>
    </div>
</footer>