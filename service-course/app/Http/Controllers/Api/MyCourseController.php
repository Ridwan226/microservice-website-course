<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\MyCourse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class MyCourseController extends Controller
{

  public function index(Request $request)
  {
    $myCourses = MyCourse::query()->with('course');

    $userId = $request->query('user_id');

    $myCourses->when($userId, function ($query) use ($userId) {
      return $query->where(['user_id' => $userId]);
    });

    return response()->json(['status' => 'success', 'data' => $myCourses->get()]);
  }

  public function create(Request $request)
  {
    $rules = [
      'course_id' => 'integer|required',
      'user_id' => 'required|integer'
    ];

    $data = $request->all();

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'message' => $validator->errors()->toArray(),
      ]);
    }

    $courseId = $request->input('course_id');

    $course = Course::find($courseId);

    if (!$course) {
      return response()->json([
        'status' => 'error',
        'message' => 'Course not found',
      ], 404);
    }

    $userId = $request->input('user_id');
    $user = getUser($userId);

    if ($user['status'] == 'error') {
      return response()->json([
        'status' => $user['status'],
        'message' => $user['message'],
      ], $user['http_code']);
    }

    $isExistMycourse = MyCourse::where(['course_id' => $courseId])->where(['user_id' => $userId])->exists();

    if ($isExistMycourse) {
      return response()->json([
        'status' => 'error',
        'message' => 'User MyCourse Already exists',
      ], 409);
    }


    $myCourse = MyCourse::create($data);

    return response()->json(['status' => 'success', 'data' => $myCourse]);
  }
}
