@extends('layouts.app') {{-- Ganti jika kamu punya layout lain --}}

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Order dari Service B</h2>

    <div class="row">
        @forelse ($orders as $order)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Order #{{ $order['id'] }}</h5>
                        <p class="card-text">
                            <strong>User ID:</strong> {{ $order['user'] ?? '-' }}<br>
                            <strong>Total:</strong> Rp {{ number_format($order['total_price'] ?? 0, 0, ',', '.') }}<br>
                            <strong>Status:</strong> {{ $order['status'] ?? 'Unknown' }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Tidak ada order yang ditemukan.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
