<?php

namespace App\Http\Controllers\Answer;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index()
    {
        $answers = Answer::latest()->paginate(100);
        $questions = Question::latest()->get();
        return view('admin.answers.index', compact('answers', 'questions'));
    }
    //
    public function create()
    {
        $questions = Question::latest()->get();
        return view('admin.answers.create', compact('questions'));
    }
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'content' => 'required|string',
            'is_true' => 'required|boolean',
            'question_id' => 'required',
        ]);
        $answers = Answer::create($data);
        $answers = Answer::latest()->paginate(100);
        return redirect()->route('admin.answers.index', compact('answers'));
    }
    public function edit(Answer $answer) {
        $questions = Question::latest()->get();
        return view('admin.answers.edit', compact('answer', 'questions'));
    }
    public function update(Request $request, Answer $answer) {
        $data = $this->validate($request,
            [
                'content' => 'required|string',
                'is_true' => 'required|boolean',
                'question_id' => 'required',
            ]);
        $answer->update($data);
        $answers = Answer::latest()->paginate(100);
        return redirect()->route('admin.answers.index', compact('answers'));
    }
    public function destroy(Answer $answer) {
        $answer->delete();
        return redirect('/admin/answers/index');
    }
}
