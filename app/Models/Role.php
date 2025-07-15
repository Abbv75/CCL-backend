<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Role extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'name',
        'description',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id_role');
    }
}
