<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index(Request $request) 
    {

        $data = Category::orderBy("created_at","DESC")->paginate(10);

        return response()->json([
            "status" => true,
            "data" => $data
        ]);
       
    }

    public function store(Request $request)
    {
        try {
            $validate = validator::make($request->all(),[
                "name" => "required|string|max:30|unique:categories"
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors());
            }
            
            Category::create([
                "name" => $request->name
            ]);

            return response()->json([
                "status" => true,
                "message" => "Kategori '$request->name' berhasil dibuat"
            ]);
        } catch (\Exception $e) {
            return response()->json($e -> getMessage());
        } 
    }


    public function edit($id)
    {
        $getOneById = Category:: find($id);

        return response()->json(["status" => true, "data" => $getOneById]);

    }
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        try {
            $validate = Validator::make($request->all(),[
                "judul" => "required|string|max:30|unique:categories"
            ]);

            if($validate->fails()) {
                return response()->json($validate->errors(),442);
            }

            $category->update([
                "name" => $request->name
            ]);

            return response()->json([
                "status" => true,
                "message" => "data $category->name, berhasil diubah."
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


    public function destroy($id)
    {
        $getOneById = Category:: find($id);
        $getOneById -> delete();

        return response()->json([
            "status" => true, 
            "message" => "data berhasil dihapus!"
        ]);
        

    }
}
