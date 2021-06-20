<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Reviews;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
  public function create(Request $request)
  {
    $rules = [
      'course_id' => 'required|integer',
      'user_id' => 'required|integer',
      'rating' => 'required|integer|min:1|max:5',
      'note' => 'string'
    ];

    $data = $request->all();

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'message' => $validator->errors()->toArray(),
      ], 400);
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

    $isExistReview = Reviews::where(['course_id' => $courseId])->where(['user_id' => $userId])->exists();

    if ($isExistReview) {
      return response()->json([
        'status' => 'error',
        'message' => 'User Reviews Already exists',
      ], 409);
    }

    $review = Reviews::create($data);
    return response()->json(['status' => 'success', 'data' => $review]);
  }

  public function update(Request $request, $id)
  {
    $rules = [
      'rating' => 'required|integer|min:1|max:5',
      'note' => 'string'
    ];

    $data = $request->except('user_id', 'course_id');

    $validator = Validator::make($data, $rules);

    if ($validator->fails()) {
      return response()->json([
        'status' => 'error',
        'message' => $validator->errors()->toArray(),
      ], 400);
    }

    $review = Reviews::find($id);
    if (!$review) {
      return response()->json([
        'status' => 'error',
        'message' => 'Reviews Not Found',
      ], 404);
    }

    $review->fill($data);

    $review->save();

    return response()->json(['status' => 'success', 'data' => $review]);
  }

  public function destroy($id)
  {
    $review = Reviews::find($id);
    if (!$review) {
      return response()->json([
        'status' => 'error',
        'message' => 'Reviews Not Found',
      ], 404);
    }

    $review->delete();
    return response()->json(['status' => 'success', 'message' => 'Success Deleted']);
  }
}
