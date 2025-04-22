# Laravel Integration Service (3-Service Architecture)

Repositori ini berisi 3 layanan Laravel yang saling terintegrasi:

- **Service A** – Autentikasi (Register & Login) + Integrasi tampilan Order & Product
- **Service B** – CRUD Order
- **Service C** – Tampilkan Produk

## 🧱 Struktur Folder


## 🚀 Port & Perintah Jalankan

| Service   | Fungsi               | Port Laravel | Port Frontend (Vite) | Jalankan dengan                                 |
|-----------|----------------------|--------------|----------------------|--------------------------------------------------|
| A         | Auth + Integrasi UI  | 8000         | 5173 (default)       | `php artisan serve` + `npm run dev`             |
| B         | CRUD Order           | 8001         | -                    | `php artisan serve --port=8001`                 |
| C         | Show Product         | 8002         | 5174                 | `php artisan serve --port=8002` + `npm run dev --port=5174` |

## ⚙️ Instalasi & Setup

Lakukan untuk setiap folder service:

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
🧩 Integrasi Antar Service
Service A:

Login & Register

Menampilkan data dari Service B (Order)

Menampilkan data dari Service C (Product)

Service B:

CRUD Order

Update otomatis ditampilkan di Service A

Service C:

Show Product

Perubahan produk otomatis update di Service A

🔗 Contoh API Endpoint
Orders: http://localhost:8001/api/orders

Products: http://localhost:8002/api/products

📌 Catatan
Masing-masing service memiliki .env dan database sendiri.

Pastikan CORS sudah diatur agar komunikasi antar service berjalan lancar.

Rekomendasi integrasi lanjutan: Laravel Sanctum/Passport, Redis Queue, Laravel Scheduler, atau WebSocket.
