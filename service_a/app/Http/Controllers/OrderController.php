<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function showOrdersFromServiceB()
    {
        $response = Http::get('http://localhost:8001/api/orders');

        if ($response->successful()) {
            $orders = $response->json();
            return view('orders.index', compact('orders'));
        } else {
            return back()->with('error', 'Gagal mengambil data dari Service B.');
        }
    }
}
