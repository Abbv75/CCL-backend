<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomComplet',
        'login',
        'password',
        'id_role',
        'id_contact',
    ];
    protected $table = 'users';
    protected $hidden = [
        'password',
    ];
    protected $primaryKey = 'id';
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact');
    }
    public function employer()
    {
        return $this->hasMany(Employer::class, 'id_user');
    }
    public function boutiques()
    {
        return $this->hasManyThrough(
            Boutique::class,
            Employer::class,
            'id_user', // Foreign key on the employer table...
            'id', // Foreign key on the contact table...
            'id', // Local key on the boutique table...
            'id_boutique' // Local key on the employer table...
        )->with(['contact']);
    }
}
