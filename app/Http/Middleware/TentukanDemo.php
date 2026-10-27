<?php

namespace App\Http\Middleware;

use App\Models\Demo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Menentukan demo yang sedang dibuka dari subdomain:
 *   demo-desa.nttdigital.site  -> jenis "desa"
 * Untuk uji lokal: ?demo=desa (disimpan di session), ?demo=0 untuk keluar.
 * Hasilnya dipasang di container sebagai app('demo') dan dibagikan ke view sebagai $demo.
 */
class TentukanDemo
{
    public function handle(Request $request, Closure $next): Response
    {
        $jenis = null;

        if (preg_match('/^demo-([a-z]+)\./', $request->getHost(), $m)) {
            $jenis = $m[1];
        } elseif ($request->hasSession()) {
            if ($request->has('demo')) {
                $request->session()->put('demo_lokal', $request->query('demo') ?: null);
            }
            $jenis = $request->session()->get('demo_lokal');
        }

        if ($jenis) {
            $demo = Demo::where('jenis', $jenis)->first();
            abort_unless($demo, 404, 'Demo tidak ditemukan');
            app()->instance('demo', $demo);
            View::share('demo', $demo);
        }

        return $next($request);
    }
}
