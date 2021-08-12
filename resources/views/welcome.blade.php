<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Quiz</title>
        <!-- Bootstrap -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    </head>
    <body class="text-center pt-4">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block text-center">
            <h3>Slovenský jazyk</h3>
            <h5>Тест для определения уровня знаний языка: </h5>
            <p>Проверьте свой уровень владения языком всего за пару минут в коротком онлайн тесте!</p>
            <button type="button" class="btn btn-warning" onclick=" window.location.href = '/quiz'; ">Начать тест</button>
            <br>
            <a href="https://logoscentrum.com">Вернуться на сайт</a>
        </div>
    </body>
</html>

