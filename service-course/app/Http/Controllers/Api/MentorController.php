<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MentorController extends Controller
{


  public function index()
  {
    $mentors = Mentor::all();

    return response()->json(['status' => 'success', 'data' => $mentors], 200);
  }

  public function show($id)
  {
    $mentor = Mentor::find($id);

    if (!$mentor) {
      return response()->json(['status' => 'error', 'message' => 'Mentor Not Found'], 404);
    };
    return response()->json(['status' => 'success', 'data' => $mentor], 200);
  }



  public function create(Request $request)
  {
    $rules = [
      'name' => 'required|string',
      'profile' =>  'required|url',
      'email' =>  'required|email',
      'profession' =>  'required|string'
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
    };


    $mentor = Mentor::create($data);

    return response()->json(['status' => 'success', 'data' => $mentor], 200);
  }


  public function update(Request $request, $id)
  {
    $rules = [
      'name' => 'string',
      'profile' =>  'url',
      'email' =>  'email',
      'profession' =>  'string'
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
    };

    $mentor = Mentor::find($id);

    if (!$mentor) {
      return response()->json(['status' => 'error', 'message' => 'Mentor Not Found'], 404);
    };

    $mentor->fill($data);

    $mentor->save();

    return response()->json(['status' => 'success', 'data' => $mentor], 200);
  }
  
  public function del($id)
  {
     $mentor = Mentor::find($id);

    if (!$mentor) {
      return response()->json(['status' => 'error', 'message' => 'Mentor Not Found'], 404);
    };
    
    $mentor->delete();
    return response()->json(['status' => 'success', 'message' => 'Data Berhasil di Hapus'], 200);
    
  }
  
}
