<!DOCTYPE html>
<html>
<head>
    <title>Вход - Клуб любителей творчества</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.css">
</head>
<body>
    <div class="header">
        <div class="row grid middle between">
            <div class="logo"><img src="/img/logo.png" alt="Logo"></div>
            <div class="title">Клуб любителей творчества «ОчУмелые ручки»</div>
            <div class="auth">
                <a href="/login">Вход</a>  <a href="/register">Регистрация</a>
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
                <form method="POST" action="/login">
                    @csrf
                    <h2>Вход в систему</h2>

@if(session('success'))
    <div style="color: green; background: #d4edda; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
        {{ session('success') }}
    </div>
@endif

                    @if($errors->any())
                        <p style="color: red; background: #ffe0e0; padding: 10px; border-radius: 5px;">
                            {{ $errors->first() }}
                        </p>
                    @endif

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
                        <label>Пароль</label>
                        <input type="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <button class="btn">Войти</button>
                    </div>

                    <p>Нет аккаунта? <a href="/register">Зарегистрироваться</a></p>
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
