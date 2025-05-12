<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsChanges;

class Products extends Model
{
    use HasFactory, LogsChanges;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'sale_price',
        'cost_price',
        'description',
        'is_active',
    ];

    public function images()
    {
        return $this->hasMany(ProductImages::class, 'product_id');
    }
}
