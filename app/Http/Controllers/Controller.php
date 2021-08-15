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
    //считаем баллы за тест
    public function get_rating($array){
        $count = 0;
        foreach ( $array as $element ) {
            $count += $element;
        }
        return $count;
    }
    //отправка письма
    public function send_data($data, $contact){

        //отправка клиенту
        $this->mail_sender(
            'client.email.email_template',
            $data,
            $contact,
            $contact->email,
            'Результат теста | Cловацкий язык'
        );

        $subject = 'Тест по Словацкому';
        $email = ['artemsmilhain+u2rasdbfprllon0fmkjo@boards.trello.com'];

        if ($contact->consultation == 'on'){
            $subject = 'Консультация';
            $email = ['artemsmilhain+u2rasdbfprllon0fmkjo@boards.trello.com', 'artem.smilhain@grupa.agency'];
            //dd($email);
        }

        //отправка менеджеру
        $this->mail_sender(
            'admin.email.email_template',
            $data,
            $contact,
            $email,
            $subject
        );
    }

    public function mail_sender($template, $data, $contact, $email, $subject){
        Mail::send(
            $template,
            $data,
            function($message) use ($contact, $email, $subject){
                $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
                $message->to($email)->subject($subject);
            }
        );
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
