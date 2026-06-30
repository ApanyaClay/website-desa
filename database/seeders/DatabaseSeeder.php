<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Profile;
use App\Models\Official;
use App\Models\Potency;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin User for Filament
        User::updateOrCreate(
            ['email' => 'admin@desa.go.id'],
            [
                'name' => 'Admin Desa Mekar Jaya',
                'password' => Hash::make('password'),
            ]
        );

        // 2. Seed Default Village Profile
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'nama_desa' => 'Desa Mekar Jaya',
                'visi' => 'Mewujudkan Desa Mekar Jaya yang Mandiri, Sejahtera, dan Berbudaya Berlandaskan Gotong Royong.',
                'misi' => "1. Meningkatkan tata kelola pemerintahan desa yang bersih, transparan, dan akuntabel.\n2. Mengembangkan potensi ekonomi lokal melalui pemberdayaan UMKM dan komoditas pertanian unggulan.\n3. Meningkatkan pembangunan infrastruktur desa yang merata dan berwawasan lingkungan.\n4. Memperkuat kerukunan sosial dan melestarikan nilai-nilai kebudayaan lokal.",
                'sejarah' => 'Desa Mekar Jaya didirikan pada tahun 1948 oleh para pionir pertanian yang membuka lahan di lereng perbukitan subur. Nama Mekar Jaya dipilih sebagai doa agar desa ini senantiasa mekar berkembang dan jaya dalam kemakmuran rakyatnya. Selama berpuluh-puluh tahun, desa ini berkembang dari wilayah perkebunan tradisional menjadi sentra produksi pangan dan kerajinan tangan yang diakui di tingkat kabupaten.',
                'logo_path' => null, // falling back to app icon in blade
                'koordinat_peta' => '-7.0449, 110.3924',
                'google_maps_iframe' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15838.784462125556!2d110.39243764835263!3d-7.044941916377626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708be2f3cf1675%3A0x5027a7b45c2f5d0!2sKec.%20Banyumanik%2C%20Kota%20Semarang%2C%20Jawa%20Tengah!5e0!3m2!1sid!2sid!4v1719730000000!5m2!1sid!2sid" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                'email' => 'info@mekarjaya.desa.id',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Raya Utama No. 1, Desa Mekar Jaya, Kec. Banyumanik, Jawa Tengah'
            ]
        );

        // 3. Seed Village Officials (Perangkat Desa)
        $officials = [
            [
                'name' => 'H. Sudirman, S.IP',
                'role' => 'Kepala Desa',
                'sort_order' => 1,
            ],
            [
                'name' => 'Siti Aminah, S.E.',
                'role' => 'Sekretaris Desa',
                'sort_order' => 2,
            ],
            [
                'name' => 'Budi Santoso',
                'role' => 'Kaur Keuangan',
                'sort_order' => 3,
            ],
            [
                'name' => 'Eko Prasetyo',
                'role' => 'Kaur Pembangunan',
                'sort_order' => 4,
            ],
            [
                'name' => 'Rina Lestari, A.Md.',
                'role' => 'Kasi Pelayanan & Kesejahteraan',
                'sort_order' => 5,
            ],
            [
                'name' => 'Wawan Hermawan',
                'role' => 'Kepala Dusun Krajan',
                'sort_order' => 6,
            ],
        ];

        foreach ($officials as $off) {
            Official::updateOrCreate(
                ['name' => $off['name']],
                [
                    'role' => $off['role'],
                    'sort_order' => $off['sort_order'],
                    'photo_path' => null,
                    'is_active' => true,
                ]
            );
        }

        // 4. Seed Village Potencies
        $potencies = [
            [
                'title' => 'Keripik Tempe Renyah Bu Warsi',
                'category' => 'UMKM',
                'description' => 'Keripik tempe tipis renyah dengan resep turun-temurun tanpa bahan pengawet. Tersedia dalam berbagai varian rasa seperti original, balado, dan keju manis.',
                'contact_person' => '6281234567890',
                'price_range' => 'Rp 10.000 - Rp 25.000',
                'location' => 'RT 02 / RW 01, Dusun Krajan',
            ],
            [
                'title' => 'Batik Tulis Mekar Sari',
                'category' => 'UMKM',
                'description' => 'Batik tulis buatan tangan perajin lokal dengan motif khas flora-fauna pegunungan Desa Mekar Jaya. Menggunakan pewarna alami ramah lingkungan dari dedaunan lokal.',
                'contact_person' => '6281298765432',
                'price_range' => 'Rp 150.000 - Rp 500.000',
                'location' => 'RT 04 / RW 02, Dusun Krajan',
            ],
            [
                'title' => 'Curug Pelangi',
                'category' => 'Wisata',
                'description' => 'Keindahan air terjun alami setinggi 25 meter yang dikelilingi hutan pinus rindang. Sangat cocok untuk wisata keluarga, camping, dan spot foto dengan efek pelangi pembiasan cahaya matahari di pagi hari.',
                'contact_person' => '6285743210987',
                'price_range' => 'Rp 5.000 (Tiket Masuk)',
                'location' => 'Dusun Wetan, Area Hutan Lindung',
            ],
            [
                'title' => 'Kopi Robusta Lereng Bukit',
                'category' => 'Komoditas',
                'description' => 'Biji kopi robusta berkualitas tinggi yang ditanam di ketinggian 800 MDPL. Memiliki cita rasa nutty dan cokelat yang kuat dengan keasaman rendah, diproses secara natural oleh kelompok tani Makmur Sejahtera.',
                'contact_person' => '6289988887777',
                'price_range' => 'Rp 80.000 / Kg',
                'location' => 'Perkebunan Kopi Rakyat, Dusun Wetan',
            ],
        ];

        foreach ($potencies as $pot) {
            Potency::updateOrCreate(
                ['title' => $pot['title']],
                [
                    'category' => $pot['category'],
                    'description' => $pot['description'],
                    'contact_person' => $pot['contact_person'],
                    'price_range' => $pot['price_range'],
                    'location' => $pot['location'],
                    'cover_image' => null,
                ]
            );
        }

        // 5. Seed Galleries & Gallery Items
        $g1 = Gallery::updateOrCreate(
            ['title' => 'Peringatan HUT RI ke-80'],
            [
                'description' => 'Keseruan warga Desa Mekar Jaya dalam memeriahkan hari kemerdekaan melalui berbagai lomba rakyat, pawai budaya, dan pentas seni malam puncak.',
                'event_date' => '2025-08-17',
            ]
        );

        $g2 = Gallery::updateOrCreate(
            ['title' => 'Kerja Bakti Bersih Desa'],
            [
                'description' => 'Kegiatan gotong royong seluruh warga desa membersihkan saluran air, jalan desa, dan fasilitas umum dalam menyambut musim penghujan.',
                'event_date' => '2026-03-12',
            ]
        );
    }
}
