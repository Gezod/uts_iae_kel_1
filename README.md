# Laravel Integration Service (3-Service Architecture)

Repositori ini berisi 3 layanan Laravel yang saling terintegrasi:

- **Service A** – Autentikasi (Register & Login) + Integrasi tampilan Order & Product
- **Service B1** – CRUD Order
- **Service B2** – Tampilkan Produk

## 🧱 Struktur Folder


## 🚀 Port & Perintah Jalankan

| Service   | Fungsi               | Port Laravel | Port Frontend (Vite) | Jalankan dengan                                 |
|-----------|----------------------|--------------|----------------------|--------------------------------------------------|
| A         | Auth + Integrasi UI  | 8000         | 5173 (default)       | `php artisan serve` + `npm run dev`             |
| B1        | CRUD Order           | 8001         | -                    | `php artisan serve --port=8001`                 |
| B2        | Show Product         | 8002         | 5174                 | `php artisan serve --port=8002` + `npm run dev --port=5174` |


## 🧩 Integrasi Antar Service

### 🔐 Service A (Main Interface)
- Menyediakan fitur Login & Register
- Mengambil dan menampilkan data Order dari Service B
- Mengambil dan menampilkan data Product dari Service C

### 📦 Service B1 (Order Service)
- Menyediakan API CRUD untuk data Order
- Perubahan Order akan otomatis tercermin di tampilan Service A

### 🛍️ Service B2 (Product Service)
- Menyediakan daftar produk (Product Viewer)
- Perubahan data produk akan langsung diperbarui di Service A

---

## 🔗 Contoh Endpoint API

- `GET http://localhost:8001/api/orders` → (Order dari Service B)  
- `GET http://localhost:8002/api/products` → (Product dari Service C)

---

## 📌 Catatan

- Masing-masing service memiliki file `.env` dan database yang terpisah.
- Pastikan konfigurasi **CORS** sudah sesuai agar komunikasi antar service berjalan lancar.
- Untuk pengembangan lanjutan, direkomendasikan menggunakan:
  - Laravel **Sanctum** atau **Passport** (untuk autentikasi API)
  - **Redis Queue** atau **Laravel Scheduler** (untuk sinkronisasi background)
  - **WebSocket / Laravel Echo** (untuk real-time update)

## ⚙️ Instalasi & Setup

Lakukan untuk setiap folder service:

```bash
composer install
npm install
npm install boostrap-icons boostrap
cp .env.example .env
php artisan key:generate
php artisan migrate

