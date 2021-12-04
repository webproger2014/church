<?php

namespace App\Http\Controllers;

use App\Models\Church;
use Illuminate\Http\Request;

class ChurchController extends Controller
{

  //Воззвращает видео по фильтру
  public function get_videos() {

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

    return response()->json(['msg']);
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


}
