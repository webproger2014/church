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

  public function add_video(Request $request) {
    $data_validated = $request->validate([
      'name' => 'bail|required|string',
      'video_id' => 'bail|required|string',
      'description' => 'nullable|string',
      'church_id' => 'bail|required|integer',
      'date_event' => 'bail|required|string',
      'categories' => 'array'
    ]);

    $id_video = Church::add_video([
      'user_id' => $request->user()->id,
      'church_id' => $data_validated['church_id'],
      'video_name' => $data_validated['name'],
      'video_desc' => $data_validated['description'],
      'youtube_id' => $data_validated['video_id'],
      'date_event' => $data_validated['date_event'],
    ]);

    listCategories::set_category_video($id_video, $data_validated['categories']);
    return response()->json(['id' => $id_video ]);
  }

  public function edit_video(Request $request) {
    $video_id = $request->validate([
      'video_id' => 'bail|integer'
    ]);

    $info_validated = $request->validate([
      'date_event' => 'bail|required|string',
      'video_desc' => 'nullable|string',
      'video_name' => 'bail|string',
      'youtube_id' => 'bail|string'
    ]);

    $categories = $request->validate([
      'categories' => 'bail|array'
    ]);

    Church::update_video($video_id['video_id'], $info_validated);
    listCategories::del_categories_video($video_id['video_id']);
    listCategories::set_category_video($video_id['video_id'], $categories['categories']);
    return response()->json();
  }

   public function active_video(Request $request) {
    $data = $request->validate([
      'video_id' => 'bail|integer',
      'status' => 'bail|integer'
    ]);
    
    Church::set_status_video($data['video_id'], $data['status']);
    return response()->json();
  }
}
