<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'designation',
        'prix',
        'qte',
        'lienImage',
        'status',
        'id_categorie'];

    public function categorie():BelongsTo {
        return $this->BelongsTo(Categorie::class);

    }
}
