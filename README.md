<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

# Website Profil & Potensi Desa

Portal Resmi Informasi Desa & Sistem Manajemen Konten (CMS) berbasis arsitektur monolith Laravel yang stabil, tangguh, dan minim pemeliharaan.

## 🛠️ Stack Teknologi
* **Backend**: Laravel (PHP >= 8.3)
* **Admin Panel (CMS)**: Filament PHP v3
* **Reactive Frontend**: Livewire v3
* **Database**: PostgreSQL (dengan indexing optimal)
* **Styling**: Premium Vanilla CSS (Responsive, Modern, & Light)

---

## 🚀 Fitur Utama
1. **Informasi & Profil Desa (Sisi Publik)**:
   * **Profil Desa**: Visi, Misi, Sejarah Lengkap, dan Integrasi Peta Google Maps.
   * **Struktur Perangkat Desa**: Bagan interaktif perangkat desa dengan filter jabatan tanpa muat ulang (*no reload*).
   * **Potensi Desa & UMKM**: Direktori lokal UMKM rakyat, destinasi wisata, dan komoditas unggulan desa dengan sistem lazy-loading, detail modal, dan chat langsung ke pemilik melalui WhatsApp.
   * **Galeri Kegiatan**: Album dokumentasi aktivitas desa dengan penampil foto *Lightbox pop-up slider* interaktif.

2. **Dashboard Management System (Sisi Admin)**:
   * **Manajemen Profil**: Pengaturan data visi-misi desa, logo resmi, alamat, dan email.
   * **CRUD Aparat**: Pengaturan aparat desa aktif dan hierarki pengurutan bagan.
   * **CRUD Potensi**: Pengisian produk UMKM, wisata, dan kontak pemilik WhatsApp terperinci.
   * **Manajemen Galeri**: Unggah foto kegiatan desa secara massal (*bulk upload*) disertai caption masing-masing gambar.
   * **Image Auto-WebP Optimization**: Mengonversi dan mengompres setiap gambar unggahan menjadi format modern `.webp` (lebar maks. 1200px) secara otomatis via backend Laravel untuk menghemat kapasitas ruang server.

---

## ⚙️ Cara Menjalankan Aplikasi di Lokal

### 1. Konfigurasi Database
Buat database baru bernama `website_desa` di PostgreSQL, kemudian sesuaikan parameter koneksi pada file `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=website_desa
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 2. Jalankan Perintah Instalasi
Eksekusi rangkaian perintah berikut di terminal:
```bash
# 1. Pemasangan dependensi PHP & Filament
composer update

# 2. Hubungkan folder penyimpanan media
php artisan storage:link

# 3. Migrasi database dan seeding data awal (termasuk user admin)
php artisan migrate:fresh --seed

# 4. Pemasangan & kompilasi aset CSS/JS
npm install
npm run build

# 5. Jalankan server lokal
php artisan serve
```

### 3. Akses Website & Panel Admin
* **Akses Website**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
* **Akses Dashboard Admin**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)
  * **Email**: `admin@desa.go.id`
  * **Password**: `password`

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
