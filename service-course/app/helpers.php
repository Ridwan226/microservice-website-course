<?php

use Illuminate\Support\Facades\Http;

function getUser($user_id)
{
  $url = env('SERVICE_USER_URL') . '/users/detail/' . $user_id;

  try {
    //code

    $response = Http::timeout(10)->get($url);

    $data = $response->json();

    $data['http_code'] = $response->getStatusCode();

    return $data;
  } catch (\Throwable $err) {

    return [
      'status' => 'error',
      'http_code' => 500,
      'message' => 'Service User Unavailable',
    ];
  };
}


function getUserByid($userIds = [])
{
  $url = env('SERVICE_USER_URL') . '/users/list/';


  try {
    if (count($userIds) === 0) {
      return [
        'status' => 'success',
        'http_code' => 200,
        'data' => []
      ];
    }

    $response = Http::timeout(10)->get($url, ['user_ids[]' => $userIds]);
    $data = $response->json();

    $data['http_code'] = $response->getStatusCode();

    return $data;
  } catch (Exception $e) {
    return [
      'status' => 'error',
      'http_code' => 500,
      'message' => 'Service User Unavailable',
    ];
  }
}
