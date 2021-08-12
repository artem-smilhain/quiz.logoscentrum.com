<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use Session;
use Illuminate\Pagination\Paginator;

class QuizController extends Controller
{

    public function index()
    {
        $answers = Answer::latest()->get();
        $questions = Question::latest()->paginate(1);
        return view('client.index', compact('answers', 'questions'));
    }

    public function session(Request $request){
        //если массив в сессии пустой - тест только открыт
        if (Session::get('value') != null){

            //узнаем, на какой странице человек
            $request_page = $request->input('page');
            //узнаем ответ
            $request_answer = $request->input('question_answer');
            //делаем массив и записываем данные
            $arr = array('id'=>$request_page, 'value'=>$request_answer);

            //берем старый массив с данными из сессии
            $main_arr = Session::get('value');

            //проверяем, была ли уже эта страница
            if ($this->find_id($main_arr, $request_page)){
                //если была - возвращаем новый массив
                $main_arr = $this->replace($main_arr, $request_page, $request_answer);
            }
            else{
                //если страницы такой не было - добавляем в конец новые результаты
                array_push($main_arr, $arr);
            }

        }
        else{
            //если тест только открыт - создаем пустой массив со всеми результатами
            $main_arr = array();
            //записываем наши данные с первого вопроса
            $arr = array('id'=>$request->input('page'), 'value'=>$request->input('question_answer'));
            //записываем первые данные
            array_push($main_arr, $arr);
        }

        //перезаписываем массив в сессии
        Session::put('value', $main_arr);

        //return $main_arr;

        //делаем редирект на следующий вопросик
        $next = $request->input('page') + 1;

        if ($next > 13){
            return $this->get_rating(Session::get('value'));
        }
        else{
            return redirect('/quiz?page='.$next);
        }
    }

    public function find_id($array, $id){
        $check = false;
        foreach ( $array as $element ) {
            if ( $element['id'] == $id ) {
                $check = true;
            }
        }
        return $check;
    }

    public function replace($array, $id, $new_value){
        $i = 0;
        foreach ( $array as $element ) {
            if ( $element['id'] == $id ) {
                $element['value'] = $new_value;
                $array[$i] = $element;
            }
            $i++;
        }
        return $array;
    }

    public function get_rating($array){
        $count = 0;
        foreach ( $array as $element ) {
            $count += $element['value'];
        }
        return $count;
    }
}
