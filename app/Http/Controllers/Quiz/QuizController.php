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
        return view('client.index', [
            'answers' => Question::with('answer')->get(),
            'questions' => Question::orderBy('id', 'asc')->paginate(1),
            'pages' => Question::latest()->get()->count()
        ]);
    }
    //форма для отправки данных клиента
    public function form_index(){
        return view('client.client_data');
    }
    //
    public function session(Request $request){
        $request_page = $request->input('page');
        $request_answer = $request->input('question_answer');
        $points = Session::get('data');
        $points[$request_page] = $request_answer;
        Session::put('data', $points);

        if ( ($request_page + 1) > Question::latest()->get()->count()){
            return view('client.client_data', [
                'rating' => Controller::get_rating(Session::get('data'))
            ]);
        }
        else{
            return redirect('/quiz?page='.($request_page + 1));
        }
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
        Controller::send_data($data, $contact);
        //обнуляем нашу сессию
        Session::put('data', array());
        //редирект на страницу благодарности
        return redirect()->route('thank_you');
    }
}
