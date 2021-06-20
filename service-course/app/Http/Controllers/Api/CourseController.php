<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Chapters;
use App\Models\Course;
use App\Models\Mentor;
use App\Models\MyCourse;
use App\Models\Reviews;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CourseController extends Controller
{


  public function index(Request $request)
  {
    $course = Course::query();

    $q = $request->query('q');
    $status = $request->query('status');

    $course->when($q, function ($query) use ($q) {
      return $query->whereRaw("name LIKE '%" . strtolower($q) . "%'");
    });

    $course->when($status, function ($query) use ($status) {
      return $query->where('status', '=', $status);
    });

    return response()->json(['status' => 'success', 'data' => $course->paginate(5)]);
  }

  public function show($id)
  {
    $course = Course::with('chapters.lessons')->with('images')->find($id);

    if (!$course) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'course not found',
        ],
        404
      );
    }

    $review = Reviews::where(['course_id' => $id])->get()->toArray();

    if (count($review) > 0) {
      $userId = array_column($review, 'user_id');
      $users = getUserByid($userId);
      // echo "<pre>" . print_r($users, 1) . "</pre>";
      if ($users['status'] === 'error') {
        $review = [];
      } else {
        foreach ($review as $key => $rev) {
          $userIndex = array_search($rev['user_id'], array_column($users['data'], 'id'));
          $review[$key]['users'] = $users['data'][$userIndex];
        }
      }
    }


    $totalStident = MyCourse::where(['course_id' => $id])->count();
    $totalVideos = Chapters::where(['course_id' => $id])->withCount('lessons')->get()->toArray();
    $finalTotalVideo = array_sum(array_column($totalVideos, 'lessons_count'));
    // echo "<pre>" . print_r($finalTotalVideo, 1) . "</pre>";

    $course = [
      'reviews' => $review,
      'totalStident' => $totalStident,
      'course' => $course,
      'totalVideos' => $finalTotalVideo,
    ];

    return response()->json(['status' => 'success', 'data' => $course]);
  }


  public function create(Request $request)

  {
    $rules = [
      'name' => 'required|string',
      'certificate' => 'required|boolean',
      'thumbnail' => 'required|url',
      'type' => 'required|in:free,premium',
      'status' => 'required|in:draf,publish',
      'price' => 'required|integer',
      'level' => 'required|in:all-level,beginner,intermediet,advance',
      'mentor_id' => 'required|integer',
      'description' => 'string'
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


    $mentor_id = $request->mentor_id;
    $mentor = Mentor::find($mentor_id);

    if (!$mentor) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'Mentor not found',
        ],
        404
      );
    }

    $courses = Course::create($data);

    return response()->json(
      [
        'status' => 'success',
        'data' => $courses
      ],
      200
    );
  }


  public function update(Request $request, $id)
  {
    $rules = [
      'name' => 'string',
      'certificate' => 'boolean',
      'thumbnail' => 'url',
      'type' => 'in:free,premium',
      'status' => 'in:draf,publish',
      'price' => 'integer',
      'level' => 'in:all-level,beginner,intermediet,advance',
      'mentor_id' => 'integer',
      'description' => 'string'
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

    $courses  = Course::find($id);

    if (!$courses) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'Course Not Found',
        ],
        404
      );
    }

    $mentor_id = $request->mentor_id;
    $mentor = Mentor::find($mentor_id);

    if (!$mentor) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'Course not found',
        ],
        404
      );
    }

    $courses->fill($data);
    $courses->save();


    return response()->json(
      [
        'status' => 'success',
        'data' => $courses
      ],
      200
    );
  }


  public function del($id)

  {
    $courses = Course::find($id);
    if (!$courses) {
      return response()->json(
        [
          'status' => 'error',
          'message' => 'Course not found',
        ],
        404
      );
    }


    $courses->delete();
    return response()->json(
      [
        'status' => 'success',
        'message' => 'Data Berhasil Di Hapus'
      ],
      200
    );
  }
}
