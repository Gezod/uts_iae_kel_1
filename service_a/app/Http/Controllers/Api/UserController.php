<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function show($id)
    {
        return User::findOrFail($id);
    }

    public function store(Request $request)
{
    $data = $request->validate([
        'name' => 'required|string',
        'password' => 'required|string|min:8', // Menambahkan validasi panjang password
        'email' => 'required|email|unique:users,email',
        'role' => 'required|in:admin,customer',
    ]);

    // Mengenkripsi password sebelum menyimpannya
    $data['password'] = Hash::make($data['password']);

    // Membuat user baru dan menyimpan data
    $user = User::create($data);

    return new UserResource($user);
}

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $data = $request->validate([
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $id,
            'role' => 'in:admin,customer',
        ]);
        $user->update($data);
        return new UserResource($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
    public function showOrdersFromServiceB()
{
    $response = Http::get('http://localhost:8001/api/orders');

    if ($response->successful()) {
        $orders = $response->json();
        return view('orders.index', compact('orders'));
    } else {
        return back()->with('error', 'Gagal mengambil data orders dari Service B');
    }
}
}
