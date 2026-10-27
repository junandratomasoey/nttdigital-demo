<?php

use Illuminate\Support\Facades\Schedule;

// Kembalikan semua demo ke isi awal setiap malam (data yang dicoba pengunjung dihapus)
Schedule::command('demo:reset --force')->dailyAt('02:00');
