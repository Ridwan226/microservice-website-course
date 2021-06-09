<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\ImageCourse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ImageController extends Controller
{
  public function create(Request $request)
  {
    $rules = [
      'image' => 'required|url',
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

    $courses = Course::find($courseId);

    if (!$courses) {
      return response()->json(['status' => 'error', 'message' => 'Course not found'], 404);
    }

    $imageCourse = ImageCourse::create($data);


    return response()->json(
      [
        'status' => 'success',
        'data' => $imageCourse
      ],
      200
    );
  }

  public function destroy($id)
  {
    $imageCourse = ImageCourse::find($id);
    if (!$imageCourse) {
      return response()->json(['status' => 'error', 'message' => 'Image Course not found'], 404);
    }

    $imageCourse->delete();
    return response()->json(
      [
        'status' => 'success',
        'data' => 'Image Course Delete Success'
      ],
      200
    );
  }
}
