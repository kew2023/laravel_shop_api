<?php

namespace App\Http\Controllers;

use App\Models\DocumentStatus;
use Illuminate\Http\Request;

class DocumentStatusController extends Controller
{

    public function index()
    {
        return response(['message' => 'ok', 'data' => DocumentStatus::all()]);
    }
}
