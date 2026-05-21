<?php

namespace App\Http\Controllers;

use App\Models\CraftType;
use App\Models\MasterClass;

class CraftController extends Controller
{
    public function show($id)
    {
        $craftType = CraftType::findOrFail($id);
        $masterClasses = MasterClass::where('craft_type_id', $id)
            ->with(['master', 'registrations'])
            ->get();

        return view('craft', compact('craftType', 'masterClasses'));
    }
}
