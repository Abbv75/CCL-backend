<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statue extends Model
{
    use HasFactory;
    protected $fillable = [
        'media',
        'typeMedia',
        'delais',
        'id_boutique',
    ];
    protected $table = 'statues';
}
