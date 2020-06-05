<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\ProductImage;
use App\Http\Requests\ProductImagesRequest;
use Illuminate\Support\Facades\Storage;

class ProductImagesController extends Controller
{
    private $productImage; 

    public function __construct(ProductImage $productImage)
    {   
        $this->productImage = $productImage;
    }

    public function setThumb($imageId, $productId)
    {
        try{
            $image = $this->productImage->where('product_id', $productId)->where('is_thumb', 1);

            if($image->count()) $image->first()->update(['is_thumb' => false]);

            $image = $this->productImage->find($imageId);
            $image->update(['is_thumb' => true]);

            return response()->json([
                'data' => [
                    'msg' => 'Thumb atualizada com sucesso!'
                ]
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function remove($imageId)
    {
        try{
            $image = $this->productImage->find($imageId);

            if($image){
                Storage::disk('public')->delete($image->image);
                $image->delete;
            }

            return response()->json([
                'data' => [
                    'msg' => 'Imagem removida com sucesso!'
                ]
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
