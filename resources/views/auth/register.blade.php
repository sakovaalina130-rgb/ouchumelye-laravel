<!DOCTYPE html>
<html>
<head>
    <title>Регистрация - Клуб любителей творчества</title>
    <link rel="stylesheet" type="text/css" href="/css/styles.css">
    <link rel="stylesheet" type="text/css" href="/css/responsive.css">
</head>
<body>
    <div class="header">
        <div class="row grid middle between">
            <div class="logo"><img src="/img/logo.png" alt="Logo"></div>
            <div class="title">Клуб любителей творчества «ОчУмелые ручки»</div>
            <div class="auth">
                <a href="/login">Вход</a>
                <a href="/register">Регистрация</a>
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
                <form method="POST" action="/register">
                    @csrf
                    <h2>Форма регистрации</h2>

                    <div class="form-group">
                        <label>ФИО *</label>
                        <input type="text" name="fio" required value="{{ old('fio') }}">
                        @error('fio')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                        <div class="hint">Только буквы, пробелы и дефисы. От 5 символов.</div>
                    </div>

                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required value="{{ old('email') }}">
                        @error('email')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                        <div class="hint">Введите корректный email</div>
                    </div>

                    <div class="form-group">
                        <label>Пароль *</label>
                        <input type="password" name="password" required>
                        @error('password')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                        <div class="hint">Минимум 4 символа</div>
                    </div>

                    <div class="form-group">
                        <label>Подтверждение пароля *</label>
                        <input type="password" name="password_confirmation" required>
                        <div class="hint">Повторите пароль</div>
                    </div>

                    <div class="form-group">
                        <label>Номер телефона *</label>
                        <input type="tel" name="phone" required value="{{ old('phone') }}">
                        @error('phone')
                            <div style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                        <div class="hint">Только цифры, пробелы, скобки, дефис</div>
                    </div>

                    <div class="form-group">
                        <label>
                            <input type="checkbox" name="is_master" {{ old('is_master') ? 'checked' : '' }}>
                            Я ведущий мастер-классов
                        </label>
                    </div>

                    <div class="form-group">
                        <button class="btn">Зарегистрироваться</button>
                    </div>

                    <p>Уже есть аккаунт? <a href="/login">Войти</a></p>
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
