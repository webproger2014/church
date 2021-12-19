<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoListTag extends Model
{
    use HasFactory;

    static public function get_tags_video($id) {
      return VideoListTag::where('video_id', $id)
      ->leftJoin('video_tags', 'video_list_tags.tag_id', 'video_tags.tag_id')
      ->get();
    }
}
