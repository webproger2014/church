<?php

namespace App\Http\Controllers;

use App\Models\Church;
use App\Models\listCategories;
use App\Models\VideoCategory;
use App\Models\VideoListTag;
use Illuminate\Http\Request;


class ChurchController extends Controller
{

  //Воззвращает видео по фильтру
  public function get_videos(Request $request) {
    $data_validated = $request->validate([
      'filter' => 'array',
      'filter.user_id' => 'integer',
      'filter.church_id' => 'integer',
      'filter.category' => 'array',
      'filter.tags' => 'array',
      'filter.date' => 'array'
    ]);

    $filter = [];
    if (isset($data_validated['filter'])) {
      $filter = $data_validated['filter'];
    }

    $video = Church::get_videos($filter);

    return response()->json($video);
  }

  public function get_video(Request $request) {
    $data_validated = $request->validate([
      'id' => 'bail|required|integer'
    ]);

    return Church::get_video($data_validated['id']);
  }

  public function get_list_categories(Request $request) {
    $data_validated = $request->validate([
      'id' => 'bail|required|integer'
    ]);

    $categories = listCategories::get_category($data_validated['id']);

    return response()->json($categories);
  }

  //Добавление видео в таблицу
  public function add_video(Request $request) {

    $data_validated = $request->validate([
      'youtube_id' => 'bail|required|string',
      'video_name' => 'bail|required|string',
      'video_desc' => 'string',
      'category' => 'integer'
    ]);

    $data_validated['church_id'] = 1;
    $data_validated['user_id']   = 1;


    $video = Church::add_video($data_validated);

    return response()->json(['id' => $video]);
  }

  public function get_tags_video(Request $request) {
    $data_validated = $request->validate([
      'id' => 'bail|required|integer'
    ]);

    $tags = VideoListTag::get_tags_video($data_validated['id']);

    return response()->json($tags);
  }

  public function get_cats() {
    return response()->json(VideoCategory::get_list_categories());
  }
}
