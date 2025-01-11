<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Http\Requests\BasketRequest;
use App\Models\Nomenclature;

class BasketController extends Controller
{
    public function index()
    {
        $curentUser = auth()->user();
        $basket = $curentUser->basket()->with('nomenclature.brand')->get();
        return response(['message' => 'ok', 'data' => $basket], 200);
    }

    public function add(BasketRequest $request)
    {
        $data = $request->input('basket');
        $currentUser = auth()->user();

        $data = array_map(function ($item) use ($currentUser) {
            $item['created_by'] = $currentUser->id;
            return $item;
        }, $data);

        $existingGuids = Nomenclature::pluck('guid')->toArray();
        $missingGuids = array_diff(array_column($data, 'nomenclature_guid'), $existingGuids);

        if (count($missingGuids) > 0) {
            return response(['message' => 'error, guid not found', 'missing_guids' => $missingGuids], 404);
        }

        foreach ($data as $item) {
            Basket::updateOrCreate(
                ['created_by' => $item['created_by'], 'nomenclature_guid' => $item['nomenclature_guid']],
                ['amount' => $item['amount']]
            );
        }
        //Basket::upsert($data, ['created_by', 'nomenclature_guid'], ['amount']);

        return response(['message' => 'ok'], 200);
    }

    public function delete(BasketRequest $request)
    {
        $data = $request->input('guids');
        $currentUser = auth()->user();

        try {
            $currentUser->basket()->whereIn('nomenclature_guid', $data)->delete();
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()],  500);
        }
        return response(['message' => 'ok'], 200);
    }

    public function clear(BasketRequest $request)
    {
        $currentUser = auth()->user();

        if ($currentUser->basket->isEmpty()) {
            return response(['message' => 'The basket is empty'], 204);
        }
        try {
            $currentUser->basket()->delete();
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }
        return response(['message' => 'ok'], 200);
    }
}
