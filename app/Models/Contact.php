<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Contact extends Model
{
    use HasFactory;
    use HasUuids;
    protected $fillable = [
        'telephone',
        'email',
        'address',
        'whatsapp',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'id_contact');
    }
}
