<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $table = 'church_video';
    protected $primaryKey = 'video_id';

    static public function get_video($id) {
      return Church::where('video_id', $id)->first();
    }

    //Получает список категорий относящихся к видео
    static public function get_category($id) {
      return Church::where('video_id', $id)->get()''
    }

    static public function add_video($info) {
      return Church::insertGetId($info);
    }
}
