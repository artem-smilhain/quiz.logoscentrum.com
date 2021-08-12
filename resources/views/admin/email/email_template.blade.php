<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                Клиент отметил, что ему нужна консультация! <br> <br>
                <div class="card-header">Его данные: </div>
                <div class="card-body">
                    Имя: {{ $name }} <br>
                    Телефон: {{ $phone }} <br>
                    Email: {{ $email }} <br> <br>
                    Результат теста по словацкому языку - {{ $rating }} из {{ $questions_count }}<br>
                </div>
            </div>
        </div>
    </div>
</div>
