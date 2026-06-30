<div>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-container">
            <div class="hero-text">
                <span class="section-tag">Selamat Datang di Portal Resmi</span>
                <h1>Desa <span>{{ $profile->nama_desa }}</span></h1>
                <p>{{ $profile->visi ?: 'Mewujudkan desa yang mandiri, berdaya saing, sejahtera, dan menjunjung gotong-royong.' }}</p>
                <div class="hero-buttons">
                    <a href="#profil" class="btn btn-primary">
                        Tentang Desa
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg>
                    </a>
                    <a href="{{ route('potencies') }}" class="btn btn-secondary">Jelajahi UMKM & Wisata</a>
                </div>
            </div>
            <div class="hero-graphics">
                <div class="hero-circle">
                    @if($profile->logo_path)
                        <img src="{{ asset('storage/' . $profile->logo_path) }}" alt="Logo {{ $profile->nama_desa }}">
                    @else
                        <!-- Decorative farming/rural background if logo is not uploaded -->
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; background:rgba(255,255,255,0.2); color:white; font-size:1.5rem; font-weight:800; text-shadow:0 2px 4px rgba(0,0,0,0.2);">
                            Pemerintah Desa
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Profil & Sejarah Section -->
    <section id="profil" class="section" style="background-color: white; border-top: 1px solid var(--border-color);">
        <div class="section-container">
            <div class="section-header">
                <span class="section-tag">Profil Singkat</span>
                <h2 class="section-title">Sejarah & Visi Misi</h2>
                <p class="section-subtitle">Mengenal lebih dekat latar belakang dan cita-cita luhur Desa {{ $profile->nama_desa }}.</p>
            </div>

            <div class="profile-grid">
                <div class="history-text">
                    <h3 style="font-size: 1.75rem; font-weight: 800; color: var(--secondary); margin-bottom: 1.5rem;">Sejarah Singkat</h3>
                    <div style="color: var(--text-secondary); line-height: 1.8;">
                        @if($profile->sejarah)
                            {!! $profile->sejarah !!}
                        @else
                            <p>Sejarah Desa {{ $profile->nama_desa }} sedang dalam proses penyusunan oleh staf pemerintah desa.</p>
                        @endif
                    </div>
                </div>

                <div class="vision-mission-card">
                    <div class="visi-wrapper">
                        <h3 class="vm-title">Visi Desa</h3>
                        <p class="visi-content">
                            "{{ $profile->visi ?: 'Mewujudkan desa yang mandiri, sejahtera, amanah, dan berkarakter.' }}"
                        </p>
                    </div>

                    <div class="misi-wrapper">
                        <h3 class="vm-title">Misi Desa</h3>
                        <ul class="misi-list">
                            @if($profile->misi)
                                @foreach(explode("\n", $profile->misi) as $misi)
                                    @if(trim($misi))
                                        <li>{{ preg_replace('/^\d+[\.\-\s]*/', '', trim($misi)) }}</li>
                                    @endif
                                @endforeach
                            @else
                                <li>Meningkatkan kesejahteraan warga melalui program ekonomi kreatif.</li>
                                <li>Menyelenggarakan tata kelola pemerintahan yang bersih dan melayani.</li>
                                <li>Membangun infrastruktur desa yang memadai dan berkesinambungan.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Potensi Highlights -->
    <section class="section">
        <div class="section-container">
            <div class="section-header">
                <span class="section-tag">Kekayaan Lokal</span>
                <h2 class="section-title">Potensi & UMKM Desa</h2>
                <p class="section-subtitle">Mendukung pertumbuhan ekonomi warga melalui optimalisasi usaha kecil, wisata desa, dan komoditas unggulan.</p>
            </div>

            <div class="potencies-grid">
                @forelse($featuredPotencies as $potency)
                    <div class="potency-card">
                        <div class="potency-cover-container">
                            @if($potency->cover_image)
                                <img src="{{ asset('storage/' . $potency->cover_image) }}" alt="{{ $potency->title }}" class="potency-cover">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: #f1f5f9; color: var(--text-light);">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                                </div>
                            @endif
                            <span class="potency-tag {{ $potency->category == 'UMKM' ? 'tag-umkm' : ($potency->category == 'Wisata' ? 'tag-wisata' : 'tag-komoditas') }}">
                                {{ $potency->category }}
                            </span>
                        </div>
                        <div class="potency-content">
                            <h3 class="potency-title">{{ $potency->title }}</h3>
                            <p class="potency-desc">{{ Str::limit(strip_tags($potency->description), 120, '...') }}</p>
                            
                            <div class="potency-meta">
                                @if($potency->price_range)
                                    <div class="meta-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                        <span>{{ $potency->price_range }}</span>
                                    </div>
                                @endif
                                @if($potency->location)
                                    <div class="meta-item">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                        <span>{{ $potency->location }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="potency-cta">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $potency->contact_person) }}?text=Halo,%20saya%20tertarik%20dengan%20produk/potensi%20{{ urlencode($potency->title) }}%20di%20Website%20Desa." target="_blank" class="whatsapp-btn">
                                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.968C16.59 1.97 14.122.945 11.503.945 6.071.945 1.646 5.315 1.641 10.745c-.002 1.712.455 3.385 1.325 4.888L1.972 22.03l6.586-1.728-.088-.046z"/></svg>
                                    Hubungi Pengelola
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--text-light);">
                        Belum ada data potensi desa yang dimasukkan.
                    </div>
                @endforelse
            </div>
            
            @if($featuredPotencies->count() > 0)
                <div class="lazy-load-wrapper">
                    <a href="{{ route('potencies') }}" class="btn btn-secondary">Lihat Semua Potensi Desa</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Galeri Highlights -->
    <section class="section" style="background-color: white; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="section-container">
            <div class="section-header">
                <span class="section-tag">Dokumentasi</span>
                <h2 class="section-title">Galeri Kegiatan Warga</h2>
                <p class="section-subtitle">Sorotan dokumentasi foto dan video dari program pembangunan, kegiatan sosial, dan kemasyarakatan di desa.</p>
            </div>

            <div class="gallery-grid">
                @forelse($recentGalleries as $gallery)
                    <a href="{{ route('galleries') }}" class="gallery-card">
                        <div class="gallery-thumbnail-wrapper">
                            @if($gallery->items->first() && $gallery->items->first()->file_path)
                                <img src="{{ asset('storage/' . $gallery->items->first()->file_path) }}" alt="{{ $gallery->title }}" class="gallery-thumbnail">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: #f1f5f9; color: var(--text-light);">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                </div>
                            @endif
                            <div class="gallery-overlay">
                                <div class="overlay-content">
                                    <div class="overlay-date">{{ $gallery->event_date ? $gallery->event_date->format('d M Y') : '' }}</div>
                                    <h4 class="overlay-title">{{ $gallery->title }}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="gallery-card-content">
                            <div class="gallery-card-meta">
                                {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : 'Tanpa Tanggal' }} • {{ $gallery->items->count() }} Foto
                            </div>
                            <h3 class="gallery-card-title">{{ $gallery->title }}</h3>
                            <p class="gallery-card-desc">{{ Str::limit(strip_tags($gallery->description), 100, '...') }}</p>
                        </div>
                    </a>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 3rem; color: var(--text-light);">
                        Belum ada album galeri kegiatan yang dimasukkan.
                    </div>
                @endforelse
            </div>

            @if($recentGalleries->count() > 0)
                <div class="lazy-load-wrapper">
                    <a href="{{ route('galleries') }}" class="btn btn-secondary">Lihat Seluruh Galeri</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Peta Geografis Section -->
    @if($profile->google_maps_iframe || $profile->koordinat_peta)
        <section class="section">
            <div class="section-container">
                <div class="section-header">
                    <span class="section-tag">Geografis</span>
                    <h2 class="section-title">Peta Letak Wilayah</h2>
                    <p class="section-subtitle">Secara administratif letak geografis wilayah perbatasan dan jangkauan wilayah Desa {{ $profile->nama_desa }}.</p>
                </div>

                <div class="map-container">
                    <div class="map-iframe-wrapper">
                        @if($profile->google_maps_iframe)
                            {!! $profile->google_maps_iframe !!}
                        @else
                            <!-- Fallback default static maps if iframe not provided -->
                            <div style="width: 100%; height: 450px; background-color: #e2e8f0; display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                                Koordinat: {{ $profile->koordinat_peta }}
                            </div>
                        @endif
                    </div>
                    <div class="map-info">
                        <h3 class="map-info-title">Letak Administratif</h3>
                        
                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                            </div>
                            <div class="info-details">
                                <h4>Koordinat Desa</h4>
                                <p>{{ $profile->koordinat_peta ?: '-7.0449, 110.3924' }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            </div>
                            <div class="info-details">
                                <h4>Alamat Balai Desa</h4>
                                <p>{{ $profile->alamat ?: 'Jl. Raya Utama No. 1, Desa Mekar Jaya' }}</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                            </div>
                            <div class="info-details">
                                <h4>Jam Operasional Layanan</h4>
                                <p>Senin - Jumat (08:00 - 14:00 WIB)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
