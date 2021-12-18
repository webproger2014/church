<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listCategories extends Model
{
    use HasFactory;

    protected $table = 'video_list_category';

    //Получает список категорий относящихся к видео
    static public function get_category($id) {
      return listCategories::where('video_id', $id)
      ->join('video_category', 'video_list_category.category_id', '=', 'video_category.id_category')
      ->get();
    }
}
