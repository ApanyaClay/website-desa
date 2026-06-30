<div style="padding-top: 140px; padding-bottom: 100px;">
    <div class="section-container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-tag">Direktori Desa</span>
            <h1 class="section-title">Potensi & UMKM Desa</h1>
            <p class="section-subtitle">Katalog produk lokal UMKM, destinasi wisata alam, serta komoditas pertanian unggulan khas Desa {{ $villageProfile->nama_desa }}.</p>
        </div>

        <!-- Filter & Search Controls -->
        <div class="search-filter-container">
            <!-- Reactive Search Box -->
            <div class="search-box-wrapper">
                <input type="text" 
                       wire:model.live.debounce.250ms="search" 
                       class="search-input" 
                       placeholder="Cari UMKM, produk unggulan, atau tempat wisata...">
                <span class="search-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
            </div>

            <!-- Reactive Category Filter Tabs -->
            <div class="filter-wrapper" style="margin-bottom: 0;">
                <button wire:click="filterCategory('all')" class="filter-btn {{ $selectedCategory === 'all' ? 'active' : '' }}">
                    Semua Kategori
                </button>
                <button wire:click="filterCategory('UMKM')" class="filter-btn {{ $selectedCategory === 'UMKM' ? 'active' : '' }}">
                    UMKM Rakyat
                </button>
                <button wire:click="filterCategory('Wisata')" class="filter-btn {{ $selectedCategory === 'Wisata' ? 'active' : '' }}">
                    Destinasi Wisata
                </button>
                <button wire:click="filterCategory('Komoditas')" class="filter-btn {{ $selectedCategory === 'Komoditas' ? 'active' : '' }}">
                    Komoditas Pertanian
                </button>
            </div>
        </div>

        <!-- Potency Cards Grid -->
        <div class="potencies-grid">
            @forelse($potencies as $potency)
                <div class="potency-card">
                    <!-- Cover Image -->
                    <div class="potency-cover-container" wire:click="openDetail({{ $potency->id }})" style="cursor: pointer;">
                        @if($potency->cover_image)
                            <img src="{{ asset('storage/' . $potency->cover_image) }}" alt="{{ $potency->title }}" class="potency-cover">
                        @else
                            <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: #f1f5f9; color: var(--text-light);">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                            </div>
                        @endif
                        <!-- Category Badge -->
                        <span class="potency-tag {{ $potency->category == 'UMKM' ? 'tag-umkm' : ($potency->category == 'Wisata' ? 'tag-wisata' : 'tag-komoditas') }}">
                            {{ $potency->category }}
                        </span>
                    </div>

                    <!-- Card Body -->
                    <div class="potency-content">
                        <h3 class="potency-title" wire:click="openDetail({{ $potency->id }})" style="cursor: pointer;">{{ $potency->title }}</h3>
                        <p class="potency-desc">{{ Str::limit(strip_tags($potency->description), 140, '...') }}</p>
                        
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
                        
                        <div class="potency-cta" style="display: flex; gap: 0.5rem;">
                            <button wire:click="openDetail({{ $potency->id }})" class="btn btn-secondary" style="flex: 1; padding: 0.6rem;">
                                Detail Usaha
                            </button>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $potency->contact_person) }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($potency->title) }}%20di%20Website%20Desa." 
                               target="_blank" 
                               class="whatsapp-btn" 
                               style="flex: 1; padding: 0.6rem;">
                                <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.968C16.59 1.97 14.122.945 11.503.945 6.071.945 1.646 5.315 1.641 10.745c-.002 1.712.455 3.385 1.325 4.888L1.972 22.03l6.586-1.728-.088-.046z"/></svg>
                                Hubungi WA
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem; background-color: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color); color: var(--text-light);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <p style="font-weight: 600; color: var(--text-secondary); margin-bottom: 0.25rem;">Data Tidak Ditemukan</p>
                    <p style="font-size: 0.9rem;">Belum ada potensi desa terdaftar untuk kategori atau kriteria pencarian ini.</p>
                </div>
            @endforelse
        </div>

        <!-- Load More Button -->
        @if($hasMore)
            <div class="lazy-load-wrapper">
                <button wire:click="loadMore" wire:loading.attr="disabled" class="btn btn-primary" style="min-width: 180px;">
                    <span wire:loading.remove>Muat Lebih Banyak</span>
                    <span wire:loading>Memuat...</span>
                </button>
            </div>
        @endif
    </div>

    <!-- Details Modal Backdrop & Card -->
    <div class="modal {{ $isModalOpen ? 'active' : '' }}" wire:click.self="closeDetail" id="potency-detail-modal">
        @if($selectedPotency)
            <div class="modal-content">
                <button wire:click="closeDetail" class="modal-close" aria-label="Tutup Detail">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
                
                @if($selectedPotency->cover_image)
                    <img src="{{ asset('storage/' . $selectedPotency->cover_image) }}" alt="{{ $selectedPotency->title }}" class="modal-image">
                @else
                    <div style="width: 100%; height: 260px; display: flex; align-items: center; justify-content: center; background-color: #f1f5f9; color: var(--text-light);">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    </div>
                @endif
                
                <div class="modal-body">
                    <span class="modal-category {{ $selectedPotency->category == 'UMKM' ? 'tag-umkm' : ($selectedPotency->category == 'Wisata' ? 'tag-wisata' : 'tag-komoditas') }}">
                        {{ $selectedPotency->category }}
                    </span>
                    <h2 class="modal-title">{{ $selectedPotency->title }}</h2>
                    
                    <div class="modal-desc">
                        {!! $selectedPotency->description ?: '<p>Tidak ada deskripsi detail untuk potensi ini.</p>' !!}
                    </div>
                    
                    <!-- Metadata Info -->
                    <div class="modal-meta-grid">
                        <div>
                            <strong style="display: block; font-size: 0.85rem; color: var(--text-light); text-transform: uppercase; margin-bottom: 0.25rem;">Kisaran Harga</strong>
                            <span style="font-weight: 600; color: var(--secondary); font-size: 1.05rem;">{{ $selectedPotency->price_range ?: 'Gratis / Nego' }}</span>
                        </div>
                        <div>
                            <strong style="display: block; font-size: 0.85rem; color: var(--text-light); text-transform: uppercase; margin-bottom: 0.25rem;">Kontak Resmi</strong>
                            <span style="font-weight: 600; color: var(--secondary); font-size: 1.05rem;">{{ $selectedPotency->contact_person }}</span>
                        </div>
                        <div style="grid-column: 1/-1;">
                            <strong style="display: block; font-size: 0.85rem; color: var(--text-light); text-transform: uppercase; margin-bottom: 0.25rem;">Lokasi / Alamat</strong>
                            <span style="font-weight: 600; color: var(--secondary); font-size: 1.05rem;">{{ $selectedPotency->location ?: 'Desa Mekar Jaya' }}</span>
                        </div>
                    </div>
                    
                    <!-- CTA -->
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $selectedPotency->contact_person) }}?text=Halo,%20saya%20tertarik%20dengan%20produk%20{{ urlencode($selectedPotency->title) }}%20di%20Website%20Desa." 
                       target="_blank" 
                       class="whatsapp-btn" 
                       style="padding: 1rem; font-size: 1rem; border-radius: var(--radius-md);">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946C.06 5.348 5.397.01 12.008.01c3.202.001 6.212 1.246 8.477 3.514 2.266 2.268 3.507 5.28 3.505 8.484-.004 6.657-5.34 11.997-11.953 11.997-2.005-.001-3.973-.502-5.724-1.455L0 24zm6.59-4.846c1.6.95 3.188 1.449 4.825 1.451 5.436 0 9.86-4.37 9.864-9.799.002-2.63-1.023-5.101-2.885-6.968C16.59 1.97 14.122.945 11.503.945 6.071.945 1.646 5.315 1.641 10.745c-.002 1.712.455 3.385 1.325 4.888L1.972 22.03l6.586-1.728-.088-.046z"/></svg>
                        Hubungi Pemilik Melalui WhatsApp
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
