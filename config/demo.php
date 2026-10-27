<?php

/*
|--------------------------------------------------------------------------
| Konfigurasi website demo NTT Digital
|--------------------------------------------------------------------------
| Setiap demo dilayani dari subdomain:  demo-{jenis}.{domain}
| Contoh: demo-desa.nttdigital.site
|
| Untuk uji lokal tanpa subdomain, buka ?demo=desa (tersimpan di session).
*/

return [

    'domain' => env('DEMO_DOMAIN', 'nttdigital.site'),

    // Situs utama untuk tombol "Pesan website seperti ini"
    'situs_utama' => env('DEMO_SITUS_UTAMA', 'https://nttdigital.site'),
    'whatsapp'    => env('DEMO_WHATSAPP', '6282247290150'),

    // Akun admin yang ditampilkan ke pengunjung (password sama untuk semua demo)
    'admin_password' => env('DEMO_ADMIN_PASSWORD', 'demo1234'),

    'jenis' => [
        'desa' => [
            'label' => 'Website Desa',
            'post'  => ['Berita', 'berita'],
            'menu'  => [
                ['Beranda', '/'], ['Profil', '/profil'], ['Berita', '/berita'],
                ['APBDes', '/apbdes'], ['Layanan Surat', '/layanan-surat'], ['Produk Desa', '/produk'], ['Kontak', '/kontak'],
            ],
            'item'  => [
                'perangkat' => 'Perangkat Desa', 'surat' => 'Jenis Surat', 'produk' => 'Produk Desa',
                'apbdes' => 'APBDes', 'statistik' => 'Statistik', 'galeri' => 'Galeri',
            ],
            'form'  => ['surat' => 'Permohonan Surat', 'pesan' => 'Pesan / Aspirasi'],
        ],
        'sekolah' => [
            'label' => 'Website Sekolah',
            'post'  => ['Berita', 'berita'],
            'menu'  => [
                ['Beranda', '/'], ['Profil', '/profil'], ['Berita', '/berita'],
                ['Guru', '/guru'], ['Galeri', '/galeri'], ['PPDB', '/ppdb'], ['Kontak', '/kontak'],
            ],
            'item'  => [
                'guru' => 'Guru & Staf', 'program' => 'Program Unggulan', 'prestasi' => 'Prestasi',
                'statistik' => 'Statistik', 'galeri' => 'Galeri',
            ],
            'form'  => ['ppdb' => 'Pendaftaran PPDB', 'pesan' => 'Pesan'],
        ],
        'umkm' => [
            'label' => 'Website UMKM',
            'post'  => ['Cerita', 'cerita'],
            'menu'  => [
                ['Beranda', '/'], ['Produk', '/produk'], ['Tentang', '/profil'], ['Cerita', '/cerita'], ['Kontak', '/kontak'],
            ],
            'item'  => ['produk' => 'Produk', 'keunggulan' => 'Keunggulan', 'galeri' => 'Galeri'],
            'form'  => ['pesan' => 'Pesan'],
        ],
        'gereja' => [
            'label' => 'Website Gereja',
            'post'  => ['Warta', 'warta'],
            'menu'  => [
                ['Beranda', '/'], ['Profil', '/profil'], ['Jadwal Ibadah', '/jadwal'], ['Warta', '/warta'],
                ['Pelayanan', '/pelayanan'], ['Persembahan', '/persembahan'], ['Kontak', '/kontak'],
            ],
            'item'  => [
                'jadwal' => 'Jadwal Ibadah', 'pelayan' => 'Majelis & Pelayan', 'pelayanan' => 'Kategori Pelayanan',
                'rekening' => 'Rekening Persembahan', 'galeri' => 'Galeri',
            ],
            'form'  => ['doa' => 'Permohonan Doa', 'pesan' => 'Pesan'],
        ],
        'hotel' => [
            'label' => 'Website Hotel',
            'post'  => ['Info', 'info'],
            'menu'  => [
                ['Beranda', '/'], ['Kamar', '/kamar'], ['Fasilitas', '/fasilitas'], ['Wisata Sekitar', '/wisata'],
                ['Tentang', '/profil'], ['Reservasi', '/reservasi'],
            ],
            'item'  => ['kamar' => 'Tipe Kamar', 'fasilitas' => 'Fasilitas', 'wisata' => 'Wisata Sekitar', 'galeri' => 'Galeri'],
            'form'  => ['reservasi' => 'Permintaan Reservasi', 'pesan' => 'Pesan'],
        ],
        'undangan' => [
            'label' => 'Undangan Digital',
            'post'  => ['Kabar', 'kabar'],
            'menu'  => [],
            'item'  => ['acara' => 'Rangkaian Acara', 'kisah' => 'Kisah Kami', 'galeri' => 'Galeri', 'hadiah' => 'Amplop Digital'],
            'form'  => ['rsvp' => 'Konfirmasi Kehadiran'],
        ],
    ],
];
