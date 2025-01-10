<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\DocumentStatus;
use App\Models\Nomenclature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{

    public function import(Request $request, $table_name)
    {
        $data = $request->all();
        if ($table_name === 'nomenclature') {
            try {
                foreach ($data as $value) {
                    $validator = Validator::make($value, [
                        'guid' => ['required', 'string', 'max:36'],
                        'code' => ['required', 'string', 'max:11'],
                        'name' => ['required', 'string', 'max:100'],
                        'full_name' => ['required', 'string'],
                        'set_number' => ['required', 'string'],
                        'brand_guid' => ['required', 'string', 'max:36'],
                    ]);

                    if ($validator->fails()) {
                        return response()->json(['message' => $validator->errors()], 400);
                    }
                }
                Nomenclature::upsert($data, 'guid', ['code', 'name', 'full_name', 'set_number', 'price', 'brand_guid']);
            } catch (\Exception $e) {
                return response(['message' => $e->getMessage()], 500);
            }
        } elseif ($table_name === 'document_statuses') {
            try {
                foreach ($data as $value) {
                    $validator = Validator::make($value, [
                        'guid' => ['required', 'string', 'max:36'],
                        'name' => ['required', 'string', 'max:50']
                    ]);

                    if ($validator->fails()) {
                        return response()->json(['message' => $validator->errors()], 400);
                    }
                }
                DocumentStatus::upsert($data, 'guid', ['name']);
            } catch (\Exception $e) {
                return response(['message' => $e->getMessage()], 500);
            }
        } elseif ($table_name === 'brands') {
            try {
                foreach ($data as $value) {
                    $validator = Validator::make($value, [
                        'guid' => ['required', 'string', 'max:36'],
                        'name' => ['required', 'string', 'max:25'],
                        'main_brand_guid' => ['string', 'max:36']
                    ]);

                    if ($validator->fails()) {
                        return response()->json(['message' => $validator->errors()], 400);
                    }
                }
                Brand::upsert($data, 'guid', ['name', 'main_brand_guid']);
            } catch (\Exception $e) {
                return response(['message' => $e->getMessage()], 500);
            }
        } else {
            return response(['message' => 'table not found'], 404);
        }

        return response(['message' => 'ok'], 200);
    }
}
