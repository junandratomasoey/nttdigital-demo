<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('demos', function (Blueprint $table) {
            $table->id();
            $table->string('jenis')->unique();          // desa, sekolah, umkm, gereja, hotel, undangan
            $table->string('nama');                     // nama situs (fiktif)
            $table->string('tagline')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('logo_teks', 4)->nullable(); // inisial untuk logo
            $table->string('warna', 7)->default('#0F6E56');
            $table->string('warna_aksen', 7)->default('#C98A1B');
            $table->string('hero_judul')->nullable();
            $table->text('hero_sub')->nullable();
            $table->string('hero_gambar')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->string('jam_layanan')->nullable();
            $table->longText('profil')->nullable();     // HTML sejarah/tentang
            $table->text('visi')->nullable();
            $table->json('misi')->nullable();
            $table->json('data')->nullable();           // data khusus per jenis
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('demo_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demo_id')->constrained()->cascadeOnDelete();
            $table->string('judul');
            $table->string('slug');
            $table->string('kategori')->nullable();
            $table->text('ringkasan')->nullable();
            $table->longText('isi');
            $table->string('gambar')->nullable();
            $table->string('penulis')->nullable();
            $table->date('tanggal');
            $table->boolean('terbit')->default(true);
            $table->timestamps();
            $table->unique(['demo_id', 'slug']);
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demo_id')->constrained()->cascadeOnDelete();
            $table->string('tipe');                    // lihat config/demo.php -> item
            $table->string('nama');
            $table->string('slug')->nullable();
            $table->string('subjudul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->unsignedBigInteger('harga')->nullable();
            $table->string('ikon', 16)->nullable();
            $table->string('gambar')->nullable();
            $table->json('data')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
            $table->index(['demo_id', 'tipe']);
        });

        Schema::create('kiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('demo_id')->constrained()->cascadeOnDelete();
            $table->string('tipe');                    // surat, ppdb, reservasi, rsvp, doa, pesan
            $table->string('nama');
            $table->string('kontak')->nullable();
            $table->json('data')->nullable();
            $table->string('status')->default('baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kiriman');
        Schema::dropIfExists('items');
        Schema::dropIfExists('posts');
        Schema::table('users', fn (Blueprint $t) => $t->dropConstrainedForeignId('demo_id'));
        Schema::dropIfExists('demos');
    }
};
