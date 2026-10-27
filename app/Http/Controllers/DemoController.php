<?php

namespace App\Http\Controllers;

use App\Models\Demo;
use App\Models\Item;
use App\Models\Kiriman;
use App\Models\Post;
use Illuminate\Http\Request;

class DemoController extends Controller
{
    /** Halaman per jenis yang boleh dibuka (selain beranda & daftar post). */
    private const HALAMAN = [
        'desa'     => ['profil', 'apbdes', 'layanan-surat', 'produk', 'kontak'],
        'sekolah'  => ['profil', 'guru', 'galeri', 'ppdb', 'kontak'],
        'umkm'     => ['profil', 'produk', 'kontak'],
        'gereja'   => ['profil', 'jadwal', 'pelayanan', 'persembahan', 'kontak'],
        'hotel'    => ['profil', 'kamar', 'fasilitas', 'wisata', 'reservasi', 'kontak'],
        'undangan' => [],
    ];

    /** Halaman yang punya detail per item: /produk/{slug}, /kamar/{slug} */
    private const DETAIL_ITEM = ['produk' => 'produk', 'kamar' => 'kamar'];

    private function demo(): ?Demo
    {
        return app()->bound('demo') ? app('demo') : null;
    }

    public function beranda(Request $request)
    {
        $demo = $this->demo();

        if (! $demo) {
            return view('demo.daftar', ['demos' => Demo::orderBy('id')->get()]);
        }

        $posts = Post::terbit()->take(3)->get();

        return view("demo.{$demo->jenis}.beranda", [
            'posts' => $posts,
            'tamu'  => $demo->jenis === 'undangan' ? mb_substr((string) $request->query('to', ''), 0, 60) : null,
            'ucapan' => $demo->jenis === 'undangan'
                ? Kiriman::where('tipe', 'rsvp')->latest()->take(30)->get()
                : collect(),
        ]);
    }

    public function halaman(string $halaman)
    {
        $demo = $this->demo();
        abort_unless($demo, 404);

        // Daftar post: /berita, /warta, /cerita, /info
        if ($halaman === $demo->konfig('post.1')) {
            return view('demo.shared.posts', [
                'posts' => Post::terbit()->paginate(9),
                'judul' => $demo->konfig('post.0'),
            ]);
        }

        abort_unless(in_array($halaman, self::HALAMAN[$demo->jenis] ?? [], true), 404);

        $view = view()->exists("demo.{$demo->jenis}.{$halaman}")
            ? "demo.{$demo->jenis}.{$halaman}"
            : "demo.shared.{$halaman}";

        return view($view);
    }

    public function detail(string $halaman, string $slug)
    {
        $demo = $this->demo();
        abort_unless($demo, 404);

        if ($halaman === $demo->konfig('post.1')) {
            $post = Post::where('slug', $slug)->where('terbit', true)->firstOrFail();
            $lain = Post::terbit()->where('id', '!=', $post->id)->take(3)->get();
            return view('demo.shared.post', compact('post', 'lain'));
        }

        abort_unless(isset(self::DETAIL_ITEM[$halaman]) && in_array($halaman, self::HALAMAN[$demo->jenis], true), 404);

        $item = Item::where('tipe', self::DETAIL_ITEM[$halaman])->where('slug', $slug)->where('aktif', true)->firstOrFail();
        $lain = Item::where('tipe', $item->tipe)->where('aktif', true)->where('id', '!=', $item->id)->orderBy('urutan')->take(3)->get();

        return view("demo.{$demo->jenis}.{$halaman}-detail", compact('item', 'lain'));
    }

    public function kirim(Request $request, string $tipe)
    {
        $demo = $this->demo();
        abort_unless($demo && array_key_exists($tipe, $demo->konfig('form', [])), 404);

        if (filled($request->input('website'))) { // honeypot
            return back()->with('terkirim', $tipe);
        }

        $aturan = [
            'nama'   => 'required|string|max:100',
            'kontak' => 'nullable|string|max:60',
            'data'   => 'nullable|array',
            'data.*' => 'nullable|string|max:1000',
        ];
        if (in_array($tipe, ['surat', 'ppdb', 'reservasi'], true)) {
            $aturan['kontak'] = 'required|string|max:60';
        }

        $valid = $request->validate($aturan, [
            'nama.required'   => 'Nama wajib diisi.',
            'kontak.required' => 'Nomor HP/WhatsApp wajib diisi agar kami bisa menghubungi Anda.',
        ]);

        Kiriman::create([
            'tipe'   => $tipe,
            'nama'   => $valid['nama'],
            'kontak' => $valid['kontak'] ?? null,
            'data'   => array_filter($valid['data'] ?? [], fn ($v) => filled($v)),
        ]);

        return redirect()->to(url()->previous() . '#form')->with('terkirim', $tipe);
    }
}
