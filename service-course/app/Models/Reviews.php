<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
    use HasFactory;
    
    protected $table = 'reviews';
    
    protected $fillable = ['user_id','course_id', 'rating', 'note'];
    
    public function courses(){
      return $this->belongsTo('App\Models\Courses');
    }
    
}
