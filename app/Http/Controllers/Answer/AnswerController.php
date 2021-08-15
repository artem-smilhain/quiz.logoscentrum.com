<?php

namespace App\Http\Controllers\Answer;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class AnswerController extends Controller
{
    public function index()
    {
        return view('admin.answers.index', [
            'answers' => Answer::latest()->get(),
            'questions' => Question::latest()->get()
        ]);
    }
    public function create()
    {
        return view('admin.answers.create', [
            'questions' => Question::latest()->get()
        ]);
    }
    public function edit(Answer $answer) {
        return view('admin.answers.edit', compact('answer'), [
            'questions' => Question::latest()->get()
        ]);
    }
    //
    public function store(Request $request)
    {
        //обраюботка фото
        $data = Controller::image_processing(null, $request, false, $this->validate_data($request));
        //сохраняем данные
        Answer::create($data);
        //переадресация
        return redirect()->route('admin.answers.index',
            [
                'answers' => Answer::latest()->get()
            ]
        );
    }
    public function update(Request $request, Answer $answer) {
        //обраюботка фото
        $data = Controller::image_processing($answer, $request, true, $this->validate_data($request));
        //сохраняем ответ
        $answer->update($data);
        return redirect()->route('admin.answers.index',
            [
                'answers' => Answer::latest()->get()
            ]
        );
    }
    public function destroy(Answer $answer) {
        //удалаяем фотку
        Storage::disk('local')->delete('public/images/'.$answer->image);
        //удалаяем сам вариант ответа
        $answer->delete();
        return redirect(
            '/admin/answers/index'
        );
    }
    public function validate_data($request){
        return $this->validate($request,
            [
                'content' => 'required|string',
                'is_true' => 'required|boolean',
                'question_id' => 'required',
                'image' => 'image|mimes:png,jpg,jpeg,gif|dimensions:max_width:1000,max_height:1000',
            ]);
    }
}
