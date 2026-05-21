<!DOCTYPE html>
<html>
<head>
    <title>{{ $craftType->name }} - Клуб любителей творчества</title>
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
</div>        </div>
    </div>

    <div class="row row--nogutter">

    @if(session('success'))
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 15px 20px; border-radius: 8px; font-size: 14px; animation: fadeOut 3s ease-in-out forwards; background: #d4edda; color: #155724; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 15px 20px; border-radius: 8px; font-size: 14px; animation: fadeOut 3s ease-in-out forwards; background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 15px 20px; border-radius: 8px; font-size: 14px; animation: fadeOut 3s ease-in-out forwards; background: #d1ecf1; color: #0c5460; border-left: 4px solid #17a2b8;">
            {{ session('info') }}
        </div>
    @endif

    <style>
        @keyframes fadeOut {
            0% { opacity: 1; transform: translateX(0); }
            70% { opacity: 1; transform: translateX(0); }
            100% { opacity: 0; transform: translateX(20px); visibility: hidden; }
        }
    </style>
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
            <div class="title">{{ $craftType->name }}</div>
            <div class="row--small grid between">
                <div class="content">
                    <img src="/img/elifant.png" alt="Illustration">
                    <?php
                        $text = $craftType->description;
                        $paragraphs = explode("\n\n", $text);
                        foreach ($paragraphs as $paragraph) {
                            echo '<p>' . e($paragraph) . '</p>';
                        }
                    ?>
                </div>
                <ul class="menu">
                    @foreach(\App\Models\CraftType::all() as $type)
                        <li><a href="/craft/{{ $type->id }}">{{ $type->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="row shedule">
                <div class="row--small">
                    <h2>Расписание</h2>
                    <div class="drivers">
                        @forelse($masterClasses as $mc)
                            @php $freeSpots = $mc->free_spots; @endphp
                            <div class="driver grid">
                                <div class="driver-left grid">
                                    <div class="driver-photo">
                                        <img src="/img/driver1.png" alt="Master photo">
                                    </div>
                                    <div class="driver-text">
                                        <div class="driver-name">{{ $mc->master->fio ?? 'Мастер' }}</div>
                                        <div class="driver-title" style="font-weight: bold; font-size: 18px; margin: 10px 0;">{{ $mc->title }}</div>
                                        <div class="driver-desc">{{ $mc->description }}</div>
                                        <div class="driver-info">
                                            💰 {{ $mc->price }} руб. 
                                            👥 Свободно: {{ $freeSpots }} из {{ $mc->max_participants }}
                                        </div>
                                    </div>
                                </div>
                                <div class="driver-right">
                                    @auth
                                        @if($freeSpots > 0)
                                            @if(!auth()->user()->isMaster())
                                                <a href="/confirm/{{ $mc->id }}">
                                                    <button class="driver-btn">Записаться</button>
                                                </a>
                                            @else
                                                <button class="driver-btn" disabled style="opacity:0.5">Ведущий не может записаться</button>
                                            @endif
                                        @else
                                            <button class="driver-btn" disabled style="opacity:0.5">Мест нет</button>
                                        @endif
                                    @else
                                        <a href="/login">
                                            <button class="driver-btn" style="cursor: pointer;">Войдите, чтобы записаться</button>
                                        </a>
                                    @endauth
                                    <div class="driver-time">{{ date("Y-m-d", strtotime($mc->date)) }} {{ $mc->time_slot }}ч</div>
                                </div>
                            </div>
                        @empty
                            <p style="color: #fff; text-align: center;">В этом виде творчества пока нет мастер-классов.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row row--nogutter">

    @if(session('success'))
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 15px 20px; border-radius: 8px; font-size: 14px; animation: fadeOut 3s ease-in-out forwards; background: #d4edda; color: #155724; border-left: 4px solid #28a745;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 15px 20px; border-radius: 8px; font-size: 14px; animation: fadeOut 3s ease-in-out forwards; background: #f8d7da; color: #721c24; border-left: 4px solid #dc3545;">
            {{ session('error') }}
        </div>
    @endif

    @if(session('info'))
        <div style="position: fixed; top: 20px; right: 20px; z-index: 9999; padding: 15px 20px; border-radius: 8px; font-size: 14px; animation: fadeOut 3s ease-in-out forwards; background: #d1ecf1; color: #0c5460; border-left: 4px solid #17a2b8;">
            {{ session('info') }}
        </div>
    @endif

    <style>
        @keyframes fadeOut {
            0% { opacity: 1; transform: translateX(0); }
            70% { opacity: 1; transform: translateX(0); }
            100% { opacity: 0; transform: translateX(20px); visibility: hidden; }
        }
    </style>
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
