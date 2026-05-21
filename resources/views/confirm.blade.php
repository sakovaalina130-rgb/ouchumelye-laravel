<!DOCTYPE html>
<html>
<head>
    <title>Подтверждение записи</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.css">
</head>
<body>
    <div class="header">
        <div class="row grid middle between">
            <div class="logo"><img src="/img/logo.png" alt="Logo"></div>
            <div class="title">Клуб любителей творчества «ОчУмелые ручки»</div>
            <div class="auth">
                @auth
                    <a href="/cabinet">Личный кабинет</a>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit">Выход</button>
                    </form>
                @else
                    <a href="/login">Вход</a>
                    <a href="/register">Регистрация</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="row row--nogutter">
        <div class="menu-burger">
            <div class="burger">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>

    <div class="main">
        <div class="row">
            <div class="row--small">
                <form method="POST" action="/register-master-class">
                    @csrf
                    <input type="hidden" name="master_class_id" value="{{ $masterClass->id }}">
                    <h2>Подтверждение записи на мастер-класс</h2>

                    @if($freeSpots <= 0)
                        <p style="color: red; background: #ffe0e0; padding: 15px; border-radius: 5px;">
                            ❌ Извините, на этот мастер-класс уже нет свободных мест.
                        </p>
                        <a href="/craft/{{ $masterClass->craft_type_id }}">
                            <button type="button" class="btn">Вернуться назад</button>
                        </a>
                    @elseif($alreadyRegistered)
                        <p style="color: orange; background: #fff3cd; padding: 15px; border-radius: 5px;">
                            ⚠️ Вы уже записаны на этот мастер-класс!
                        </p>
                        <a href="/craft/{{ $masterClass->craft_type_id }}">
                            <button type="button" class="btn">Вернуться назад</button>
                        </a>
                    @else
                        <div class="form-group">
                            <label><strong>ФИО пользователя:</strong></label>
                            <p>{{ $user->fio }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Вид творчества:</strong></label>
                            <p>{{ $masterClass->craftType->name }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>ФИО мастера:</strong></label>
                            <p>{{ $masterClass->master->fio }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Название мастер-класса:</strong></label>
                            <p>{{ $masterClass->title }}</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Дата и время:</strong></label>
                            <p>{{ date('Y-m-d', strtotime($masterClass->date)) }} {{ $masterClass->time_slot }} часов</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Стоимость:</strong></label>
                            <p>{{ $masterClass->price }} руб.</p>
                        </div>

                        <div class="form-group">
                            <label><strong>Свободных мест:</strong></label>
                            <p>{{ $freeSpots }} из {{ $masterClass->max_participants }}</p>
                        </div>

                        <div class="form-group">
                            <button type="submit" name="confirm" class="btn">✅ Подтвердить запись</button>
                            <a href="/craft/{{ $masterClass->craft_type_id }}">
                                <button type="button" class="btn">❌ Отмена</button>
                            </a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <div class="row row--nogutter">
        <div class="line"></div>
    </div>

    <div class="footer">
        <div class="row">
            <div class="row--small grid between">
                <div class="address">Наш адрес: ВДНХ, 120в</div>
                <div class="tel">Тел: 89123456765</div>
                <div class="copy">(с) Copyright, 2017</div>
            </div>
        </div>
    </div>
</body>
</html>
