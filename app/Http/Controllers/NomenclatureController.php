<?php

namespace App\Http\Controllers;

use App\Http\Filters\NomenclatureFilter;
use App\Models\Nomenclature;
use Illuminate\Http\Request;

class NomenclatureController extends Controller
{
    public function index(NomenclatureFilter $filter)
    {
        $nomenclature = Nomenclature::with('brand')->filter($filter)->get();
        return response(["message" => "ok", "data" => $nomenclature]);
    }
}
