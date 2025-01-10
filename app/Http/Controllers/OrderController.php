<?php

namespace App\Http\Controllers;

use App\Http\Filters\OrderFilter;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderFilter $filter)
    {
        try {
            $currentUser = auth()->user();
            $orders = Order::filter($filter);

            if ($currentUser->role !== 'admin') {
                $orders = Order::filter($filter)->where('created_by', $currentUser->id)->with(['order_items.nomenclature.brand', 'document_status']);
            };

            $orders = $orders->get();
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        };

        return response(['message' => 'ok', 'data' => $orders], 200);
    }

    public function store(OrderRequest $request)
    {
        $data = $request->all();
        $currentUser = auth()->user();
        try {
            $orderData = [
                "contact_name" => $data['contact_name'],
                "contact_phone" => $data['contact_phone'],
                "website_comment" => $data['website_comment'],
                "delivery_company" => $data['delivery_company'],
                "delivery_method" => $data['delivery_method'],
                "delivery_address" => $data['delivery_address'],
                "delivery_date" => $data['delivery_date'],
                "is_delivery_today" => $data["is_delivery_today"]
            ];
            $order = $currentUser->orders()->create($orderData);

            $products = $data['products'];
            foreach ($products as $product) {
                $order->order_items()->create(
                    [
                        "nomenclature_guid" => $product['guid'],
                        "amount" => $product['amount']
                    ]
                );
            }
        } catch (\Exception $e) {
            return response(['message' => $e->getMessage()], 500);
        }

        return response(['message' => 'ok'], 200);
    }

    public function update(OrderRequest $request, $id)
    {
        $currentUser = auth()->user();
        $order = Order::find($id);
        $data = $request->all();

        if ($order === null) {
            return response(['message' => 'Order not found'], 404);
        }

        try {
            if ($currentUser->role === "admin") {
                $orderData = [
                    "status" => $data["status"] ?? null,
                    "payment_status" => $data["payment_status"] ?? null,
                    "website_comment_for_client" => $data["website_comment_for_client"] ?? null
                ];
                $order->update($orderData);
            } elseif ($order->created_by === $currentUser->id) {
                $orderData = [
                    "website_comment" => $data["website_comment"] ?? null,

                ];
                $order->update($orderData);
            } else {
                return response(["message" => "You don't have permission"], 403);
            }
        } catch (\Exception $e) {
            return response(["message" => $e->getMessage()], 500);
        }

        return response(["message" => "ok"], 200);
    }
}

/*

юзер с ролью customer может изменять комментарий с сайта

юзер с ролью admin может изменять статус, статус оплаты, комментарий для клиента

*/
