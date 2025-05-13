<footer class="sticky-footer bg-white border-top py-4">
    <div class="container">
        <div class="row align-items-center justify-content-between flex-column flex-md-row">
            <!-- Copyright -->
            <div class="col-md-6 mb-3 mb-md-0 text-center text-md-left">
                <span class="text-muted">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="d-inline align-middle mr-1">
                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="#4e73df"/>
                        <path d="M12 17C11.45 17 11 16.55 11 16V12C11 11.45 11.45 11 12 11C12.55 11 13 11.45 13 12V16C13 16.55 12.55 17 12 17Z" fill="#4e73df"/>
                        <path d="M12 9C11.45 9 11 8.55 11 8C11 7.45 11.45 7 12 7C12.55 7 13 7.45 13 8C13 8.55 12.55 9 12 9Z" fill="#4e73df"/>
                    </svg>
                    <span class="align-middle">&copy; {{ now()->year }} <strong class="text-primary">NATT-APP</strong>. Tous droits réservés.</span>
                </span>
            </div>

            <!-- Liens de navigation -->
            <div class="col-md-6 text-center text-md-right">
                <div class="d-inline-flex flex-wrap justify-content-center justify-content-md-end">
                    <a href="{{ route('about') }}" class="footer-link mx-3 my-1">
                        À propos
                    </a>
                    <span class="text-muted d-none d-md-inline">|</span>
                    <a href="{{ route('contact') }}" class="footer-link mx-3 my-1">
                        Contact
                    </a>
                    <span class="text-muted d-none d-md-inline">|</span>
                    <a href="{{ route('politique') }}" class="footer-link mx-3 my-1">
                        Confidentialité
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    .sticky-footer {
        box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }
    
    .footer-link {
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .footer-link:hover {
        color: #4e73df;
    }
    
    .footer-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: #4e73df;
        transition: width 0.3s ease;
    }
    
    .footer-link:hover::after {
        width: 100%;
    }
    
    @media (max-width: 768px) {
        .footer-link {
            margin: 0.5rem 1rem;
        }
    }
</style>