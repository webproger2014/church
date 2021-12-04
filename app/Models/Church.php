<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $table = 'church_video';
    protected $primaryKey = 'video_id';

    static public function get_videos($filter) {
      $where = [];

      if (isset($filter['church_id'])) {
        $where[] = ['church_id', '=', $filter['church_id']];
      }

      $query = Church::where($where);

      return $query->get();
    }

    static public function get_video($id) {
      return Church::where('video_id', $id)->first();
    }

    static public function add_video($info) {
      return Church::insertGetId($info);
    }
}
