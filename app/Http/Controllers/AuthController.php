<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Введите email',
            'email.email' => 'Введите корректный email',
            'password.required' => 'Введите пароль',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/cabinet');
        }

        return back()->withErrors(['email' => 'Неверный email или пароль']);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $fio = trim($request->input('fio'));
        $fio = preg_replace('/\s+/', ' ', $fio);

        $errors = [];

        // Проверка ФИО
        if (strlen($fio) < 5) {
            $errors['fio'] = 'ФИО должно содержать минимум 5 символов';
        } elseif (!preg_match('/^[a-zA-Zа-яА-ЯёЁ][a-zA-Zа-яА-ЯёЁ\s\-]*[a-zA-Zа-яА-ЯёЁ]$/u', $fio)) {
            $errors['fio'] = 'ФИО должно начинаться и заканчиваться на букву';
        } elseif (preg_match('/[\s\-]{2,}/u', $fio)) {
            $errors['fio'] = 'ФИО не должно содержать два пробела или дефиса подряд';
        }

        // Проверка email
        if (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Неверный формат email';
        } else {
            $existingUser = User::where('email', $request->email)->exists();
            if ($existingUser) {
                $errors['email'] = 'Пользователь с таким email уже существует';
            }
        }

        // Проверка телефона
        $phone = $request->phone;
        if (empty($phone)) {
            $errors['phone'] = 'Введите номер телефона';
        } elseif (!preg_match('/^\+?[0-9\s\-\(\)]{8,20}$/', $phone)) {
            $errors['phone'] = 'Неверный формат телефона';
        } elseif (!preg_match('/[0-9]/', $phone)) {
            $errors['phone'] = 'Номер телефона должен содержать хотя бы одну цифру';
        } elseif (preg_match('/[^0-9\s\+\(\)-]/', $phone)) {
            $errors['phone'] = 'Номер телефона содержит недопустимые символы';
        }

        // Проверка пароля
        if (strlen($request->password) < 4) {
            $errors['password'] = 'Пароль должен содержать минимум 4 символа';
        } elseif ($request->password !== $request->password_confirmation) {
            $errors['password'] = 'Пароли не совпадают';
        }

        if (!empty($errors)) {
            return back()->withErrors($errors)->withInput();
        }

        // Создание пользователя (без автоматического входа)
        User::create([
            'fio' => $fio,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->has('is_master') ? 2 : 1,
        ]);

        // Перенаправление на страницу входа с сообщением
        return redirect('/login')->with('success', 'Регистрация прошла успешно! Теперь войдите в систему.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
