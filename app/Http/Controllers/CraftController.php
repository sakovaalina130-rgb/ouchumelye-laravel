<?php

namespace App\Http\Controllers;

use App\Models\CraftType;
use App\Models\MasterClass;
use Illuminate\View\View;

class CraftController extends Controller
{
    public function show(int $id): View
    {
        $craftType = CraftType::findOrFail($id);
        $masterClasses = MasterClass::where('craft_type_id', $id)
            ->with(['master', 'registrations'])
            ->get();

        return view('craft', compact('craftType', 'masterClasses'));
    }
}
