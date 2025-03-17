<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Definindo os campos que podem ser preenchidos
    protected $fillable = [
        'title',
        'sale_price',
        'cost',
        'description',
        'images'
    ];

    // Definindo os campos que precisam ser convertidos para tipos específicos
    protected $casts = [
        'images' => 'array',
        'sale_price' => 'float',
        'cost' => 'float',
    ];

    public $timestamps = true;

    /**
     * A mutator para o campo 'images', para garantir que as imagens sejam salvas corretamente.
     *
     * @param  mixed  $value
     * @return void
     */
    public function setImagesAttribute($value)
    {
        // Se for um array de imagens, converta para JSON
        if (is_array($value)) {
            $this->attributes['images'] = json_encode($value);
        }
    }

    /**
     * A accessor para o campo 'images', para retornar como um array.
     *
     * @param  mixed  $value
     * @return array
     */
    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }
}
