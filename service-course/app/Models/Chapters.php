<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapters extends Model
{
  use HasFactory;

  protected $table = 'chapters';

  protected $fillable = ['name', 'course_id'];

  protected $casts = [
    'created_at' => 'datetime:Y-m-d H:m:s',
    'updated_at' => 'datetime:Y-m-d H:m:s',
  ];

  public function lessons()
  {
    return $this->hasMany('App\Lessons')->orderBy('id', 'asc');
  }
}