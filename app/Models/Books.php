<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $fillable = ["judul","harga","category_id"];

    public function categories() 
    {
      return $this->belongsTo(Category::class,'category_id');
    }
}
