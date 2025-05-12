<?php

namespace App\Services\Products;

use App\Models\Products;
use App\Models\ProductImages;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Facades\Purifier;

class ProductService
{

    public static function handleCreateImages($images, $productId)
    {
        foreach ($images as $image) {
            $path = $image->store('produtos', 'public');
            $url = asset(Storage::url($path));

            ProductImages::create([
                'product_id' => $productId,
                'image_path' => $path,
                'url' => $url,
            ]);
        }
    }
}
