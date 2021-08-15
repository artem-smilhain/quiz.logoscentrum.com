<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'is_true',
        'question_id',
        'image',
    ];


    public function question()
    {
        return $this->hasOne('App\Models\Question');
    }
}
