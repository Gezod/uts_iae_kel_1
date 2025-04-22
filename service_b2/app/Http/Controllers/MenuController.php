<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all()->map(function ($menu) {
            $menu->photo_url = asset($menu->photo); // ← ini penting!
            return $menu;
        });

        return Inertia::render('MenuList', [
            'menus' => $menus
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoPath = $photo->store('images/menu', 'public'); // Menyimpan gambar di 'public/images/menu'
        } else {
            $photoPath = null;
        }

        // Membuat menu baru dengan path gambar
        $menu = Menu::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'photo' => $photoPath, // Menyimpan path gambar
        ]);

        // Mengembalikan menu yang baru saja ditambahkan
        return response()->json($menu, 201);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        // Validasi data yang diterima
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file gambar
        ]);

        // Proses upload gambar jika ada
        if ($request->hasFile('photo')) {
            // Hapus gambar lama
            if ($menu->photo) {
                Storage::disk('public')->delete($menu->photo);
            }

            // Upload gambar baru
            $photo = $request->file('photo');
            $photoPath = $photo->store('images/menu', 'public');
        } else {
            $photoPath = $menu->photo; // Jika tidak ada gambar baru, gunakan gambar lama
        }

        // Update menu dengan data baru
        $menu->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'price' => $validated['price'],
            'photo' => $photoPath, // Menyimpan path gambar yang baru
        ]);

        // Mengembalikan data menu yang telah diperbarui
        return response()->json($menu);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        // Hapus gambar jika ada
        if ($menu->photo) {
            Storage::disk('public')->delete($menu->photo);
        }

        // Hapus menu dari database
        $menu->delete();

        // Mengembalikan response 204 (No Content) setelah berhasil menghapus
        return response()->json(null, 204);
    }
    public function showMenuPage()
    {
        $menus = Menu::all()->map(function ($menu) {
            $menu->photo_url = asset($menu->photo); // ← ini penting!
            return $menu;
        });

        return Inertia::render('MenuList', [
            'menus' => $menus
        ]);
    }
}
