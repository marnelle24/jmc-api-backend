<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'itemUnit',
        'created_at',
        'updated_at'
    ];

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() 
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }
}
