<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import axios from 'axios';

// Order Service (Service B1)
const orders = ref([]);
const fetchOrders = async () => {
    try {
        const response = await axios.get('http://localhost:8001/api/orders');
        orders.value = response.data;
    } catch (error) {
        console.error('Error fetching orders:', error);
    }
};

// Menu Service (Service B2)
const menus = ref([]);
const fetchMenus = async () => {
    try {
        const response = await axios.get('http://localhost:8002/api/menus');
        menus.value = response.data;
    } catch (error) {
        console.error('Error fetching menus:', error);
    }
};

// On Mounted
onMounted(() => {
    fetchOrders();
    fetchMenus();
});

// Format harga
const formatPrice = (price) => {
    return price.toLocaleString('id-ID');
};
</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in</div>
                </div>
            </div>
        </div>

        <!-- Orders Section -->
        <div class="container mt-4">
            <h2 class="mb-4">Daftar Order dari Service B1 (Order)</h2>
            <div class="row">
                <div v-if="orders.length === 0" class="col-12">
                    <div class="alert alert-info">Tidak ada order yang ditemukan.</div>
                </div>
                <div v-for="order in orders" :key="order.id" class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Order #{{ order.id }}</h5>
                            <p class="card-text">
                                <strong>User ID:</strong> {{ order.user || '-' }}<br>
                                <strong>Total:</strong> Rp {{ formatPrice(order.total_price) }}<br>
                                <strong>Status:</strong> {{ order.status || 'Unknown' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menus Section -->
        <div class="container mt-5">
  <h2 class="mb-4">Daftar Menu dari Service B2 (Menu)</h2>
  <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
    <div v-if="menus.length === 0" class="col-12">
      <div class="alert alert-warning">Tidak ada menu yang tersedia.</div>
    </div>

    <div v-for="menu in menus" :key="menu.id" class="col">
      <div class="card h-100 shadow-sm bg-light d-flex flex-column">
        <img
          :src="menu.photo_url || '/default-image.png'"
          class="card-img-top"
          alt="Menu Image"
          style="height: 180px; object-fit: cover;"
        />

        <div class="card-body d-flex flex-column">
          <!-- Memperbesar dan menebalkan nama menu -->
          <h5 class="card-title mb-2 fw-bold" style="font-size: 1.25rem;">{{ menu.name }}</h5>

          <p
            class="card-text text-muted mb-2"
            style="flex-grow: 1; overflow: hidden; text-overflow: ellipsis;"
          >
            {{ menu.description }}
          </p>

          <!-- Memperbesar dan menebalkan tipe menu -->
          <p class="text-muted mb-1 fw-bold" style="font-size: 1.1rem;">
            <small>Type: {{ menu.type }}</small>
          </p>

          <p class="fw-bold mt-auto mb-0">Rp {{ formatPrice(menu.price) }}</p>
        </div>
      </div>
    </div>
  </div>
</div>

    </AuthenticatedLayout>
</template>

<style scoped>
/* Custom style opsional */
</style>
