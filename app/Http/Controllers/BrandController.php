<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Http\Filters\BrandFilter;

class BrandController extends Controller
{
    public function index(BrandFilter $filter)
    {
        $brand = Brand::filter($filter)->with(['brands', 'main_brand'])->get();
        return response(['message' => 'ok', 'data' => $brand], 200);
    }
}
