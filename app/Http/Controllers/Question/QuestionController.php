<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Questions;
use App\Models\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return view('admin.questions.index', [
            'questions' => Question::latest()->get()
        ]);
    }
    public function create()
    {
        return view('admin.questions.create');
    }
    public function store(Request $request)
    {
        Question::create($this->validate_data($request));
        return redirect()->route('admin.questions.index', [
            'questions' => Question::latest()->get()
        ]);
    }
    public function edit(Question $question) {
        return view('admin.questions.edit', compact(
            'question'
        ));
    }
    public function update(Request $request, Question $question) {
        $question->update($this->validate_data($request));
        return redirect()->route('admin.questions.index', [
            'questions' => Question::latest()->get()
        ]);
    }
    public function destroy(Question $question) {
        $question->delete();
        return redirect('/admin/questions/index');
    }
    public function validate_data($request){
        return $this->validate($request,
            [
                'content' => 'required|string',
            ]);
    }
}




