<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapters;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
  public function index(Request $request)
  {
    $chapter = Chapters::query();

    $courseId = $request->query('course_id');

    $chapter->when($courseId, function ($query) use ($courseId) {
      return $query->where('course_id', '=', $courseId);
    });

    return response()->json(
      [
        'status' => 'success',
        'data' => $chapter->get(),
      ],
      200
    );
  }
  
  
  public function detail($id)
  {
    $chapter = Chapters::find($id);
    
    if(!$chapter)
    {
       return response()->json(
        [
          'status' => 'error',
          'message' => 'Chapters Tidak Tersedia',
        ],
        404
      );
    }
    
    return response()->json(
      [
        'status' => 'success',
        'data' => $chapter
      ],
      200
    );
  }
  
  public function del($id)
  {
     $chapter = Chapters::find($id);
    
    if(!$chapter)
    {
       return response()->json(
        [
          'status' => 'error',
          'message' => 'Chapters Tidak Tersedia',
        ],
        404
      );
    }
    
    $chapter->delete();
    
     return response()->json(
      [
        'status' => 'success',
        'message' => 'Data Telah di Hapus'
      ],
      200
    );
    
  }

  public function create(Request $request)
  {

    $rules = [
      'name' => 'required|string',
      'course_id' => 'required|integer',
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


    $courseId = $request->input('course_id');
    $course = Course::find($courseId);

    if (!$course) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'Course Tidak Tersedia',
        ],
        404
      );
    }


    $chapter = Chapters::create($data);

    return response()->json(
      [
        'status' => 'success',
        'data' => $chapter
      ],
      200
    );
  }


  public function update(Request $request, $id)
  {
    $rules = [
      'name' => 'string',
      'course_id' => 'integer',
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

    $chapter = Chapters::find($id);

    if (!$chapter) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'Chapters Tidak Tersedia',
        ],
        404
      );
    }

    $courseId = $request->input('course_id');


    if ($courseId) {
      $course = Course::find($courseId);

      if (!$course) {
        return response()->json(
          [
            'status' => 'error',
            'message' => 'Course Tidak Tersedia',
          ],
          404
        );
      }
    }

    $chapter->fill($data);
    $chapter->save();

    return response()->json(
      [
        'status' => 'success',
        'data' => $chapter
      ],
      200
    );
  }
}
