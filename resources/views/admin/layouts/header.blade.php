<nav class="bg-light pt-2 pb-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <div class="logo">
                    <img src="/images/logo.png" alt="" style="max-height: 50px;">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="m-0 h-100">
                    <div class="d-flex h-100" style="align-items: center;">
                        <ul class="p-0 m-0">
                            <li class="d-inline-block me-3">
                                <a href="/admin/questions/index" class="text-secondary dec-none">Впоросы</a>
                            </li>
                            <li class="d-inline-block me-3">
                                <a href="/admin/answers/index" class="text-secondary dec-none">Ответы</a>
                            </li>
                            <li class="d-inline-block me-3">
                                <a href="/admin/users/index" class="text-secondary dec-none">Пользователи</a>
                            </li>
                            <li class="d-inline-block">
                                <a href="/admin/users/index" class="text-secondary dec-none">Настройки</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="h-100">
                    <div class="w-100 h-100 d-flex" style="align-items: center; justify-content: flex-end;">
                        <div class="me-4">
                            <span><b>{{ Auth::user()->name }}</b></span>
                        </div>
                        <div class="me-1">
                            <a href="https://trello.com/logoscentrum1/home" class="btn btn-outline-secondary"> Trello </a>
                        </div>
                        <div>
                            <a href="https://logoscentrum.com/admin" class="btn btn-outline-secondary"> Основной сайт </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

