<!DOCTYPE html>
<html>
<head>
    <title>Редактирование мастер-класса</title>
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
                <form method="POST" action="/master-class/{{ $masterClass->id }}">
                    @csrf
                    @method('PUT')
                    <h2>Редактирование мастер-класса</h2>
                    <p><strong>{{ $masterClass->title }}</strong></p>
                    <p><strong>Дата:</strong> {{ $masterClass->date }}</p>
                    <p><strong>Время:</strong> {{ str_replace('-', '-', $masterClass->time_slot) }} часов</p>

                    @if(isset($errors) && $errors->any())
                        <p style="color: red; background: #ffe0e0; padding: 10px; border-radius: 5px;">
                            {{ $errors->first() }}
                        </p>
                    @endif

                    <div class="form-group">
                        <label>Описание мастер-класса *</label>
                        <textarea name="description" required>{{ old('description', $masterClass->description) }}</textarea>
                        <small>От 20 до 1000 символов</small>
                    </div>

                    <div class="form-group">
                        <label>Стоимость мастер-класса (руб.) *</label>
                        <input type="number" step="0.01" name="price" min="0" max="100000" required value="{{ old('price', $masterClass->price) }}">
                        <small>От 0 до 100 000 рублей</small>
                    </div>

                    <div class="form-group">
                        <button class="btn">Сохранить изменения</button>
                        <a href="/cabinet"><button type="button" class="btn">Отмена</button></a>
                    </div>
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
