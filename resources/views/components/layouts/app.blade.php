<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal Resmi Desa {{ $villageProfile->nama_desa }}. Media informasi profil, aparatur desa, potensi UMKM lokal, destinasi wisata, komoditas unggulan, dan dokumentasi kegiatan warga desa.">
    <meta name="author" content="Pemerintah Desa {{ $villageProfile->nama_desa }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>Web Resmi {{ $villageProfile->nama_desa }} - Profil, Potensi, & Informasi Desa</title>
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Livewire Styles -->
    @livewireStyles
</head>
<body>

    <!-- Floating Navigation Bar -->
    <header class="navbar-wrapper">
        <nav class="navbar-container">
            <a href="/" class="nav-brand">
                @if($villageProfile->logo_path)
                    <img src="{{ asset('storage/' . $villageProfile->logo_path) }}" alt="Logo {{ $villageProfile->nama_desa }}" class="nav-logo" id="village-logo-nav">
                @else
                    <!-- SVG Default Emblem/Logo -->
                    <svg class="nav-logo" id="village-logo-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary); height: 36px; width: 36px;">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                @endif
                <div>
                    <span style="font-weight: 800; font-size: 1.2rem; display: block; line-height: 1;">{{ $villageProfile->nama_desa }}</span>
                    <span style="font-size: 0.75rem; color: var(--text-secondary); font-weight: 500;">Portal Resmi & Profil</span>
                </div>
            </a>

            <ul class="nav-links">
                <li><a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda & Profil</a></li>
                <li><a href="{{ route('officials') }}" class="nav-link {{ request()->routeIs('officials') ? 'active' : '' }}">Aparat Desa</a></li>
                <li><a href="{{ route('potencies') }}" class="nav-link {{ request()->routeIs('potencies') ? 'active' : '' }}">Potensi & UMKM</a></li>
                <li><a href="{{ route('galleries') }}" class="nav-link {{ request()->routeIs('galleries') ? 'active' : '' }}">Galeri Kegiatan</a></li>
            </ul>

            <button class="mobile-menu-toggle" id="mobile-menu-btn" aria-label="Toggle Menu">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </nav>
    </header>

    <!-- Main Dynamic Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <!-- Brand Column -->
            <div class="footer-brand">
                <div class="footer-logo-wrapper">
                    @if($villageProfile->logo_path)
                        <img src="{{ asset('storage/' . $villageProfile->logo_path) }}" alt="Logo {{ $villageProfile->nama_desa }}" class="footer-logo">
                    @else
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--primary); height: 40px; width: 40px; background-color: var(--primary-light); padding: 8px; border-radius: 8px;">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    @endif
                    <span>{{ $villageProfile->nama_desa }}</span>
                </div>
                <p class="footer-desc">
                    Website Resmi Pemerintah {{ $villageProfile->nama_desa }}. Media komunikasi dua arah untuk transparansi data pemerintahan dan promosi komoditas lokal desa.
                </p>
                <div style="margin-top: 1rem; color: var(--text-light); font-size: 0.85rem;">
                    © {{ date('Y') }} {{ $villageProfile->nama_desa }}. Hak Cipta Dilindungi.
                </div>
            </div>

            <!-- Links Column -->
            <div class="footer-links">
                <h3>Navigasi</h3>
                <ul class="footer-links-list">
                    <li><a href="{{ route('home') }}">Beranda & Profil</a></li>
                    <li><a href="{{ route('officials') }}">Aparat Desa</a></li>
                    <li><a href="{{ route('potencies') }}">Potensi & UMKM</a></li>
                    <li><a href="{{ route('galleries') }}">Galeri Kegiatan</a></li>
                    <li><a href="/admin" target="_blank" style="color: var(--primary);">Login Admin Panel →</a></li>
                </ul>
            </div>

            <!-- Contact Column -->
            <div class="footer-contact">
                <h3>Hubungi Kami</h3>
                <ul class="footer-contact-list">
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <div>
                            <strong>Alamat Kantor</strong>
                            <p style="margin-top: 0.25rem; font-size: 0.9rem;">{{ $villageProfile->alamat ?: 'Kantor Desa, Kec. Banyumanik' }}</p>
                        </div>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <div>
                            <strong>Email Resmi</strong>
                            <p style="margin-top: 0.25rem; font-size: 0.9rem;">{{ $villageProfile->email ?: 'info@desa.go.id' }}</p>
                        </div>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <div>
                            <strong>No. Telepon</strong>
                            <p style="margin-top: 0.25rem; font-size: 0.9rem;">{{ $villageProfile->telepon ?: '0812-3456-7890' }}</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div>
                Website Desa dikembangkan dengan <strong>Laravel, Filament, & Livewire</strong>.
            </div>
            <div>
                Platform Monolith Stabil & Minim Pemeliharaan.
            </div>
        </div>
    </footer>

    <!-- Mobile Navigation Overlay (Toggle via simple JS) -->
    <div id="mobile-menu-overlay" style="display: none; position: fixed; inset: 0; background: rgba(15,23,42,0.95); z-index: 999; flex-direction: column; justify-content: center; align-items: center; gap: 2rem;">
        <button id="close-mobile-menu" style="position: absolute; top: 2rem; right: 2rem; background: none; border: none; color: white;">
            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
        <a href="{{ route('home') }}" style="color: white; font-size: 1.5rem; font-weight: 700;">Beranda & Profil</a>
        <a href="{{ route('officials') }}" style="color: white; font-size: 1.5rem; font-weight: 700;">Aparat Desa</a>
        <a href="{{ route('potencies') }}" style="color: white; font-size: 1.5rem; font-weight: 700;">Potensi & UMKM</a>
        <a href="{{ route('galleries') }}" style="color: white; font-size: 1.5rem; font-weight: 700;">Galeri Kegiatan</a>
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Mobile Navigation JS Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const closeBtn = document.getElementById('close-mobile-menu');
            const overlay = document.getElementById('mobile-menu-overlay');

            if (menuBtn && overlay && closeBtn) {
                menuBtn.addEventListener('click', () => {
                    overlay.style.display = 'flex';
                });
                closeBtn.addEventListener('click', () => {
                    overlay.style.display = 'none';
                });
                overlay.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        overlay.style.display = 'none';
                    });
                });
            }
        });
    </script>
</body>
</html>
