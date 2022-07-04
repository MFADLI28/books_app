<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TestController extends Controller
{
    public function ping(Request $request)
    {
        $data = Books::with('categories')->orderBy("created_at","DESC")->paginate(10);
        $name = null;
        $title = null;
        foreach($data as $row) {
            $title = $row->judul;
            $name = $row->categories->name;
        }

       


      return response()->json([
        "data" => "judul buku : $title,nama kategori:$name"
      ]);
    }

}
