<!DOCTYPE html>
<html lang="en">
<head>

    <style>
        /* Warna placeholder putih */
        ::placeholder {
            color: white !important;
            opacity: 1;
        }
        </style>
    <meta charset="UTF-8">
    <title>Order Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="bg-dark text-white">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Order Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">+ Create Order</button>
    </div>

    <div id="order-list" class="row g-3">
        <!-- Orders will be rendered here -->
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="createOrderForm" class="modal-content bg-dark text-white border border-secondary">
      <div class="modal-header">
        <h5 class="modal-title">Create Order</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
            <label>User ID</label>
            <input type="number" class="form-control bg-dark text-white border-secondary" name="user_id" required>
        </div>

        <div class="mb-3">
            <label>Items</label>
            <div id="items-container">
                <div class="item-input mb-2">
                    <input type="number" class="form-control bg-dark text-white border-secondary mb-2" name="product_id[]" placeholder="Product ID" required>
                    <input type="number" class="form-control bg-dark text-white border-secondary mb-2" name="quantity[]" placeholder="Quantity" required>
                    <input type="number" class="form-control bg-dark text-white border-secondary" name="price[]" placeholder="Price" required>
                </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Create</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form id="editOrderForm" class="modal-content bg-dark text-white border border-secondary">
      <div class="modal-header">
        <h5 class="modal-title">Edit Order</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id">
        <div class="mb-3">
            <label>Status</label>
            <input type="text" class="form-control bg-dark text-white border-secondary" name="status">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-warning text-dark">Update</button>
      </div>
    </form>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
const API_URL = 'http://localhost:8001/api/orders';

function fetchOrders() {
    axios.get(API_URL)
        .then(response => {
            const orders = response.data;
            const list = document.getElementById('order-list');
            list.innerHTML = '';
            orders.forEach(order => {
                list.innerHTML += `
                    <div class="col-md-4">
                        <div class="card bg-secondary text-white shadow-lg border-0 rounded-4">
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">Order #${order.id}</h5>
                                <p class="card-text">
                                    <strong>User ID:</strong> ${order.user}<br>
                                    <strong>Total:</strong> Rp ${order.total_price}<br>
                                    <strong>Status:</strong> ${order.status}
                                </p>
                                <div class="d-flex justify-content-between">
                                    <button class="btn btn-sm btn-warning text-dark" onclick='openEditModal(${JSON.stringify(order)})'>✏️ Edit</button>
                                    <button class="btn btn-sm btn-danger" onclick='deleteOrder(${order.id})'>🗑️ Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
        })
        .catch(error => {
            console.error("Error fetching orders:", error);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Gagal memuat data order!'
            });
        });
}

// Create Order
document.getElementById('createOrderForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const json = {
        user: parseInt(formData.get('user_id')),
        items: []
    };

    const productIds = formData.getAll('product_id[]');
    const quantities = formData.getAll('quantity[]');
    const prices = formData.getAll('price[]');

    for (let i = 0; i < productIds.length; i++) {
        json.items.push({
            product_id: parseInt(productIds[i]),
            quantity: parseInt(quantities[i]),
            price: parseInt(prices[i])
        });
    }

    axios.post(API_URL, json)
        .then(response => {
            fetchOrders();
            bootstrap.Modal.getInstance(document.getElementById('createModal')).hide();
            this.reset();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Order berhasil dibuat!',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            console.error("Error creating order:", error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal membuat order',
                text: 'Periksa data dan coba lagi.'
            });
        });
});

// Open edit modal
function openEditModal(order) {
    const form = document.getElementById('editOrderForm');
    form.id.value = order.id;
    form.status.value = order.status;
    const modal = new bootstrap.Modal(document.getElementById('editModal'));
    modal.show();
}

// Update Order
document.getElementById('editOrderForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const id = this.id.value;
    const data = {
        status: this.status.value
    };

    axios.put(`${API_URL}/${id}`, data)
        .then(response => {
            fetchOrders();
            bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Status order berhasil diubah.',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            console.error("Error updating order:", error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal update',
                text: 'Terjadi kesalahan saat memperbarui order.'
            });
        });
});

// Delete Order
function deleteOrder(id) {
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Order akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`${API_URL}/${id}`)
                .then(() => {
                    fetchOrders();
                    Swal.fire({
                        icon: 'success',
                        title: 'Dihapus!',
                        text: 'Order berhasil dihapus.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                })
                .catch(error => {
                    console.error("Error deleting order:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal hapus',
                        text: 'Terjadi kesalahan saat menghapus order.'
                    });
                });
        }
    });
}

fetchOrders();
</script>
</body>
</html>
