<div style="padding-top: 140px; padding-bottom: 100px;">
    <div class="section-container">
        <!-- Section Header -->
        <div class="section-header">
            <span class="section-tag">Pemerintahan Desa</span>
            <h1 class="section-title">Aparatur Pemerintahan Desa</h1>
            <p class="section-subtitle">Daftar perangkat desa yang bertugas menyelenggarakan administrasi dan pembangunan di Desa {{ $villageProfile->nama_desa }}.</p>
        </div>

        <!-- Filter & Search Controls -->
        <div class="search-filter-container">
            <!-- Reactive Search Box -->
            <div class="search-box-wrapper">
                <input type="text" 
                       wire:model.live.debounce.250ms="search" 
                       class="search-input" 
                       placeholder="Cari nama aparat pemerintahan desa...">
                <span class="search-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
            </div>

            <!-- Reactive Filter Buttons -->
            <div class="filter-wrapper" style="margin-bottom: 0;">
                <button wire:click="filterRole('all')" class="filter-btn {{ $selectedRole === 'all' ? 'active' : '' }}">
                    Semua Jabatan
                </button>
                <button wire:click="filterRole('pimpinan')" class="filter-btn {{ $selectedRole === 'pimpinan' ? 'active' : '' }}">
                    Pimpinan (Kades / Sekdes)
                </button>
                <button wire:click="filterRole('staf')" class="filter-btn {{ $selectedRole === 'staf' ? 'active' : '' }}">
                    Staf Pelaksana (Kaur / Kasi)
                </button>
                <button wire:click="filterRole('kadus')" class="filter-btn {{ $selectedRole === 'kadus' ? 'active' : '' }}">
                    Kepala Dusun (Wilayah)
                </button>
            </div>
        </div>

        <!-- Officials Grid -->
        <div class="officials-grid">
            @forelse($officials as $official)
                <div class="official-card">
                    <div class="official-image-container">
                        @if($official->photo_path)
                            <img src="{{ asset('storage/' . $official->photo_path) }}" alt="{{ $official->name }}" class="official-image">
                        @else
                            <div class="official-placeholder">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <span style="font-size: 0.8rem; font-weight: 600; opacity: 0.8;">Foto Perangkat</span>
                            </div>
                        @endif
                    </div>
                    <div class="official-info">
                        <div class="official-role">{{ $official->role }}</div>
                        <h3 class="official-name">{{ $official->name }}</h3>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 4rem 2rem; background-color: white; border-radius: var(--radius-lg); border: 1px solid var(--border-color); color: var(--text-light);">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 1rem;"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <p style="font-weight: 600; color: var(--text-secondary); margin-bottom: 0.25rem;">Aparat Tidak Ditemukan</p>
                    <p style="font-size: 0.9rem;">Tidak ada aparat desa aktif yang cocok dengan kriteria pencarian Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
