<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vente extends Model
{
    use HasFactory;
    protected $fillable = [
        'montant',
        'id_boutique',
        'id_client',
    ];
    protected $table = 'ventes';
     protected $primaryKey = 'id';
    public $timestamps = true;

    public function boutique()
    {
        return $this->belongsTo(Boutique::class, 'id_boutique', 'id');
    }
    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client', 'id');
    }
    public function venteProduits()
    {
        return $this->hasMany(VenteProduit::class, 'id_vente', 'id');
    }

}
