<div style="padding-top: 140px; padding-bottom: 100px;">
    <div class="section-container">
        @if($selectedGallery)
            <!-- Album Detail View -->
            <div style="margin-bottom: 2rem;">
                <button wire:click="resetSelection" class="btn btn-secondary" style="margin-bottom: 2.5rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali Ke Album
                </button>
                
                <div style="border-bottom: 1px solid var(--border-color); padding-bottom: 2rem; margin-bottom: 3rem;">
                    <span class="section-tag">{{ $selectedGallery->event_date ? $selectedGallery->event_date->format('d M Y') : 'Dokumentasi' }}</span>
                    <h1 class="section-title" style="margin-top: 0.5rem; text-align: left;">{{ $selectedGallery->title }}</h1>
                    @if($selectedGallery->description)
                        <p style="color: var(--text-secondary); font-size: 1.1rem; max-width: 800px; margin-top: 0.75rem;">{{ $selectedGallery->description }}</p>
                    @endif
                </div>
            </div>

            <!-- Photos in Selected Album Grid -->
            <div class="gallery-grid">
                @forelse($selectedGallery->items as $index => $item)
                    <div class="gallery-card" wire:click="openLightbox({{ $index }})" style="cursor: pointer;">
                        <div class="gallery-thumbnail-wrapper" style="aspect-ratio: 4/3;">
                            <img src="{{ asset('storage/' . $item->file_path) }}" alt="{{ $item->caption ?: $selectedGallery->title }}" class="gallery-thumbnail">
                            <div class="gallery-overlay" style="opacity: 0; display: flex; align-items: center; justify-content: center; background: rgba(15,23,42,0.4);">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                            </div>
                        </div>
                        @if($item->caption)
                            <div class="gallery-card-content" style="padding: 1rem;">
                                <p style="font-size: 0.9rem; font-weight: 550; color: var(--text-primary); text-align: center;">{{ $item->caption }}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 4rem; color: var(--text-light);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <p style="font-weight:600; color: var(--text-secondary);">Album ini masih kosong</p>
                        <p style="font-size:0.9rem;">Belum ada foto yang diunggah ke dalam album ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Lightbox Pop-up Overlay -->
            <div class="lightbox {{ $activePhotoIndex !== null ? 'active' : '' }}" id="gallery-lightbox">
                @if($activePhotoIndex !== null && $selectedGallery->items->count() > 0)
                    <!-- Close button -->
                    <button wire:click="closeLightbox" class="lightbox-close" aria-label="Tutup Galeri">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                    
                    <!-- Navigation buttons -->
                    @if($selectedGallery->items->count() > 1)
                        <button wire:click="prevPhoto" class="lightbox-nav lightbox-prev" aria-label="Sebelumnya">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button wire:click="nextPhoto" class="lightbox-nav lightbox-next" aria-label="Selanjutnya">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    @endif
                    
                    <div class="lightbox-content-wrapper">
                        <img src="{{ asset('storage/' . $selectedGallery->items[$activePhotoIndex]->file_path) }}" alt="{{ $selectedGallery->items[$activePhotoIndex]->caption }}" class="lightbox-image">
                    </div>
                    
                    <div class="lightbox-caption">
                        <span style="font-size: 0.85rem; color: var(--text-light); text-transform: uppercase; letter-spacing: 0.05em; display: block; margin-bottom: 0.25rem;">
                            Foto {{ $activePhotoIndex + 1 }} dari {{ $selectedGallery->items->count() }}
                        </span>
                        <p style="font-weight: 500;">
                            {{ $selectedGallery->items[$activePhotoIndex]->caption ?: $selectedGallery->title }}
                        </p>
                    </div>
                @endif
            </div>

        @else
            <!-- Album Grid View (Selected is null) -->
            <div class="section-header">
                <span class="section-tag">Dokumentasi Desa</span>
                <h1 class="section-title">Galeri Kegiatan Warga</h1>
                <p class="section-subtitle">Kumpulan dokumentasi foto program pembangunan desa, kegiatan kemasyarakatan, serta perayaan hari besar warga Desa {{ $villageProfile->nama_desa }}.</p>
            </div>

            <div class="gallery-grid">
                @forelse($galleries as $gallery)
                    <div wire:click="selectGallery({{ $gallery->id }})" class="gallery-card" style="cursor: pointer;">
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
                                {{ $gallery->event_date ? $gallery->event_date->format('d M Y') : 'Dokumentasi' }} • {{ $gallery->items->count() }} Foto
                            </div>
                            <h3 class="gallery-card-title">{{ $gallery->title }}</h3>
                            <p class="gallery-card-desc">{{ Str::limit(strip_tags($gallery->description), 140, '...') }}</p>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem; background-color: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color); color: var(--text-light);">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <p style="font-weight:600; color: var(--text-secondary); margin-bottom: 0.25rem;">Belum Ada Galeri</p>
                        <p style="font-size:0.9rem;">Dokumentasi kegiatan resmi desa belum diunggah.</p>
                    </div>
                @endforelse
            </div>
        @endif
    </div>
</div>
