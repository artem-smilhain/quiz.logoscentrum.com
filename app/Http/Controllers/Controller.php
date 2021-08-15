<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Question;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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

    public function image_processing($answer, $request, $check, $data){
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $filename = time() . '.' . $img->getClientOriginalExtension();
            $image = Image::make($img)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio(); // не теряем соотношение сторон
            });
            $image->stream();
            if ($check == true) {
                Storage::disk('local')->delete('public/images/' . $answer->image);
            }
            Storage::disk('local')->put('public/images/' . $filename, $image, 'public');
            $data['image'] = $filename;
            //get back наши данные из функции
        }
        return $data;
    }
}
