<?php

namespace Database\Seeders;

use App\Models\Demo;
use App\Models\Item;
use App\Models\Kiriman;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Isi contoh untuk 6 website demo. SEMUA nama instansi, orang, nomor, dan angka adalah fiktif.
 * Dijalankan ulang setiap malam oleh `php artisan demo:reset`.
 */
class DemoSeeder extends Seeder
{
    private Demo $demo;

    public function run(): void
    {
        foreach (['desa', 'sekolah', 'umkm', 'gereja', 'hotel', 'undangan'] as $jenis) {
            $this->{$jenis}();
            User::create([
                'demo_id'  => $this->demo->id,
                'name'     => 'Admin Demo ' . ucfirst($jenis),
                'email'    => "admin@{$jenis}.demo",
                'password' => Hash::make(config('demo.admin_password')),
            ]);
        }
    }

    // ------------------------------------------------------------------ helper

    private function buat(array $data): void
    {
        $this->demo = Demo::create($data);
    }

    private function items(string $tipe, array $baris): void
    {
        foreach ($baris as $i => $b) {
            Item::create(array_merge(['demo_id' => $this->demo->id, 'tipe' => $tipe, 'urutan' => $i + 1], $b));
        }
    }

    private function posts(array $baris): void
    {
        foreach ($baris as $i => [$judul, $kategori, $isi]) {
            Post::create([
                'demo_id'  => $this->demo->id,
                'judul'    => $judul,
                'kategori' => $kategori,
                'isi'      => $isi,
                'tanggal'  => now()->subDays($i * 4 + 1),
                'penulis'  => 'Admin',
            ]);
        }
    }

    private function p(string ...$paragraf): string
    {
        return collect($paragraf)->map(fn ($p) => str_starts_with($p, '<') ? $p : "<p>{$p}</p>")->implode("\n");
    }

    // ------------------------------------------------------------------ DESA

    private function desa(): void
    {
        $this->buat([
            'jenis' => 'desa', 'nama' => 'Desa Lontar Asri', 'logo_teks' => 'LA',
            'warna' => '#1F5F3F', 'warna_aksen' => '#D4A62A',
            'tagline' => 'Website resmi Pemerintah Desa Lontar Asri — informasi, layanan, dan transparansi untuk seluruh warga.',
            'hero_judul' => 'Desa Lontar Asri, maju bersama warga',
            'hero_sub' => 'Informasi pemerintahan, layanan surat online, dan laporan Dana Desa yang terbuka untuk semua warga, di mana pun berada.',
            'alamat' => 'Jl. Poros Desa No. 1, Desa Lontar Asri, Kabupaten Kupang, NTT',
            'telepon' => '0380-000000', 'whatsapp' => config('demo.whatsapp'), 'email' => 'pemdes@lontarasri.desa.id',
            'jam_layanan' => 'Senin–Jumat, 08.00–15.00 WITA',
            'visi' => 'Terwujudnya Desa Lontar Asri yang mandiri, sejahtera, dan berbudaya berlandaskan gotong royong.',
            'misi' => ['Meningkatkan kualitas pelayanan administrasi yang cepat dan transparan', 'Mengembangkan BUMDes dan produk unggulan desa', 'Membangun infrastruktur air bersih dan jalan desa', 'Melestarikan budaya dan kearifan lokal'],
            'profil' => $this->p(
                '<h2>Sejarah singkat</h2>',
                'Desa Lontar Asri berdiri sebagai desa definitif pada tahun 1984, hasil pemekaran dari desa induk di sekitarnya. Nama "Lontar Asri" diambil dari hamparan pohon lontar yang sejak dulu menjadi sumber kehidupan warga — dari gula air, tikar, hingga atap rumah.',
                'Saat ini desa terdiri dari 4 dusun dan 12 RT, dengan mayoritas warga bekerja sebagai petani lahan kering, peternak, dan perajin anyaman.',
                '<h2>Kondisi geografis</h2>',
                'Wilayah desa berupa perbukitan dengan musim hujan yang pendek. Karena itu program air bersih dan embung desa menjadi prioritas pembangunan beberapa tahun terakhir.',
            ),
            'data' => [
                'nama_pendek' => 'Lontar Asri', 'sub_nama' => 'Kabupaten Kupang · Nusa Tenggara Timur',
                'judul_profil' => 'Profil Desa', 'tipe_orang' => 'perangkat',
                'kepala' => ['nama' => 'Yosef M. Benu', 'sambutan' => 'Website ini kami hadirkan agar setiap warga — termasuk anak-anak desa yang merantau — bisa mengikuti pembangunan desa dan mengurus layanan dengan lebih mudah.'],
            ],
        ]);

        $this->items('statistik', [
            ['nama' => 'Penduduk', 'subjudul' => '2.847'], ['nama' => 'Kepala keluarga', 'subjudul' => '712'],
            ['nama' => 'Dusun', 'subjudul' => '4'], ['nama' => 'Luas wilayah', 'subjudul' => '18,6 km²'],
        ]);
        $this->items('perangkat', [
            ['nama' => 'Yosef M. Benu', 'subjudul' => 'Kepala Desa', 'ikon' => '👤'],
            ['nama' => 'Maria G. Tefa', 'subjudul' => 'Sekretaris Desa', 'ikon' => '👤'],
            ['nama' => 'Daniel Kase', 'subjudul' => 'Kaur Keuangan', 'ikon' => '👤'],
            ['nama' => 'Agustina Nenobais', 'subjudul' => 'Kasi Pelayanan', 'ikon' => '👤'],
        ]);
        $this->items('surat', [
            ['nama' => 'Surat Keterangan Domisili', 'ikon' => '🏠', 'deskripsi' => 'Untuk keperluan administrasi yang membutuhkan bukti tempat tinggal.', 'data' => ['lama' => '1 hari kerja', 'syarat' => ['Fotokopi KTP', 'Fotokopi Kartu Keluarga', 'Surat pengantar RT']]],
            ['nama' => 'Surat Keterangan Usaha', 'ikon' => '🧺', 'deskripsi' => 'Untuk pengajuan KUR, izin usaha mikro, atau bantuan modal.', 'data' => ['lama' => '1 hari kerja', 'syarat' => ['Fotokopi KTP', 'Foto tempat usaha', 'Surat pengantar RT']]],
            ['nama' => 'Surat Keterangan Tidak Mampu', 'ikon' => '📄', 'deskripsi' => 'Untuk keringanan biaya sekolah, kesehatan, atau bantuan sosial.', 'data' => ['lama' => '2 hari kerja', 'syarat' => ['Fotokopi KTP & KK', 'Surat pengantar RT', 'Verifikasi oleh kepala dusun']]],
            ['nama' => 'Surat Pengantar Nikah', 'ikon' => '💍', 'deskripsi' => 'Pengantar untuk pengurusan pernikahan di KUA atau gereja.', 'data' => ['lama' => '2 hari kerja', 'syarat' => ['Fotokopi KTP & KK kedua calon', 'Akta kelahiran', 'Pas foto 3x4']]],
            ['nama' => 'Surat Keterangan Kelahiran', 'ikon' => '👶', 'deskripsi' => 'Dasar pengurusan akta kelahiran di Dukcapil.', 'data' => ['lama' => '1 hari kerja', 'syarat' => ['Surat keterangan lahir dari bidan/puskesmas', 'Fotokopi KTP orang tua', 'Fotokopi KK']]],
        ]);
        $this->items('apbdes', [
            ['nama' => 'Dana Desa', 'deskripsi' => 'Transfer APBN', 'harga' => 987_450_000, 'data' => ['jenis' => 'pendapatan', 'realisasi' => 740_587_500]],
            ['nama' => 'Alokasi Dana Desa', 'deskripsi' => 'Transfer APBD kabupaten', 'harga' => 412_300_000, 'data' => ['jenis' => 'pendapatan', 'realisasi' => 309_225_000]],
            ['nama' => 'Pendapatan Asli Desa', 'deskripsi' => 'Hasil BUMDes & usaha desa', 'harga' => 38_500_000, 'data' => ['jenis' => 'pendapatan', 'realisasi' => 24_100_000]],
            ['nama' => 'Penyelenggaraan Pemerintahan', 'deskripsi' => 'Operasional kantor & siltap', 'harga' => 452_000_000, 'data' => ['jenis' => 'belanja', 'realisasi' => 338_000_000]],
            ['nama' => 'Pembangunan Desa', 'deskripsi' => 'Air bersih, jalan rabat, embung', 'harga' => 618_250_000, 'data' => ['jenis' => 'belanja', 'realisasi' => 371_000_000]],
            ['nama' => 'Pembinaan Kemasyarakatan', 'deskripsi' => 'PKK, karang taruna, keagamaan', 'harga' => 96_000_000, 'data' => ['jenis' => 'belanja', 'realisasi' => 61_400_000]],
            ['nama' => 'Pemberdayaan Masyarakat', 'deskripsi' => 'Pelatihan, BUMDes, ketahanan pangan', 'harga' => 222_000_000, 'data' => ['jenis' => 'belanja', 'realisasi' => 150_800_000]],
            ['nama' => 'Penanggulangan Bencana', 'deskripsi' => 'BLT & keadaan darurat', 'harga' => 50_000_000, 'data' => ['jenis' => 'belanja', 'realisasi' => 37_500_000]],
        ]);
        $this->items('produk', [
            ['nama' => 'Gula Lontar Cair', 'subjudul' => 'BUMDes Lontar Asri', 'harga' => 35_000, 'deskripsi' => 'Gula air dari nira lontar yang dimasak perlahan di tungku kayu. Manis legit, cocok untuk kopi, kue, dan bubur.', 'data' => ['satuan' => 'botol 600 ml', 'warna' => '#8A5A22', 'produsen' => 'Kelompok Tani Dusun A']],
            ['nama' => 'Tikar Anyaman Lontar', 'subjudul' => 'Kelompok Perajin Mama-Mama', 'harga' => 150_000, 'deskripsi' => 'Tikar anyaman daun lontar ukuran 1,5 x 2 meter. Kuat, dingin, dan dikerjakan tangan.', 'data' => ['satuan' => 'lembar', 'warna' => '#B08B4F', 'produsen' => 'Kelompok Perajin Dusun C']],
            ['nama' => 'Madu Hutan', 'subjudul' => 'BUMDes Lontar Asri', 'harga' => 120_000, 'deskripsi' => 'Madu hutan murni hasil panen warga dari kawasan perbukitan desa.', 'data' => ['satuan' => 'botol 500 ml', 'warna' => '#C78A12', 'produsen' => 'Kelompok Pemanen Madu']],
            ['nama' => 'Jagung Bose Instan', 'subjudul' => 'UMKM Dapur Mama', 'harga' => 25_000, 'deskripsi' => 'Jagung bose siap masak, tinggal tambah santan dan kacang. Rasa khas rumah.', 'data' => ['satuan' => 'pak 500 g', 'warna' => '#D9A62E', 'produsen' => 'UMKM Dapur Mama']],
            ['nama' => 'Kopi Robusta Bukit', 'subjudul' => 'Kelompok Tani Kopi', 'harga' => 60_000, 'deskripsi' => 'Kopi robusta sangrai sedang, digiling saat dipesan.', 'data' => ['satuan' => 'pak 250 g', 'warna' => '#4A2E1F', 'produsen' => 'Kelompok Tani Kopi']],
        ]);
        $this->posts([
            ['Musyawarah Desa Bahas Rencana Pembangunan Tahun Depan', 'Pemerintahan', $this->p('Pemerintah Desa Lontar Asri menggelar Musyawarah Desa yang dihadiri BPD, tokoh masyarakat, tokoh agama, dan perwakilan perempuan dari keempat dusun.', 'Musyawarah menyepakati tiga prioritas pembangunan: perluasan jaringan air bersih ke Dusun D, rabat jalan menuju kebun warga, dan pelatihan pengolahan gula lontar.', '<blockquote>Usulan warga adalah dasar perencanaan. Terima kasih kepada semua yang sudah hadir dan bersuara. — Kepala Desa</blockquote>')],
            ['Air Bersih Kini Mengalir ke 86 Rumah di Dusun C', 'Pembangunan', $this->p('Pembangunan jaringan perpipaan dari sumber mata air di bukit utara telah rampung. Sebanyak 86 rumah di Dusun C kini tidak lagi harus berjalan jauh untuk mengambil air.', 'Pekerjaan dilakukan secara padat karya oleh warga setempat sehingga upah kerja juga kembali ke masyarakat.')],
            ['Posyandu Balita: Jadwal Bulan Ini', 'Kesehatan', $this->p('Posyandu balita dilaksanakan di masing-masing dusun mulai pukul 08.00 WITA. Ibu-ibu diharapkan membawa buku KIA.', '<ul><li>Dusun A: Selasa minggu pertama</li><li>Dusun B: Kamis minggu pertama</li><li>Dusun C: Selasa minggu kedua</li><li>Dusun D: Kamis minggu kedua</li></ul>')],
            ['Pelatihan Pengemasan Produk BUMDes', 'Ekonomi', $this->p('Sebanyak 25 pelaku usaha mengikuti pelatihan pengemasan dan pelabelan produk. Gula lontar dan madu hutan kini dikemas dengan label baru yang lebih menarik untuk dipasarkan ke Kota Kupang.')],
            ['Penyaluran BLT Dana Desa Tahap III', 'Bantuan Sosial', $this->p('Penyaluran BLT Dana Desa tahap III kepada 48 keluarga penerima manfaat berlangsung tertib di kantor desa, disaksikan BPD dan pendamping desa.')],
        ]);
        foreach ([['Melki Taneo', '0812xxxx1001', 'surat', ['jenis_surat' => 'Surat Keterangan Usaha', 'dusun' => 'Dusun B / RT 05', 'keperluan' => 'Pengajuan KUR']], ['Ana Selan', '0813xxxx2002', 'pesan', ['pesan' => 'Mohon lampu jalan di Dusun D diperbaiki.']]] as [$n, $k, $t, $d]) {
            Kiriman::create(['demo_id' => $this->demo->id, 'nama' => $n, 'kontak' => $k, 'tipe' => $t, 'data' => $d]);
        }
    }

    // ------------------------------------------------------------------ SEKOLAH

    private function sekolah(): void
    {
        $this->buat([
            'jenis' => 'sekolah', 'nama' => 'SMA Cahaya Flobamora', 'logo_teks' => 'CF',
            'warna' => '#1E3A8A', 'warna_aksen' => '#F5B800',
            'tagline' => 'Sekolah berkarakter, berprestasi, dan berwawasan global dari Kupang.',
            'hero_judul' => 'Tempat terbaik untuk tumbuh dan berprestasi',
            'hero_sub' => 'Pembelajaran aktif, pembinaan karakter, dan ekstrakurikuler yang mengasah bakat setiap siswa.',
            'alamat' => 'Jl. Pendidikan No. 10, Kota Kupang, NTT', 'telepon' => '0380-000111',
            'whatsapp' => config('demo.whatsapp'), 'email' => 'info@cahayaflobamora.sch.id', 'jam_layanan' => 'Senin–Sabtu, 07.00–14.00 WITA',
            'visi' => 'Menjadi sekolah unggul yang melahirkan generasi beriman, berkarakter, cerdas, dan peduli lingkungan.',
            'misi' => ['Menyelenggarakan pembelajaran aktif dan menyenangkan', 'Membina karakter dan disiplin siswa', 'Mengembangkan bakat melalui ekstrakurikuler', 'Membangun budaya literasi dan teknologi'],
            'profil' => $this->p('<h2>Tentang sekolah</h2>', 'SMA Cahaya Flobamora berdiri sejak 1998 dan kini terakreditasi A. Sekolah memiliki 24 rombongan belajar dengan program peminatan sesuai Kurikulum Merdeka.', 'Fasilitas meliputi laboratorium IPA, laboratorium komputer, perpustakaan digital, lapangan olahraga, dan aula serbaguna.', '<h2>Budaya sekolah</h2>', 'Setiap hari diawali dengan literasi 15 menit. Siswa juga terlibat dalam program bank sampah dan kebun sekolah.'),
            'data' => [
                'sub_nama' => 'Terakreditasi A · Kota Kupang', 'tipe_orang' => 'guru', 'judul_profil' => 'Profil Sekolah',
                'kepala' => ['nama' => 'Dra. Yuliana R. Bria, M.Pd.', 'judul' => 'Mendidik dengan hati, membangun masa depan', 'sambutan' => 'Kami percaya setiap anak punya potensi unik. Tugas sekolah adalah menyediakan ruang aman untuk belajar, mencoba, dan bertumbuh. Website ini menjadi jembatan komunikasi antara sekolah, siswa, dan orang tua.'],
                'ppdb' => [
                    'jadwal' => [['Pendaftaran online', '1 – 20 Juni'], ['Verifikasi berkas', '21 – 25 Juni'], ['Pengumuman hasil', '28 Juni'], ['Daftar ulang', '1 – 5 Juli']],
                    'berkas' => ['Akta kelahiran', 'Kartu Keluarga', 'Rapor semester 1–5 SMP', 'Sertifikat prestasi (jika ada)', 'Pas foto 3x4'],
                ],
            ],
        ]);
        $this->items('statistik', [['nama' => 'Siswa aktif', 'subjudul' => '812'], ['nama' => 'Guru & staf', 'subjudul' => '56'], ['nama' => 'Ekstrakurikuler', 'subjudul' => '18'], ['nama' => 'Lulusan PTN', 'subjudul' => '64%']]);
        $this->items('program', [
            ['nama' => 'Kelas Literasi Digital', 'ikon' => '💻', 'deskripsi' => 'Siswa belajar membuat konten, desain, dan dasar pemrograman.'],
            ['nama' => 'Sains & Olimpiade', 'ikon' => '🔬', 'deskripsi' => 'Pembinaan intensif untuk OSN dan lomba sains.'],
            ['nama' => 'Seni & Budaya NTT', 'ikon' => '🎶', 'deskripsi' => 'Sasando, tari daerah, dan tenun sebagai muatan lokal.'],
            ['nama' => 'Sekolah Adiwiyata', 'ikon' => '🌱', 'deskripsi' => 'Bank sampah, kebun sekolah, dan gerakan hemat air.'],
        ]);
        $this->items('prestasi', [
            ['nama' => 'Juara 1 Lomba Debat Bahasa Inggris', 'subjudul' => 'Tingkat Provinsi NTT', 'ikon' => '🏆'],
            ['nama' => 'Medali Perak OSN Matematika', 'subjudul' => 'Tingkat Provinsi NTT', 'ikon' => '🥈'],
            ['nama' => 'Juara 2 Festival Sasando Pelajar', 'subjudul' => 'Tingkat Kota Kupang', 'ikon' => '🎵'],
            ['nama' => 'Juara 1 Futsal Pelajar', 'subjudul' => 'Tingkat Kota Kupang', 'ikon' => '⚽'],
        ]);
        $guru = [['Dra. Yuliana R. Bria, M.Pd.', 'Kepala Sekolah'], ['Petrus Lake, S.Pd.', 'Wakasek Kurikulum'], ['Ester Ndun, S.Pd.', 'Guru Matematika'], ['Yohanis Sabu, S.Si.', 'Guru Fisika'], ['Margaretha Lay, S.Pd.', 'Guru Bahasa Inggris'], ['Simon Tallo, S.Kom.', 'Guru Informatika'], ['Rosalina Pah, S.Pd.', 'Guru Seni Budaya'], ['Frengky Missa, S.Pd.', 'Guru PJOK']];
        $this->items('guru', array_map(fn ($g) => ['nama' => $g[0], 'subjudul' => $g[1], 'ikon' => '🎓'], $guru));
        $this->items('galeri', array_map(fn ($g) => ['nama' => $g[0], 'data' => ['warna' => $g[1]]], [['Upacara Hari Pendidikan', '#1E3A8A'], ['Praktikum Kimia', '#2563EB'], ['Pentas Seni Akhir Tahun', '#B45309'], ['Kebun Sekolah', '#15803D'], ['Lomba Debat Provinsi', '#7C3AED'], ['Kemah Pramuka', '#92400E']]));
        $this->posts([
            ['Tim Debat Raih Juara 1 Tingkat Provinsi', 'Prestasi', $this->p('Tim debat bahasa Inggris SMA Cahaya Flobamora meraih juara pertama setelah mengalahkan 32 tim dari seluruh NTT.', 'Kepala sekolah menyampaikan apresiasi kepada siswa dan guru pembina atas latihan rutin selama tiga bulan.')],
            ['Informasi PPDB Tahun Ajaran Baru', 'Pengumuman', $this->p('Pendaftaran peserta didik baru dibuka secara online melalui website sekolah. Jalur yang tersedia: zonasi, prestasi, afirmasi, dan perpindahan tugas orang tua.', 'Calon siswa dapat mengisi formulir di menu PPDB. Panitia akan menghubungi orang tua untuk verifikasi berkas.')],
            ['Gerakan Bank Sampah Kumpulkan 1,2 Ton Sampah Plastik', 'Kegiatan', $this->p('Selama satu semester, program bank sampah berhasil mengumpulkan 1,2 ton sampah plastik yang ditukar menjadi tabungan siswa.')],
            ['Jadwal Penilaian Akhir Semester', 'Akademik', $this->p('Penilaian akhir semester ganjil dilaksanakan selama satu minggu. Siswa wajib hadir 15 menit sebelum ujian dimulai dan membawa kartu ujian.')],
        ]);
        Kiriman::create(['demo_id' => $this->demo->id, 'tipe' => 'ppdb', 'nama' => 'Kezia Amalo', 'kontak' => '0812xxxx3003', 'data' => ['nisn' => '0081234567', 'asal_sekolah' => 'SMP Negeri Contoh', 'jalur' => 'Prestasi', 'nama_ortu' => 'Yakobus Amalo']]);
    }

    // ------------------------------------------------------------------ UMKM

    private function umkm(): void
    {
        $this->buat([
            'jenis' => 'umkm', 'nama' => 'Tenun Mama Lena', 'logo_teks' => 'ML',
            'warna' => '#7A1F2B', 'warna_aksen' => '#D9A441',
            'tagline' => 'Kain tenun ikat tangan dari NTT, dikerjakan oleh mama-mama penenun di kampung.',
            'hero_judul' => 'Setiap helai menyimpan cerita',
            'hero_sub' => 'Kain tenun ikat asli, ditenun tangan dengan pewarna alam. Langsung dari penenun, dikirim ke seluruh Indonesia.',
            'deskripsi' => 'Tenun Mama Lena berawal dari satu alat tenun di kolong rumah. Kini kami bekerja bersama 14 penenun perempuan. Setiap pembelian membantu mama-mama tetap menenun dan mewariskan motif kepada anak-anak mereka.',
            'alamat' => 'Kota Kupang, NTT', 'telepon' => '0812-0000-0000', 'whatsapp' => config('demo.whatsapp'),
            'email' => 'halo@tenunmamalena.id', 'jam_layanan' => 'Setiap hari, 08.00–20.00 WITA',
            'profil' => $this->p('<h2>Cerita kami</h2>', 'Mama Lena belajar menenun dari ibunya sejak usia 12 tahun. Motif-motif yang ia kerjakan adalah warisan keluarga: setiap garis dan warna punya arti.', 'Pada 2019 kami mulai menjual kain lewat media sosial. Sekarang kami bekerja bersama 14 penenun dari tiga kampung, dengan harga yang adil untuk setiap kain.', '<h2>Proses</h2>', 'Satu kain sarung membutuhkan 3–8 minggu: memintal, mengikat motif, mencelup pewarna alam (mengkudu, tarum, kunyit), hingga menenun.'),
            'data' => ['sub_nama' => 'Tenun ikat tangan · NTT', 'cerita_judul' => 'Dari kolong rumah, untuk Indonesia', 'judul_profil' => 'Tentang Kami'],
        ]);
        $produk = [
            ['Selendang Ikat Merah Mengkudu', 'Selendang', 275_000, '#8E2A2A', true, '200 x 50 cm', 'Benang katun, pewarna mengkudu'],
            ['Sarung Tenun Motif Kuda', 'Sarung', 1_250_000, '#3B2A20', true, '180 x 140 cm', 'Benang katun, pewarna alam'],
            ['Kain Ikat Biru Tarum', 'Kain', 950_000, '#1F3A5F', true, '200 x 110 cm', 'Benang katun, pewarna tarum'],
            ['Selendang Sotis Kuning', 'Selendang', 325_000, '#B8862B', false, '200 x 45 cm', 'Benang katun'],
            ['Syal Tenun Harian', 'Aksesori', 150_000, '#6B3E26', false, '160 x 25 cm', 'Benang katun'],
            ['Tas Selempang Tenun', 'Aksesori', 225_000, '#5B2333', false, '25 x 20 cm', 'Kain tenun & kulit sintetis'],
            ['Kain Ikat Motif Bintang', 'Kain', 1_100_000, '#2E2A4F', false, '200 x 120 cm', 'Benang katun, pewarna alam'],
            ['Sarung Sotis Hitam Emas', 'Sarung', 1_450_000, '#1E1A17', false, '180 x 140 cm', 'Benang katun & benang emas'],
        ];
        $this->items('produk', array_map(fn ($p) => ['nama' => $p[0], 'subjudul' => $p[1], 'harga' => $p[2], 'deskripsi' => 'Ditenun tangan oleh penenun kami dengan motif warisan keluarga. Setiap kain unik dan tidak ada yang persis sama.', 'data' => ['warna' => $p[3], 'unggulan' => $p[4], 'ukuran' => $p[5], 'bahan' => $p[6], 'asal' => 'Nusa Tenggara Timur', 'pengerjaan' => 'Tenun tangan, 3–8 minggu']], $produk));
        $this->items('keunggulan', [
            ['nama' => 'Tenun tangan asli', 'deskripsi' => 'Bukan printing. Setiap kain dikerjakan tangan di alat tenun tradisional.'],
            ['nama' => 'Pewarna alam', 'deskripsi' => 'Mengkudu, tarum, dan kunyit — ramah lingkungan dan tahan lama.'],
            ['nama' => 'Harga adil', 'deskripsi' => 'Penenun menerima bagian yang layak dari setiap penjualan.'],
        ]);
        $this->posts([
            ['Mengenal Pewarna Alam dari Akar Mengkudu', 'Proses', $this->p('Warna merah bata yang khas pada tenun NTT berasal dari akar mengkudu. Akar ditumbuk, direndam, lalu benang dicelup berulang kali selama berhari-hari.', 'Semakin sering dicelup, semakin pekat warnanya. Inilah sebabnya kain pewarna alam terasa "hidup".')],
            ['Cara Merawat Kain Tenun agar Awet', 'Tips', $this->p('<ol><li>Cuci dengan tangan menggunakan sabun lembut.</li><li>Jangan diperas, cukup ditekan.</li><li>Jemur di tempat teduh, bukan di bawah matahari langsung.</li><li>Simpan dalam keadaan terlipat dengan kapur barus terbungkus kain.</li></ol>')],
            ['Bertemu Mama Ina, Penenun Termuda di Kelompok Kami', 'Cerita Penenun', $this->p('Mama Ina baru berusia 24 tahun, tapi sudah menyelesaikan lebih dari 30 kain. Ia belajar dari neneknya dan kini mengajari dua keponakannya.')],
        ]);
    }

    // ------------------------------------------------------------------ GEREJA

    private function gereja(): void
    {
        $this->buat([
            'jenis' => 'gereja', 'nama' => 'Jemaat Bukit Kasih', 'logo_teks' => 'BK',
            'warna' => '#3B2A5A', 'warna_aksen' => '#C8A35A',
            'tagline' => 'Persekutuan yang bertumbuh dalam iman, kasih, dan pelayanan.',
            'hero_judul' => 'Selamat datang di rumah Bapa',
            'hero_sub' => '', 'alamat' => 'Jl. Bukit Kasih No. 7, Kota Kupang, NTT', 'telepon' => '0380-000222',
            'whatsapp' => config('demo.whatsapp'), 'email' => 'sekretariat@bukitkasih.or.id', 'jam_layanan' => 'Kantor: Selasa–Sabtu, 09.00–14.00 WITA',
            'visi' => 'Menjadi jemaat yang bersaksi dan melayani, membawa damai sejahtera bagi sesama.',
            'misi' => ['Memperdalam persekutuan dan ibadah', 'Membina keluarga dan generasi muda', 'Melayani jemaat yang lemah dan berkekurangan', 'Merawat ciptaan Tuhan'],
            'profil' => $this->p('<h2>Sejarah jemaat</h2>', 'Jemaat Bukit Kasih bermula dari persekutuan doa keluarga pada tahun 1976. Seiring bertambahnya anggota, jemaat membangun gedung gereja yang diresmikan tahun 1988.', 'Saat ini jemaat terdiri dari 9 rayon dengan lebih dari 600 kepala keluarga.'),
            'data' => [
                'sub_nama' => 'Kota Kupang · 9 rayon', 'tipe_orang' => 'pelayan', 'judul_profil' => 'Profil Jemaat',
                'ayat' => ['teks' => 'Marilah kepada-Ku, semua yang letih lesu dan berbeban berat, Aku akan memberi kelegaan kepadamu.', 'sumber' => 'Matius 11:28'],
                'youtube' => 'https://www.youtube.com/',
                'sub_post' => 'Warta jemaat, pengumuman, dan renungan mingguan.',
            ],
        ]);
        $this->items('jadwal', [
            ['nama' => 'Ibadah Minggu Pagi', 'subjudul' => 'Minggu', 'deskripsi' => 'Bahasa Indonesia · juga disiarkan langsung', 'data' => ['jam' => '07.00']],
            ['nama' => 'Ibadah Minggu Pagi II', 'subjudul' => 'Minggu', 'deskripsi' => 'Bahasa Indonesia', 'data' => ['jam' => '09.30']],
            ['nama' => 'Ibadah Minggu Sore', 'subjudul' => 'Minggu', 'deskripsi' => 'Ibadah keluarga muda', 'data' => ['jam' => '17.00']],
            ['nama' => 'Sekolah Minggu', 'subjudul' => 'Minggu', 'deskripsi' => 'Anak usia 3–12 tahun', 'data' => ['jam' => '08.30']],
            ['nama' => 'Ibadah Rayon', 'subjudul' => 'Rabu', 'deskripsi' => 'Bergilir di rumah jemaat tiap rayon', 'data' => ['jam' => '18.30']],
            ['nama' => 'Persekutuan Pemuda', 'subjudul' => 'Sabtu', 'deskripsi' => 'Aula gereja', 'data' => ['jam' => '18.00']],
        ]);
        $this->items('pelayan', [['nama' => 'Pdt. Samuel E. Lusi, S.Th.', 'subjudul' => 'Ketua Majelis Jemaat', 'ikon' => '✝️'], ['nama' => 'Pnt. Debora Manafe', 'subjudul' => 'Sekretaris', 'ikon' => '👤'], ['nama' => 'Pnt. Herman Toy', 'subjudul' => 'Bendahara', 'ikon' => '👤'], ['nama' => 'Dkn. Lidia Nalle', 'subjudul' => 'Koordinator Diakonia', 'ikon' => '👤']]);
        $this->items('pelayanan', [
            ['nama' => 'Anak', 'ikon' => '🧒', 'deskripsi' => 'Sekolah Minggu dan kelas katekisasi anak.', 'subjudul' => 'Minggu, 08.30'],
            ['nama' => 'Pemuda', 'ikon' => '🎸', 'deskripsi' => 'Persekutuan, paduan suara, dan kegiatan sosial.', 'subjudul' => 'Sabtu, 18.00'],
            ['nama' => 'Kaum Perempuan', 'ikon' => '🌸', 'deskripsi' => 'Persekutuan doa, keterampilan, dan diakonia.', 'subjudul' => 'Kamis, 16.00'],
            ['nama' => 'Kaum Bapak', 'ikon' => '🤝', 'deskripsi' => 'Pembinaan keluarga dan kepemimpinan.', 'subjudul' => 'Jumat malam'],
        ]);
        $this->items('rekening', [['nama' => 'Persembahan Umum', 'subjudul' => 'Bank Demo', 'data' => ['nomor' => '0000 1111 2222', 'atas_nama' => 'Jemaat Bukit Kasih']], ['nama' => 'Dana Pembangunan', 'subjudul' => 'Bank Demo', 'data' => ['nomor' => '0000 3333 4444', 'atas_nama' => 'Panitia Pembangunan']]]);
        $this->posts([
            ['Berjalan dalam Terang', 'Renungan', $this->p('“Firman-Mu itu pelita bagi kakiku dan terang bagi jalanku.” (Mazmur 119:105)', 'Pelita di zaman dulu hanya menerangi beberapa langkah ke depan. Begitu juga firman Tuhan: kita tidak selalu melihat seluruh jalan, tetapi cukup terang untuk langkah hari ini.', 'Minggu ini, mari luangkan waktu setiap pagi membaca satu pasal dan bertanya: langkah apa yang Tuhan terangi untukku hari ini?')],
            ['Warta Jemaat Minggu Ini', 'Warta', $this->p('<ul><li>Ibadah syukur HUT Jemaat akan dilaksanakan Minggu depan pukul 09.30 WITA.</li><li>Katekisasi angkatan baru dimulai Sabtu pukul 15.00 di aula.</li><li>Jemaat yang sakit: mohon didoakan dan dikunjungi.</li></ul>')],
            ['Bakti Sosial Pemuda di Panti Asuhan', 'Kegiatan', $this->p('Persekutuan pemuda mengunjungi panti asuhan dan menyerahkan bantuan sembako serta perlengkapan sekolah hasil penggalangan dana bulan lalu.')],
            ['Pendaftaran Katekisasi Angkatan Baru', 'Pengumuman', $this->p('Pendaftaran katekisasi dibuka untuk remaja usia 15 tahun ke atas. Formulir tersedia di kantor sekretariat.')],
        ]);
    }

    // ------------------------------------------------------------------ HOTEL

    private function hotel(): void
    {
        $this->buat([
            'jenis' => 'hotel', 'nama' => 'Lontar Bay Resort', 'logo_teks' => 'LB',
            'warna' => '#0E5E6F', 'warna_aksen' => '#D8B98A',
            'tagline' => 'Resor tepi pantai dengan suasana tenang, sarapan khas NTT, dan matahari terbenam terbaik di Kupang.',
            'hero_judul' => 'Beristirahat di tepi laut Timor',
            'hero_sub' => 'Kamar menghadap laut, sarapan dengan bahan lokal, dan pelayanan yang hangat.',
            'deskripsi' => 'Lontar Bay Resort memiliki 32 kamar yang tersebar di taman tropis seluas dua hektare. Lima menit ke pantai, dua puluh menit dari bandara, dan dekat dengan berbagai destinasi wisata di Pulau Timor.',
            'alamat' => 'Jl. Pantai Lontar, Kota Kupang, NTT', 'telepon' => '0380-000333', 'whatsapp' => config('demo.whatsapp'),
            'email' => 'reservasi@lontarbay.id', 'jam_layanan' => 'Resepsionis 24 jam',
            'profil' => $this->p('<h2>Tentang resor</h2>', 'Dibangun dengan arsitektur yang terinspirasi rumah adat NTT, setiap bangunan beratap tinggi dan berventilasi alami sehingga tetap sejuk.', 'Kami bekerja sama dengan petani dan nelayan sekitar untuk bahan makanan restoran.'),
            'data' => ['sub_nama' => 'Kupang · Nusa Tenggara Timur', 'sambutan_judul' => 'Tenang, dekat laut, dan dekat kota', 'jam_checkin' => 'Check-in 14.00 · Check-out 12.00', 'pembatalan' => 'Gratis pembatalan hingga 48 jam sebelum kedatangan.', 'judul_profil' => 'Tentang Kami'],
        ]);
        $this->items('kamar', [
            ['nama' => 'Deluxe Garden', 'subjudul' => 'Pemandangan taman · 28 m²', 'harga' => 650_000, 'deskripsi' => 'Kamar nyaman dengan teras pribadi menghadap taman tropis. Cocok untuk perjalanan dinas maupun liburan singkat.', 'data' => ['warna' => '#3F7F6B', 'kapasitas' => '2 dewasa', 'ukuran' => '28 m²', 'ranjang' => 'King / Twin', 'fasilitas' => ['AC', 'Wi-Fi', 'Air panas', 'TV', 'Kulkas mini', 'Teras pribadi']]],
            ['nama' => 'Ocean View', 'subjudul' => 'Menghadap laut · 32 m²', 'harga' => 950_000, 'deskripsi' => 'Bangun pagi dengan suara ombak. Balkon menghadap laut dan matahari terbenam.', 'data' => ['warna' => '#0E5E6F', 'kapasitas' => '2 dewasa + 1 anak', 'ukuran' => '32 m²', 'ranjang' => 'King', 'fasilitas' => ['AC', 'Wi-Fi', 'Air panas', 'Smart TV', 'Kulkas mini', 'Balkon', 'Bathtub']]],
            ['nama' => 'Family Lumbung', 'subjudul' => 'Vila keluarga · 54 m²', 'harga' => 1_650_000, 'deskripsi' => 'Vila berbentuk lumbung dengan dua kamar tidur dan ruang keluarga. Ideal untuk liburan bersama.', 'data' => ['warna' => '#7A5A3A', 'kapasitas' => '4 dewasa + 2 anak', 'ukuran' => '54 m²', 'ranjang' => '1 King + 2 Single', 'fasilitas' => ['AC', 'Wi-Fi', 'Air panas', 'Smart TV', 'Dapur kecil', 'Ruang keluarga', 'Teras']]],
        ]);
        $this->items('fasilitas', [
            ['nama' => 'Kolam renang', 'ikon' => '🏊', 'subjudul' => '06.00–21.00', 'deskripsi' => 'Kolam infinity menghadap laut dengan area anak.'],
            ['nama' => 'Restoran Sasando', 'ikon' => '🍽️', 'subjudul' => '06.30–22.00', 'deskripsi' => 'Menu Nusantara dan khas NTT: se\'i, jagung bose, ikan kuah asam.'],
            ['nama' => 'Ruang rapat', 'ikon' => '📊', 'subjudul' => 'Kapasitas 80 orang', 'deskripsi' => 'Lengkap dengan proyektor dan paket rapat.'],
            ['nama' => 'Antar-jemput bandara', 'ikon' => '🚐', 'subjudul' => 'Dengan reservasi', 'deskripsi' => 'Penjemputan dari Bandara El Tari.'],
            ['nama' => 'Wi-Fi cepat', 'ikon' => '📶', 'subjudul' => 'Seluruh area', 'deskripsi' => 'Gratis untuk semua tamu.'],
            ['nama' => 'Parkir luas', 'ikon' => '🅿️', 'subjudul' => 'Gratis', 'deskripsi' => 'Area parkir aman dengan CCTV.'],
            ['nama' => 'Spa & pijat', 'ikon' => '💆', 'subjudul' => '10.00–20.00', 'deskripsi' => 'Pijat tradisional dengan minyak kelapa lokal.'],
            ['nama' => 'Sewa motor', 'ikon' => '🛵', 'subjudul' => 'Harian', 'deskripsi' => 'Jelajahi Kupang dengan bebas.'],
        ]);
        $this->items('wisata', [
            ['nama' => 'Pantai berpasir putih', 'subjudul' => '5 menit', 'deskripsi' => 'Tempat favorit menikmati matahari terbenam dan kuliner ikan bakar.', 'data' => ['warna' => '#2A8BA0']],
            ['nama' => 'Air terjun di perbukitan', 'subjudul' => '45 menit', 'deskripsi' => 'Kolam alami berair jernih di tengah hutan, cocok untuk berenang.', 'data' => ['warna' => '#2F6B4F']],
            ['nama' => 'Desa adat & tenun', 'subjudul' => '60 menit', 'deskripsi' => 'Melihat rumah adat dan proses menenun langsung dari mama-mama penenun.', 'data' => ['warna' => '#8A3B2B']],
            ['nama' => 'Pulau kecil untuk snorkeling', 'subjudul' => '30 menit + perahu', 'deskripsi' => 'Terumbu karang dan ikan warna-warni. Paket perahu bisa diatur resepsionis.', 'data' => ['warna' => '#1C6E8C']],
        ]);
        $this->posts([['Paket Bulan Madu Akhir Tahun', 'Promo', $this->p('Menginap 2 malam di kamar Ocean View, makan malam romantis di tepi pantai, dan pijat untuk dua orang.')], ['Paket Rapat Setengah Hari', 'Bisnis', $this->p('Termasuk ruang rapat, satu kali rehat kopi, dan makan siang untuk minimal 20 peserta.')]]);
        Kiriman::create(['demo_id' => $this->demo->id, 'tipe' => 'reservasi', 'nama' => 'Budi Santoso', 'kontak' => '0811xxxx4004', 'data' => ['kamar' => 'Ocean View', 'check_in' => now()->addDays(10)->toDateString(), 'check_out' => now()->addDays(12)->toDateString(), 'tamu' => '2']]);
    }

    // ------------------------------------------------------------------ UNDANGAN

    private function undangan(): void
    {
        $tanggal = now()->addDays(45)->setTime(10, 0);
        $this->buat([
            'jenis' => 'undangan', 'nama' => 'Yohanes & Maria', 'logo_teks' => 'YM',
            'warna' => '#6B4E2E', 'warna_aksen' => '#C9A46A',
            'tagline' => 'Undangan pernikahan Yohanes & Maria',
            'data' => [
                'tanggal' => $tanggal->toDateTimeString(),
                'salam' => 'Dengan penuh sukacita dan atas berkat Tuhan, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dalam pernikahan kami:',
                'pria' => ['panggilan' => 'Yohanes', 'nama' => 'Yohanes Kristian', 'anak' => 'Putra kedua dari', 'ortu' => 'Bpk. Markus Talan & Ibu Ruth Talan'],
                'wanita' => ['panggilan' => 'Maria', 'nama' => 'Maria Natalia', 'anak' => 'Putri sulung dari', 'ortu' => 'Bpk. Petrus Leo & Ibu Yuliana Leo'],
                'ayat' => ['teks' => 'Demikianlah mereka bukan lagi dua, melainkan satu. Karena itu, apa yang telah dipersatukan Allah, tidak boleh diceraikan manusia.', 'sumber' => 'Matius 19:6'],
            ],
        ]);
        $this->items('acara', [
            ['nama' => 'Pemberkatan Nikah', 'subjudul' => 'Pukul 10.00 WITA', 'deskripsi' => 'Jl. Contoh Raya No. 1, Kota Kupang', 'data' => ['tempat' => 'Gereja Jemaat Bukit Kasih']],
            ['nama' => 'Resepsi', 'subjudul' => 'Pukul 18.00 WITA – selesai', 'deskripsi' => 'Jl. Contoh Pantai No. 2, Kota Kupang', 'data' => ['tempat' => 'Aula Lontar Bay']],
        ]);
        $this->items('kisah', [
            ['nama' => 'Pertama bertemu', 'subjudul' => '2019', 'deskripsi' => 'Kami bertemu di paduan suara pemuda gereja. Yohanes bas, Maria sopran — selalu berdiri di barisan yang berseberangan.'],
            ['nama' => 'Mulai bersama', 'subjudul' => '2021', 'deskripsi' => 'Setelah dua tahun berteman, Yohanes memberanikan diri mengajak Maria makan jagung bose di pinggir pantai.'],
            ['nama' => 'Lamaran', 'subjudul' => '2025', 'deskripsi' => 'Dengan restu kedua keluarga dan adat yang lengkap, kami resmi bertunangan.'],
        ]);
        $this->items('galeri', array_map(fn ($w) => ['nama' => 'Momen kami', 'data' => ['warna' => $w]], ['#6B4E2E', '#8C6A43', '#A4835A', '#5C4630', '#7D5D3B']));
        $this->items('hadiah', [['nama' => 'Bank Demo', 'data' => ['nomor' => '0000 5555 6666', 'atas_nama' => 'Yohanes Kristian']], ['nama' => 'Dompet Digital Demo', 'data' => ['nomor' => '0812 0000 0000', 'atas_nama' => 'Maria Natalia']]]);
        foreach ([['Keluarga Besar Talan', 'Hadir', 'Selamat menempuh hidup baru! Tuhan memberkati rumah tangga kalian.'], ['Teman Paduan Suara', 'Hadir', 'Akhirnya bas dan sopran bersatu juga 😄 Bahagia selalu!'], ['Om Frans di Surabaya', 'Tidak bisa hadir', 'Maaf belum bisa pulang. Doa dari jauh untuk kalian berdua.']] as $i => [$n, $h, $u]) {
            Kiriman::create(['demo_id' => $this->demo->id, 'tipe' => 'rsvp', 'nama' => $n, 'data' => ['kehadiran' => $h, 'ucapan' => $u], 'created_at' => now()->subHours(($i + 1) * 7)]);
        }
    }
}
