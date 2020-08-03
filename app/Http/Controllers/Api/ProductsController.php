<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductsController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    
    public function index()
    {
        $product = $this->product->with('tags')->with('images')->paginate('10');

        return response()->json($product, 200);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $images = $request->file('images');

        try{
            $product = $this->product->create($data);

            if(isset($data['tags']) && count($data['tags'])){
                $product->tags()->sync($data['tags']);
            }

            if($images){
                $imagesUploaded = [];

                foreach($images as $key => $image){
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['image_name' => $path, 'is_thumb' => $key == 0 ? true : false ];
                }

                $product->images()->createMany($imagesUploaded);
            }

            //dd($product);
            
            return response()->json([
                'data' => [
                    'msg' => 'Produto cadastrado com sucesso!',
                    'id' => $product['id']
                ]
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function show($id)
    {
        try{
            $product = $this->product->with('tags')->with('images')->findOrFail($id);

            return response()->json([
                'msg' => 'Produto encontrado!',
                'data' => $product
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();
        $images = $request->file('images');

        try{
            $product = $this->product->findOrFail($id);
            $product->update($data);

            if(isset($data['tags']) && count($data['tags'])){
                $product->tags()->sync($data['tags']);
            }

            if($images){
                $imagesUploaded = [];

                foreach($images as $image){
                    $path = $image->store('images', 'public');
                    $imagesUploaded[] = ['image_name' => $path, 'is_thumb' => false];
                }

                $product->images()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Produto atualizado com sucesso!'
                ]
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function destroy($id)
    {
        try{
            $product = $this->product->findOrFail($id);
            $product->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Produto removido com sucesso!'
                ]
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
