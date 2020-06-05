<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Tag;
use App\Http\Requests\TagRequest;

class TagsController extends Controller
{
    private $tag;

    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }
    
    public function index()
    {
        $tag = $this->tag->paginate('10');

        return response()->json($tag, 200);
    }

    public function store(TagRequest $request)
    {
        $data = $request->all();

        try{
            $tag = $this->tag->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Tag cadastrada com sucesso!'
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
            $tag = $this->tag->findOrFail($id);

            return response()->json([
                'msg' => 'Tag encontrada!',
                'data' => $tag
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try{
            $tag = $this->tag->findOrFail($id);
            $tag->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Tag atualizada com sucesso!'
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
            $tag = $this->tag->findOrFail($id);
            $tag->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Tag removida com sucesso!'
                ]
            ], 200);
        }catch(\Exception $e){
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(), 401);
        }
    }
}
