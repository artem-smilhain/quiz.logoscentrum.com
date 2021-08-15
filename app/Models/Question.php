<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
    ];

    public function answer()
    {
        return $this->hasMany('App\Models\Answer', 'question_id');
    }

}
