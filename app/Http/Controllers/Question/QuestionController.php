<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Questions;
use App\Models\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::latest()->paginate(100);
        return view('admin.questions.index', compact('questions'));
    }
    public function create()
    {
        return view('admin.questions.create');
    }
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'content' => 'required|string',
        ]);
        $questions = Question::create($data);
        $questions = Question::latest()->paginate(100);
        return redirect()->route('admin.questions.index', compact('questions'));
    }

    //

    public function edit(Question $question) {
        return view('admin.questions.edit', compact('question'));
    }
    public function update(Request $request, Question $question) {
        $data = $this->validate($request,
            [
                'content' => 'required|string',
            ]);
        $question->update($data);
        $question = Question::latest()->paginate(100);
        return redirect()->route('admin.questions.index', compact('question'));
    }
    public function destroy(Question $question) {
        $question->delete();
        return redirect('/admin/questions/index');
    }

}
