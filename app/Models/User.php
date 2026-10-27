<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = ['demo_id', 'name', 'email', 'password'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    /** Admin hanya bisa masuk ke panel demo miliknya sendiri. */
    public function canAccessPanel(Panel $panel): bool
    {
        return app()->bound('demo') && (int) $this->demo_id === (int) app('demo')->id;
    }
}
