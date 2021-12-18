<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoCategory extends Model
{
    use HasFactory;

    protected $table = 'video_category';

    static public function get_list_categories() {
      return VideoCategory::orderBy('category_name', 'asc')->get();
    }
}
