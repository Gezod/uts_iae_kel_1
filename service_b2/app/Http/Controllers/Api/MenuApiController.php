<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MenuApiController extends Controller
{
    // Menampilkan semua menu (Inertia)
    public function index()
    {
        $menus = Menu::all()->map(function ($menu) {
            $menu->photo_url = asset('storage/' . $menu->photo); // Pastikan pakai 'storage' kalau file disimpan di disk 'public'
            return $menu;
        });

        return response()->json($menus);
    }

    // Menambahkan menu baru (API)
    public function store(Request $request)
    {
        // Validasi input dari request
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'type' => 'required|in:food,drink', // Validasi untuk enum 'food' atau 'drink'
            'price' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Inisialisasi variable untuk menyimpan path foto (jika ada)
        $photoPath = null;

        // Cek apakah ada foto yang di-upload
        if ($request->hasFile('photo')) {
            // Simpan gambar di folder public/images/menu
            $photoPath = $request->file('photo')->store('images/menu', 'public');
        }

        // Membuat record baru pada tabel menus
        $menu = Menu::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'type' => $validated['type'],  // Menyimpan tipe (food/drink)
            'price' => $validated['price'],
            'photo' => $photoPath,  // Menyimpan path gambar jika ada
        ]);

        // Menambahkan URL lengkap gambar
        $menu->photo_url = $photoPath ? asset('storage/' . $photoPath) : null;

        // Mengembalikan response berupa JSON dengan status 201 (Created)
        return response()->json([
            'id' => $menu->id,
            'name' => $menu->name,
            'description' => $menu->description,
            'type' => $menu->type,
            'price' => $menu->price,
            'photo' => $menu->photo,
            'photo_url' => $menu->photo ? asset('storage/' . $menu->photo) : null,
        ], 201);
    }

    // Menampilkan menu tertentu (API)
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->photo_url = asset('storage/' . $menu->photo);
        return response()->json($menu);
    }

    // Mengupdate menu (API)
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }

            $photoPath = $request->file('photo')->store('images/menu', 'public');
        } else {
            $photoPath = $menu->photo;
        }

        $menu->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'photo' => $photoPath,
        ]);

        $menu->photo_url = asset('storage/' . $menu->photo);

        return response()->json($menu);
    }

    // Menghapus menu (API)
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo);
        }

        $menu->delete();

        return response()->json(['message' => 'Menu deleted successfully.'], 204);
    }
}
