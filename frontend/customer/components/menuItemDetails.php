<?php include 'toast.html'; ?>

<div
  class="modal fade"
  id="productModal"
  tabindex="-1"
  aria-labelledby="productModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Product Details</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body text-center">
        <img
          id="modalImage"
          src=""
          alt="Product Image"
          class="img-fluid rounded mb-3"
          style="max-height: 250px; object-fit: cover"
        />
        <h4 id="modalName" class="fw-bold"></h4>
        <p id="modalDescription" class="text-muted"></p>
        <p class="fw-bold">RM<span id="modalPrice"></span></p>

        <form id="modalAddForm" method="POST" class="mt-3">
          <input type="hidden" id="product_id" name="product_id" />
          <input type="hidden" id="product_name" name="product_name" />
          <input type="hidden" id="product_price" name="product_price" />
          <input type="hidden" id="product_image" name="product_image" />
          <input
            type="hidden"
            id="product_image_url"
            name="product_image_url"
          />
          <input
            type="hidden"
            name="quantity"
            id="modalQuantityHidden"
            value="1"
          />

          <div class="d-flex justify-content-center align-items-center mb-3">
            <button
              type="button"
              class="btn btn-outline-dark me-2"
              id="decreaseQty"
            >
              -
            </button>
            <input
              type="text"
              class="form-control text-center"
              style="width: 60px"
              id="modalQuantity"
              value="1"
              readonly
            />
            <button
              type="button"
              class="btn btn-outline-dark ms-2"
              id="increaseQty"
            >
              +
            </button>
          </div>

          <button type="button" class="btn btn-dark w-100" id="addToCartBtn">
            Add to Cart
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  const productModal = document.getElementById("productModal");
  const modalForm = document.getElementById("modalAddForm");

  // When modal opens, populate product details
  productModal.addEventListener("show.bs.modal", (event) => {
    const button = event.relatedTarget;
    document.getElementById("modalName").textContent =
      button.getAttribute("data-name");
    document.getElementById("modalDescription").textContent =
      button.getAttribute("data-description");
    document.getElementById("modalPrice").textContent = parseFloat(
      button.getAttribute("data-price")
    ).toFixed(2);
    document.getElementById("modalImage").src =
      button.getAttribute("data-image");

    // Fill hidden form fields
    document.getElementById("product_id").value =
      button.getAttribute("data-id");
    document.getElementById("product_name").value =
      button.getAttribute("data-name");
    document.getElementById("product_price").value =
      button.getAttribute("data-price");
    document.getElementById("product_image").value =
      button.getAttribute("data-image_url");
    document.getElementById("product_image_url").value =
      button.getAttribute("data-image");
    document.getElementById("modalQuantity").value = 1;
    document.getElementById("modalQuantityHidden").value = 1;
  });

  // Quantity increase
  document.getElementById("increaseQty").addEventListener("click", () => {
    let qty = parseInt(document.getElementById("modalQuantity").value);
    qty++;
    document.getElementById("modalQuantity").value = qty;
    document.getElementById("modalQuantityHidden").value = qty;
  });

  // Quantity decrease
  document.getElementById("decreaseQty").addEventListener("click", () => {
    let qty = parseInt(document.getElementById("modalQuantity").value);
    if (qty > 1) qty--;
    document.getElementById("modalQuantity").value = qty;
    document.getElementById("modalQuantityHidden").value = qty;
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", () => {
    const addToCartBtn = document.getElementById("addToCartBtn");

    addToCartBtn.addEventListener("click", () => {
      const id = document.getElementById("product_id").value;
      const name = document.getElementById("product_name").value;
      const price = document.getElementById("product_price").value;
      const quantity = document.getElementById("modalQuantityHidden").value;
      const image = document.getElementById("product_image").value;
      const image_url = document.getElementById("product_image_url").value;

      const tableNo = localStorage.getItem("table_no") ?? "1";
      const storedOrders = localStorage.getItem("orders_" + tableNo);
      let currentOrders = [];
      
      if (storedOrders) {
        try {
          currentOrders = JSON.parse(storedOrders);
          if (!Array.isArray(currentOrders)) {
            currentOrders = [];
          }
        } catch (e) {
          currentOrders = [];
        }
      }
      const orderIndex = currentOrders.length
      currentOrders.push({
        index: orderIndex,
        item_id: id,
        name: name,
        price: parseFloat(price),
        quantity: parseInt(quantity),
        image: image,
        image_url: image_url,
      });
      localStorage.setItem("orders_" + tableNo, JSON.stringify(currentOrders));
      localStorage.setItem("orders_" + tableNo + "_index", orderIndex + 1);

      showNotification("Order has been added to cart!");

      const cartCount = document.getElementById("cart_count");
      cartCount.textContent = currentOrders.length;
      localStorage.setItem("cart_count", currentOrders.length);
      const closeBtn = document.querySelector("#productModal .btn-close");
      if (closeBtn) closeBtn.click();
    });
  });
</script>
