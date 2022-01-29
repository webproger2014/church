<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Church extends Model
{
    use HasFactory;

    protected $table = 'church_video';
    protected $primaryKey = 'video_id';
    protected $casts = [
      'date_event' => 'date:Y-m-d'
    ];

    static public function get_videos($filter) {
      $db = Church::where([]);

      //Поиск по церкви
      if (isset($filter['church_id'])) {
        $db->where('church_id', $filter['church_id']);
      }

      //> Активность
      $status_video = 1;
      if (isset($filter['status'])) {
        $status_video = $filter['status'];
      }

      $db->where('status', $status_video);
      //< Активность

      // Поиск по категориям
      if (isset($filter['category']) && !empty($filter['category'])) {
        $categories_id = $filter['category'];
        $db->where('video_id', '=', function ($query) use ($categories_id) {
          $query->select('video_id')
          ->from('video_list_category')
          ->whereColumn('video_list_category.video_id', 'church_video.video_id')
          ->whereIn('video_list_category.category_id', $categories_id)
          ->limit(1);
        });
      }

      // Поиск по тэгами
      if (isset($filter['tags']) && !empty($filter['tags'])) {
        $tags = $filter['tags'];
        $db->where('video_id', '=', function ($query) use ($tags){
          $query->select('video_id')
          ->from('video_list_tags')
          ->whereColumn('video_list_tags.video_id', 'church_video.video_id')
          ->whereIn('video_list_tags.tag_id', $tags)
          ->limit(1);
        });
      }

      //Поиск по дате
      if (isset($filter['date']) && !empty($filter['date'])) {
        $db->whereBetween('date_event', $filter['date']);
      }

      $db->leftJoin('church_list', 'church_video.church_id', 'church_list.church_id');
      $db->leftJoin('city_list', 'church_list.city_id', 'city_list.id_city');
      $db->select('church_video.*', 'church_list.church_name', 'city_list.city');
      $db->orderBy('video_id', 'desc');

      $page = 1;
      if (isset($filter['page'])) {
        $page = $filter['page'];
      }

      $paginate = $db->paginate(10, ['*'], 'page', $page);

      return [
        'data' => $paginate->items(),
        'count' => $paginate->count(),
        'last_page' => $paginate->lastPage(),
        'current_page' => $paginate->currentPage(),
        'per_page' => $paginate->perPage(),
        'total' => $paginate->total()
      ];
    }

    static public function get_video($id) {
      return Church::where('video_id', $id)->first();
    }

    static public function add_video($info) {
      return Church::insertGetId($info);
    }

    static public function update_video($id, $info) {
      Church::where('video_id', $id)->update($info);
    }

    static public function set_status_video($id, $status) {
      Church::where('video_id', $id)->update(['status' => $status]);
    }
}
