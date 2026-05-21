<?php

namespace App\Http\Controllers;

use App\Models\MasterClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function confirm($id)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        $masterClass = MasterClass::with(['craftType', 'master', 'registrations'])->findOrFail($id);
        $user = Auth::user();
        $freeSpots = $masterClass->max_participants - $masterClass->registrations->count();
        $alreadyRegistered = $user->registrations()->where('master_class_id', $id)->exists();
        
        return view('confirm', compact('masterClass', 'user', 'freeSpots', 'alreadyRegistered'));
    }

    public function store(Request $request)
    {
        $masterClassId = $request->input('master_class_id');
        $user = Auth::user();
        
        $masterClass = MasterClass::findOrFail($masterClassId);
        
        $registeredCount = $masterClass->registrations()->count();
        if ($registeredCount >= $masterClass->max_participants) {
            return redirect('/craft/' . $masterClass->craft_type_id)
                ->with('error', '❌ На этот мастер-класс уже нет свободных мест.');
        }
        
        if ($user->registrations()->where('master_class_id', $masterClassId)->exists()) {
            return redirect('/craft/' . $masterClass->craft_type_id)
                ->with('error', '❌ Вы уже записаны на этот мастер-класс!');
        }
        
        $user->registrations()->create([
            'master_class_id' => $masterClassId
        ]);
        
        return redirect('/craft/' . $masterClass->craft_type_id)
            ->with('success', '✅ Вы успешно записались на мастер-класс «' . $masterClass->title . '»!');
    }
}
