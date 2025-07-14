<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_boutique'
    ];
    protected $table = 'employers';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'id_boutique', 'id');
    }
}
