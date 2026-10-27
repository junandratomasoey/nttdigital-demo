<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ResetDemo extends Command
{
    protected $signature = 'demo:reset {--force : Jalankan tanpa konfirmasi (untuk cron)}';
    protected $description = 'Kembalikan semua website demo ke isi awal (hapus data & upload dari pengunjung)';

    public function handle(): int
    {
        if (! $this->option('force') && ! $this->confirm('Semua data demo akan dihapus dan diisi ulang. Lanjut?')) {
            return self::FAILURE;
        }

        // Hapus file yang diunggah pengunjung lewat panel admin
        foreach (['demo-upload', 'livewire-tmp'] as $folder) {
            Storage::disk('public')->deleteDirectory($folder);
        }

        $this->call('migrate:fresh', ['--seed' => true, '--force' => true]);
        $this->info('Demo berhasil di-reset.');

        return self::SUCCESS;
    }
}
