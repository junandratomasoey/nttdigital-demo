# NTT Digital — Website Demo

Satu aplikasi Laravel 11 + Filament yang melayani 6 website demo lewat subdomain:

| Subdomain | Demo | Halaman |
|---|---|---|
| `demo-desa.nttdigital.com` | Desa Lontar Asri | beranda, profil, berita, APBDes, layanan surat online, produk desa, kontak |
| `demo-sekolah.nttdigital.com` | SMA Cahaya Flobamora | beranda, profil, berita, guru, galeri, PPDB online, kontak |
| `demo-umkm.nttdigital.com` | Tenun Mama Lena | beranda, katalog + filter, detail produk + pesan WA, cerita, kontak |
| `demo-gereja.nttdigital.com` | Jemaat Bukit Kasih | beranda, jadwal ibadah, warta, pelayanan, persembahan & doa |
| `demo-hotel.nttdigital.com` | Lontar Bay Resort | beranda + cari kamar, kamar, detail kamar, fasilitas, wisata, reservasi |
| `demo-undangan.nttdigital.com` | Yohanes & Maria | undangan satu halaman: sampul, countdown, acara, RSVP, buku ucapan |

Semua nama, orang, nomor rekening, dan angka **fiktif**. Setiap halaman punya pita "DEMO" dan
`noindex` agar tidak dikira situs resmi dan tidak bersaing di Google dengan nttdigital.com.

**Panel admin** tiap demo: `https://demo-{jenis}.nttdigital.com/admin`
Email `admin@{jenis}.demo`, kata sandi `demo1234` (lihat `DEMO_ADMIN_PASSWORD`).
Admin hanya bisa masuk ke demo miliknya. Semua data di-reset setiap pukul 02.00 WITA.

---

## Jalankan di laptop (Herd)

```bash
composer install
copy .env.example .env          # lalu sesuaikan DB_DATABASE ke path lokal, APP_ENV=local, APP_DEBUG=true
php artisan key:generate
type nul > database\demo.sqlite  # (Linux/Mac: touch database/demo.sqlite)
php artisan migrate:fresh --seed
php artisan storage:link
```

Buka `http://nttdigital-demo.test` → daftar semua demo. Klik salah satu (memakai `?demo=desa`,
tersimpan di session; `?demo=0` untuk kembali ke daftar).

Ubah tampilan? CSS dibangun dengan Tailwind CLI dan hasilnya (`public/css/demo.css`) ikut di-commit,
jadi server **tidak perlu npm**:

```bash
npm install
npm run build      # atau: npm run watch
```

---

## Deploy ke server Ubuntu

### 1. DNS
Di pengelola domain nttdigital.com, tambahkan record **A** yang mengarah ke IP publik server:

```
demo-desa      A   <IP-SERVER>
demo-sekolah   A   <IP-SERVER>
demo-umkm      A   <IP-SERVER>
demo-gereja    A   <IP-SERVER>
demo-hotel     A   <IP-SERVER>
demo-undangan  A   <IP-SERVER>
```

### 2. Ambil kode & install

```bash
cd /var/www
sudo git clone https://github.com/<akun>/nttdigital-demo.git
sudo chown -R www-data:www-data nttdigital-demo
sudo chmod -R g+rwX nttdigital-demo
cd nttdigital-demo
composer install --no-dev --optimize-autoloader
cp .env.example .env && php artisan key:generate
touch database/demo.sqlite
php artisan migrate:fresh --seed --force
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
sudo chown -R www-data:www-data storage bootstrap/cache database
```

Butuh ekstensi PHP `pdo_sqlite` (`sudo apt install php8.4-sqlite3`, sesuaikan versi PHP).

### 3a. Nginx — `/etc/nginx/sites-available/nttdigital-demo`

```nginx
server {
    listen 80;
    server_name demo-desa.nttdigital.com demo-sekolah.nttdigital.com demo-umkm.nttdigital.com
                demo-gereja.nttdigital.com demo-hotel.nttdigital.com demo-undangan.nttdigital.com;
    root /var/www/nttdigital-demo/public;
    index index.php;
    client_max_body_size 8M;

    location / { try_files $uri $uri/ /index.php?$query_string; }
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;   # sesuaikan versi PHP
    }
    location ~ /\.(?!well-known) { deny all; }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/nttdigital-demo /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

### 3b. Apache (jika server memakai Apache) — `/etc/apache2/sites-available/nttdigital-demo.conf`

```apache
<VirtualHost *:80>
    ServerName demo-desa.nttdigital.com
    ServerAlias demo-sekolah.nttdigital.com demo-umkm.nttdigital.com demo-gereja.nttdigital.com demo-hotel.nttdigital.com demo-undangan.nttdigital.com
    DocumentRoot /var/www/nttdigital-demo/public
    <Directory /var/www/nttdigital-demo/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

```bash
sudo a2ensite nttdigital-demo && sudo a2enmod rewrite && sudo systemctl reload apache2
```

### 4. HTTPS (Let's Encrypt)

```bash
sudo certbot --nginx   -d demo-desa.nttdigital.com -d demo-sekolah.nttdigital.com -d demo-umkm.nttdigital.com \
                       -d demo-gereja.nttdigital.com -d demo-hotel.nttdigital.com -d demo-undangan.nttdigital.com
# Apache: ganti --nginx dengan --apache
```

### 5. Reset otomatis tiap malam

```bash
sudo crontab -u www-data -e
# tambahkan baris:
* * * * * cd /var/www/nttdigital-demo && php artisan schedule:run >> /dev/null 2>&1
```

Reset manual kapan saja: `php artisan demo:reset`.

### Update berikutnya

```bash
cd /var/www/nttdigital-demo
git pull
composer install --no-dev --optimize-autoloader
php artisan migrate:fresh --seed --force
php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

---

## Struktur

- `config/demo.php` — daftar demo, menu, jenis konten, dan formulir per demo
- `app/Http/Middleware/TentukanDemo.php` — membaca subdomain → `app('demo')`
- `app/Models/MilikDemo.php` — membatasi semua data ke demo yang sedang dibuka
- `resources/views/demo/{jenis}/` — tema tiap demo; `demo/shared/` — halaman bersama
- `database/seeders/DemoSeeder.php` — isi contoh (ubah di sini agar perubahan bertahan setelah reset)

Menambah demo baru (mis. `puskesmas`): tambah entri di `config/demo.php`, buat folder view
`resources/views/demo/puskesmas/beranda.blade.php`, tambah method di `DemoSeeder`, dan tambah record DNS.
