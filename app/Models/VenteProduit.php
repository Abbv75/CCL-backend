<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenteProduit extends Model
{
    use HasFactory;
    protected $fillable = [
        "id_vente",
        "id_produit",
        "quantite",
        "montant",
    ];
    protected $table = 'vente_produits';
    protected $primaryKey = 'id';
    public $timestamps = true;
    public function vente()
    {
        return $this->belongsTo(Vente::class, 'id_vente', 'id');
    }
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'id_produit', 'id');
    }
}
