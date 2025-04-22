<script setup>
defineProps({
    menus: Array
});
</script>

<template>
    <div class="bg-dark text-white min-vh-100 py-4">
        <div class="container">
            <h4 class="mb-4 text-center">Menu</h4>

            <!-- Responsive Card Layout -->
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
                <div v-for="menu in menus" :key="menu.id" class="col d-flex justify-content-center">
                    <div class="card bg-dark text-white border-secondary shadow-sm" style="width: 16rem;">

                        <!-- Photo -->
                        <img :src="menu.photo ? `/storage/${menu.photo}` : '/default-image.png'"
                             class="card-img-top"
                             alt="Menu Image"
                             style="height: 180px; object-fit: cover; width: 100%;" />

                        <div class="card-body p-3" style="font-size: 1rem;">
                            <!-- Name -->
                            <h5 class="card-title mb-2"
                                style="font-size: 1.1rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ menu.name }}
                            </h5>

                            <!-- Description -->
                            <p class="card-text mb-1"
                                style="font-size: 0.85rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                {{ menu.description.slice(0, 50) }}...
                            </p>

                            <!-- Type -->
                            <p class="text-muted mb-1" style="font-size: 0.8rem;">
                                Type: {{ menu.type }}
                            </p>

                            <!-- Price -->
                            <div class="fw-bold mb-2" style="font-size: 0.95rem;">
                                Rp {{ menu.price.toLocaleString() }}
                            </div>

                            <!-- Action -->
                            <!-- <a href="#" class="btn btn-sm btn-primary w-100">
                                Pesan Sekarang
                            </a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
