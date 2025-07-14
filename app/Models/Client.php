<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'nomComplet',
        'id_contact',
    ];
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $timestamps = true;

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact', 'id');
    }
    public function ventes()
    {
        return $this->hasMany(Vente::class, 'id_client', 'id');
    }
}
