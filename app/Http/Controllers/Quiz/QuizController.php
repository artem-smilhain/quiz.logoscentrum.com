<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Pagination\Paginator;

class QuizController extends Controller
{

    public function index()
    {
        $answers = Answer::latest()->get();
        $questions = Question::orderBy('id', 'asc')->paginate(1);
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

        //если номер следующей страницы больше, чем вопросов - переадресация на форму
        if ($next > Question::latest()->get()->count()){
            $rating = $this->get_rating(Session::get('value'));
            return view('client.client_data', compact('rating'));
        }
        else{
            return redirect('/quiz?page='.$next);
        }
    }

    //проверяем, не вносит ли клиент новый ответ в уже выполненный вопрос
    public function find_id($array, $id){
        $check = false;
        foreach ( $array as $element ) {
            if ( $element['id'] == $id ) {
                $check = true;
            }
        }
        return $check;
    }

    //меняем страный ответ на новый
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

    //считаем баллы за тест
    public function get_rating($array){
        $count = 0;
        foreach ( $array as $element ) {
            $count += $element['value'];
        }
        return $count;
    }

    //отправка данных формы клиента после теста
    public function send_form(Request $request){
        //новый клиент + его данные
        $contact = new Client();
        $contact->name = $request->input('name');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        $contact->consultation = $request->input('consultation');
        $contact->rating = $request->input('rating');
        $contact->questions_count = Question::latest()->get()->count();
        //
        $data = [
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'consultation' => $contact->consultation,
            'rating' => $contact->rating,
            'questions_count' => $contact->questions_count,
        ];
        //отправка письма
        $this->mail_function($data, $contact);
        //обнуляем нашу сессию
        Session::put('value', array());
        //редирект на страницу благодарности
        return redirect()->route('thank_you');
    }

    //отправка письма
    public function mail_function($data, $contact){
        //отправка письма клиенту
        Mail::send('client.email.email_template', $data, function($message) use ($contact) {
            $message->to($contact->email)->sender(env('MAIL_USERNAME'), $name = env('APP_NAME'))->subject('Результат теста | Cловацкий язык');
        });
        //отправка менеджеру
        Mail::send('admin.email.email_template', $data, function($message) use ($contact) {
            //почта trello, где будут данные тех, кто прошел тест
            $emails = ['artemsmilhain+u2rasdbfprllon0fmkjo@boards.trello.com'];
            //отправка менеджеру на почту, если клиенту нужна консультация
            if ($contact->consultation == 'on'){ array_push($emails, 'artem.smilhain@grupa.agency'); }
            $message->to($emails)->sender(env('MAIL_USERNAME'), $name = env('APP_NAME'))->subject('Консультация');
        });
    }

    //отправляем письмо менеджеру Logos Centrum
    public function logos_mail(){
        return 1;
    }

    //форма для отправки данных клиента
    public function form_index(){
        return view('client.client_data');
    }
}
