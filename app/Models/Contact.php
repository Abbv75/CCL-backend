<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'telephone',
        'email',
        'address',
        'whatsapp',
    ];
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id_contact');
    }
    public function boutique()
    {
        return $this->hasMany(Boutique::class, 'id_contact');
    }
}
