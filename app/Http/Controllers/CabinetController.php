<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CabinetController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $user = Auth::user();

        if ($user->isMaster()) {
            $masterClasses = $user->masterClasses()->with(['craftType', 'registrations.user'])->get();
            return view('cabinet.master', compact('user', 'masterClasses'));
        } else {
            $registrations = $user->registrations()->with(['masterClass.craftType', 'masterClass.master'])->get();
            return view('cabinet.user', compact('user', 'registrations'));
        }
    }
}
