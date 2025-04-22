<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        return Order::with('items')->get();
    }

    public function show($id)
    {
        return Order::with('items')->findOrFail($id);
    }

    public function userOrders($user)
    {
        $orders = Order::with('items')->where('user', $user)->get();

        // Kirim request ke Service A (pastikan port & endpoint-nya benar)
        $userResponse = Http::get("http://localhost:8000/api/users/{$user}");

        if ($userResponse->failed()) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user = $userResponse->json();

        return response()->json([
            'user' => $user,
            'orders' => $orders
        ]);
    }


    public function store(Request $request)
{
    $data = $request->validate([
        'user' => 'required|integer',
        'items' => 'required|array',
        'items.*.product_id' => 'required|integer',
        'items.*.quantity' => 'required|integer',
        'items.*.price' => 'required|numeric',
        'items.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $total = collect($data['items'])->sum(function ($item) {
        return $item['quantity'] * $item['price'];
    });

    $order = Order::create([
        'user' => $data['user'],
        'total_price' => $total,
        'status' => 'pending'
    ]);

    foreach ($data['items'] as $index => $item) {
        $imagePath = null;

        if ($request->hasFile("items.$index.image")) {
            $imagePath = $request->file("items.$index.image")->store('order_images', 'public');
        }

        $order->items()->create([
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
            'image_path' => $imagePath
        ]);
    }

    return response()->json([
        'message' => 'Order created successfully',
        'order' => $order->load('items')
    ], 201);  // Pastikan status code 201 untuk created
}


public function update(Request $request, $user)
{
    $order = Order::with('items')->findOrFail($user);

    $data = $request->validate([
        'status' => 'sometimes|string',
        'items' => 'sometimes|array',
        'items.*.product_id' => 'required_with:items|integer',
        'items.*.quantity' => 'required_with:items|integer',
        'items.*.price' => 'required_with:items|numeric',
        'items.*.image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Update status kalau ada
    if (isset($data['status'])) {
        $order->status = $data['status'];
        $order->save();
    }

    // Update item jika dikirim
    if (isset($data['items'])) {
        // Hapus item sebelumnya
        $order->items()->delete();

        // Tambahkan item baru
        foreach ($data['items'] as $index => $item) {
            $imagePath = null;

            if ($request->hasFile("items.$index.image")) {
                $imagePath = $request->file("items.$index.image")->store('order_images', 'public');
            }

            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'image_path' => $imagePath
            ]);
        }

        // Recalculate total
        $newTotal = collect($data['items'])->sum(function ($item) {
            return $item['quantity'] * $item['price'];
        });

        $order->total_price = $newTotal;
        $order->save();
    }

    return response()->json([
        'message' => 'Order updated successfully',
        'order' => $order->load('items')
    ]);
}


public function destroy($id)
{
    $order = Order::find($id);

    if (!$order) {
        return response()->json(['message' => 'Order not found'], 404);
    }

    // Hapus relasi terlebih dahulu (misal: order items)
    $order->items()->delete();

    // Hapus order-nya
    $order->delete();

    return response()->json(['message' => 'Order deleted successfully']);
}

}
