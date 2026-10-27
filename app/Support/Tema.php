<?php

namespace App\Support;

/** Huruf per jenis demo (Google Fonts) — setiap demo punya karakter berbeda. */
class Tema
{
    public const FONT = [
        'desa'     => ['display' => 'Source Serif 4', 'body' => 'Source Sans 3', 'url' => 'family=Source+Serif+4:opsz,wght@8..60,600;8..60,700&family=Source+Sans+3:wght@400;600;700'],
        'sekolah'  => ['display' => 'Baloo 2', 'body' => 'Nunito', 'url' => 'family=Baloo+2:wght@600;700;800&family=Nunito:wght@400;600;700'],
        'umkm'     => ['display' => 'DM Serif Display', 'body' => 'DM Sans', 'url' => 'family=DM+Serif+Display&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700'],
        'gereja'   => ['display' => 'Cormorant Garamond', 'body' => 'Lato', 'url' => 'family=Cormorant+Garamond:wght@500;600;700&family=Lato:wght@400;700'],
        'hotel'    => ['display' => 'Playfair Display', 'body' => 'Jost', 'url' => 'family=Playfair+Display:wght@500;600;700&family=Jost:wght@300;400;500;600'],
        'undangan' => ['display' => 'Great Vibes', 'body' => 'Cormorant Garamond', 'url' => 'family=Great+Vibes&family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400'],
    ];

    public static function font(string $jenis): array
    {
        return self::FONT[$jenis] ?? self::FONT['desa'];
    }

    public static function rupiah(?int $n): string
    {
        return 'Rp ' . number_format((int) $n, 0, ',', '.');
    }
}
