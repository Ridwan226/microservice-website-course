<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lessons extends Model
{
    use HasFactory;
    
    protected $table = 'sessons';
    
    protected $fillable = ['name', 'video', 'chapter_id'];
    
}
