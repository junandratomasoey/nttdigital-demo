<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kiriman extends Model
{
    use MilikDemo;

    protected $table = 'kiriman';
    protected $guarded = ['id'];
    protected $casts = ['data' => 'array'];
}
