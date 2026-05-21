<!DOCTYPE html>
<html>
<head>
    <title>Главная - Клуб любителей творчества</title>
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
            <div class="hover"></div>
            <div class="title"></div>
            <div class="row--small grid between">
                <div class="content">
                    <h2>Добро пожаловать!</h2>
                    <p>Клуб любителей творчества «ОчУмелые ручки» приглашает на мастер-классы.</p>
                    @auth
                        <h3>Мои записи на мастер-классы</h3>
                        @if(isset($myRegistrations) && $myRegistrations->count() > 0)
                            <ul>
                                @foreach($myRegistrations as $reg)
                                    <li>{{ $reg->masterClass->title ?? '' }} ({{ $reg->masterClass->date ?? '' }})</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Вы пока не записаны ни на один мастер-класс.</p>
                        @endif
                    @endauth
                </div>
                <ul class="menu">
                    @foreach($craftTypes as $type)
                        <li><a href="/craft/{{ $type->id }}">{{ $type->name }}</a></li>
                    @endforeach
                </ul>
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
