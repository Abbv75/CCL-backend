<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PartieUser extends Model
{
    use HasUuids;

    protected $table = 'partie_user';
    protected $fillable = ['id_partie', 'id_user'];
}
