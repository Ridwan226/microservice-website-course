<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapters;
use App\Models\Lessons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{


  public function index(Request $request)
  {
    $leassons = Lessons::query();

    $chapterId = $request->query('chapter_id');

    $leassons->when('chapter_id', function ($query) use ($chapterId) {
      return $query->where('chapter_id', '=', $chapterId);
    });

    return response()->json(
      [
        'status' => 'success',
        'data' => $leassons->get()
      ],
      200
    );
  }

  public function detail($id)
  {
    $leasson = Lessons::find($id);

    if (!$leasson) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'leasson not found',
        ],
        404
      );
    }

    return response()->json(
      [
        'status' => 'success',
        'data' => $leasson
      ],
      200
    );
  }

  public function create(Request $request)
  {
    $rules = [
      'name' => 'required|string',
      'video' => 'required|string',
      'chapter_id' => 'required|integer'
    ];


    $data = $request->all();

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 'error',
          'message' => $validator->errors()->toArray(),
        ],
        400
      );
    }


    $chapterId = $request->input('chapter_id');
    $chapter = Chapters::find($chapterId);

    if (!$chapter) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'chapter not found',
        ],
        404
      );
    }

    $lasson = Lessons::create($data);

    return response()->json(
      [
        'status' => 'success',
        'data' => $lasson
      ],
      200
    );
  }

  public function update(Request $request, $id)
  {
    $rules = [
      'name' => 'string',
      'video' => 'string',
      'chapter_id' => 'integer'
    ];


    $data = $request->all();

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
      return response()->json(
        [
          'status' => 'error',
          'message' => $validator->errors()->toArray(),
        ],
        400
      );
    }


    $leasson = Lessons::find($id);

    if (!$leasson) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'leasson not found',
        ],
        404
      );
    }


    $chapterId = $request->input('chapter_id');

    if ($chapterId) {
      $chapter = Chapters::find($chapterId);

      if (!$chapter) {
        return response()->json(
          [
            'status' => 'error',
            'message' => 'chapter not found',
          ],
          404
        );
      }
    }


    $leasson->fill($data);
    $leasson->save();

    return response()->json(
      [
        'status' => 'success',
        'data' => $leasson
      ],
      200
    );
  }


  public function del($id)
  {
    $leasson = Lessons::find($id);

    if (!$leasson) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'leasson not found',
        ],
        404
      );
    }

    $leasson->delete();
    return response()->json(
      [
        'status' => 'success',
        'message' => 'Data leasson Berhasil Di Hapus'
      ],
      200
    );
  }
}
