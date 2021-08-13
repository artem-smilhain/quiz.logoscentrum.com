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
        $answers = $this->get_answers();
        $questions = $this->get_questions();

        return view('admin.answers.index', compact(
            'answers',
            'questions'
        ));
    }
    public function create()
    {
        $questions = $this->get_questions();
        return view('admin.answers.create', compact(
            'questions'
        ));
    }
    public function edit(Answer $answer) {
        $questions = $this->get_questions();
        return view('admin.answers.edit', compact(
            'answer',
            'questions'
        ));
    }
    public function store(Request $request)
    {
        //валидация
        $data = $this->validate_data($request);
        //обраюботка фото
        if ($request->hasFile('image')) {
            $data = $this->image_processing(null, $request, false, $data);
        }
        //сохраняем данные
        Answer::create($data);

        //переадресация
        $answers = $this->get_answers();
        return redirect()->route(
            'admin.answers.index',
            compact(
                'answers'
            )
        );
    }
    public function update(Request $request, Answer $answer) {
        //валидация
        $data = $this->validate_data($request);
        //обраюботка фото
        if ($request->hasFile('image')) {
            $data = $this->image_processing($answer, $request, true, $data);
        }
        //сохраняем ответ
        $answer->update($data);
        $answers = $this->get_answers();
        return redirect()->route(
            'admin.answers.index',
            compact(
                'answers'
            )
        );
    }
    public function destroy(Answer $answer) {
        //удалаяем фотку
        $filename = $answer->image;
        Storage::disk('local')->delete('public/images/'.$filename);
        //удалаяем сам вариант ответа
        $answer->delete();
        //
        return redirect(
            '/admin/answers/index'
        );
    }
    public function image_processing($answer, $request, $check, $data){
        $img = $request->file('image');
        $filename = time() . '.' . $img->getClientOriginalExtension();
        $image = Image::make($img)->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio(); // не теряем соотношение сторон
        });
        $image->stream();
        if ($check == true){
            Storage::disk('local')->delete('public/images/'.$answer->image);
        }
        Storage::disk('local')->put('public/images/'.$filename, $image, 'public');
        $data['image'] = $filename;
        //get back наши данные из функции
        return $data;
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
                'is_true' => 'required|boolean',
                'question_id' => 'required',
                'image' => 'image|mimes:png,jpg,jpeg,gif|dimensions:max_width:1000,max_height:1000',
            ]);
    }
}
