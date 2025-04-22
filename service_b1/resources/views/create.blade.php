<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Create Order</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

  <h2>Create Order</h2>

  <form id="orderForm">
    <input type="number" id="user_id" placeholder="User ID" required><br><br>

    <h4>Item:</h4>
    <input type="number" id="product_id" placeholder="Product ID" required><br>
    <input type="number" id="quantity" placeholder="Quantity" required><br>
    <input type="number" id="price" placeholder="Price" required><br><br>

    <button type="submit">Submit Order</button>
  </form>

  <script>
    document.getElementById("orderForm").addEventListener("submit", function(e) {
      e.preventDefault();

      const orderData = {
        user: parseInt(document.getElementById("user_id").value),
        items: [
          {
            product_id: parseInt(document.getElementById("product_id").value),
            quantity: parseInt(document.getElementById("quantity").value),
            price: parseInt(document.getElementById("price").value)
          }
        ]
      };

      axios.post("http://localhost:8001/api/orders", orderData)
        .then(response => {
          alert("Order created successfully!");
          console.log(response.data);
        })
        .catch(error => {
          console.error(error.response.data);
          alert("Failed to create order");
        });
    });
  </script>

</body>
</html>
