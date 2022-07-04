<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Books;
use Illuminate\Support\Facades\Validator;



class BookController extends Controller
{
    public function index(Request $request) 
    {

        $data = Books::with('categories')->orderBy("created_at","DESC")->paginate(10);

        return response()->json([
            "status" => true,
            "data" => $data
        ]);
       
    }

    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),[
                "judul" => "required|string|max:30",
                "harga" => "required|integer|min:10000",
                "category_id" => "required"
            ],[
                "judul.required" => "Judul Harus Dibuat!",
                "harga.required" => "Harga tidak sesuai"
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors());
            }
            
            Books::create([
                "judul" => $request->judul,
                "harga" => $request->harga,
                "category_id" => $request->category_id
            ]);

            return response()->json([
                "status" => true,
                "message" => "Buku dengan Judul '$request->judul' berhasil dibuat",
            
            ]);
        } catch (\Exception $e) {
            return response()->json($e -> getMessage());
        } 
    }


    public function edit($id)
    {
        $getOneById = Books:: find($id);

        return response()->json(["status" => true, "data" => $getOneById]);

    }
    public function update(Request $request, $id)
    {
        $book = Books::findOrFail($id);

        try {
            $validate = Validator::make($request->all(),[
                "judul" => "required|string|max:30",
                "harga" => "required|integer|min:10000"
            ]);

            if($validate->fails()) {
                return response()->json($validate->errors(),442);
            }

            $book->update([
                "judul" => $request->judul,
                "harga" => $request->harga
            ]);

            return response()->json([
                "status" => true,
                "message" => "data $book->judul, berhasil diubah."
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }


    public function destroy($id)
    {
        $getOneById = Books:: find($id);
        $getOneById -> delete();

        return response()->json([
            "status" => true, 
            "message" => "data berhasil dihapus!"
        ]);
        

    }
}
