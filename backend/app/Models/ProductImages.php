<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsChanges;

class ProductImages extends Model
{
    use HasFactory, LogsChanges;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'image_path',
        'url',
    ];

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
