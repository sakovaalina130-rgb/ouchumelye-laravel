<!DOCTYPE html>
<html>
<head>
    <title>Личный кабинет - Участник</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.css">
</head>
<body class="dp">
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
</div>        </div>
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
                <div class="content driver-page">
                    <div class="driver-page-photo">
                        <img src="{{ $user->photo ?? '/img/driver-page.png' }}" alt="User photo">
                    </div>
                    <div class="driver-page-name">
                        {{ $user->fio }}
                        <span style="font-size: 14px; background: #ccc; padding: 2px 8px; border-radius: 20px;">Участник</span>
                    </div>
                    <div class="driver-page-text">
                        <div class="driver-page-my">Мои записи на мастер-классы</div>
                        @if($registrations->count() > 0)
                            <table class="driver-page-table">
                                <tbody>
                                    @foreach($registrations as $reg)
                                        @php $mc = $reg->masterClass; @endphp
                                        <tr>
                                            <td style="white-space: nowrap; vertical-align: top; padding-right: 20px;">
                                                {{ date("Y-m-d", strtotime($mc->date)) }}<br>{{ $mc->time_slot }}ч
                                            </td>
                                            <td style="padding-left: 20px;">
                                                <strong>{{ $mc->title }}</strong><br>
                                                Вид: {{ $mc->craftType->name }}<br>
                                                Мастер: {{ $mc->master->fio }}<br>
                                                Стоимость: {{ $mc->price }} руб.
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Вы пока не записаны ни на один мастер-класс.</p>
                            <p><a href="/">Перейти к выбору мастер-классов</a></p>
                        @endif
                    </div>
                </div>
                <ul class="menu">
                    @foreach(\App\Models\CraftType::all() as $type)
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
