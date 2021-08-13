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
        $questions = $this->get_questions();
        return view('admin.questions.index', compact('questions'));
    }
    public function create()
    {
        return view('admin.questions.create');
    }
    public function store(Request $request)
    {
        $data = $this->validate_data($request);
        Question::create($data);
        $questions = $this->get_questions();
        return redirect()->route('admin.questions.index', compact('questions'));
    }
    public function edit(Question $question) {
        return view('admin.questions.edit', compact('question'));
    }
    public function update(Request $request, Question $question) {
        $data = $this->validate_data($request);
        $question->update($data);
        $questions = $this->get_questions();
        return redirect()->route('admin.questions.index', compact('questions'));
    }
    public function destroy(Question $question) {
        $question->delete();
        return redirect('/admin/questions/index');
    }
    public function get_questions(){
        return Question::latest()->get();
    }
    public function get_answers(){
        return Answer::latest()->get();
    }

    public function validate_data($request){
        return $this->validate($request,
            [
                'content' => 'required|string',
            ]);
    }
}




