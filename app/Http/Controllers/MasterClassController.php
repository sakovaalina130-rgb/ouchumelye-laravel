<?php

namespace App\Http\Controllers;

use App\Models\CraftType;
use App\Models\MasterClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterClassController extends Controller
{
    private function checkMaster()
    {
        if (!Auth::check()) {
            abort(403, 'Необходимо авторизоваться');
        }
        if (Auth::user()->role !== 2) {
            abort(403, 'Доступ только для ведущих');
        }
    }

    public function create()
    {
        $this->checkMaster();
        $craftTypes = CraftType::all();
        $timeSlots = ['9-11', '11-13', '13-15', '15-17'];

        return view('master-classes.create', compact('craftTypes', 'timeSlots'));
    }

    public function store(Request $request)
    {
        $this->checkMaster();

        $validated = $request->validate([
            'craft_type_id' => 'required|exists:craft_types,id',
            'title' => 'required|string|min:5|max:100',
            'description' => 'required|string|min:20|max:1000',
            'date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|in:9-11,11-13,13-15,15-17',
            'max_participants' => 'required|integer|min:1|max:50',
            'price' => 'required|numeric|min:0|max:100000',
        ]);

        $exists = MasterClass::where('master_id', Auth::id())
            ->where('date', $validated['date'])
            ->where('time_slot', $validated['time_slot'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['time_slot' => 'На это время у вас уже запланирован мастер-класс']);
        }

        MasterClass::create([
            'craft_type_id' => $validated['craft_type_id'],
            'master_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'date' => $validated['date'],
            'time_slot' => $validated['time_slot'],
            'max_participants' => $validated['max_participants'],
            'price' => $validated['price'],
        ]);

        return redirect('/cabinet')->with('success', 'Мастер-класс добавлен');
    }

    public function edit($id)
    {
        $this->checkMaster();

        $masterClass = MasterClass::where('id', $id)
            ->where('master_id', Auth::id())
            ->firstOrFail();

        return view('master-classes.edit', compact('masterClass'));
    }

    public function update(Request $request, $id)
    {
        $this->checkMaster();

        $masterClass = MasterClass::where('id', $id)
            ->where('master_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'description' => 'required|string|min:20|max:1000',
            'price' => 'required|numeric|min:0|max:100000',
        ]);

        $masterClass->update($validated);
        return redirect('/cabinet')->with('success', 'Мастер-класс обновлён');
    }

    public function checkSlots(Request $request)
    {
        $date = $request->query('date');

        if (!Auth::check()) {
            return response()->json([]);
        }

        $masterId = Auth::id();

        $occupied = MasterClass::where('master_id', $masterId)
            ->where('date', $date)
            ->pluck('time_slot')
            ->toArray();

        // Возвращаем объект, где ключи — занятые слоты, значение — true
        $result = [];
        foreach ($occupied as $slot) {
            $result[$slot] = true;
        }

        return response()->json($result);
    }
}
