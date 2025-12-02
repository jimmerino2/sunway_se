<div class="modal fade" id="menuDetails" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-hero-img">
        <button type="button" class="btn-close-float" data-bs-dismiss="modal">
          <i class="bi bi-x-lg"></i>
        </button>
        <img id="modalImage" src="" class="product-img" alt="Product" onerror="this.src='https://dummyimage.com/600x400/dee2e6/6c757d.jpg&text=No+Image'">
      </div>

      <div class="modal-body-custom">

        <div class="info-row">
          <div class="info-name" id="modalName">Product Name</div>
          <div class="info-price">RM <span id="modalPrice">0.00</span></div>
        </div>

        <p class="info-desc" id="modalDescription">
          Description goes here...
        </p>

        <div class="action-row">
          <div class="qty-stepper">
            <button type="button" class="qty-btn" id="decreaseQty"><i class="bi bi-dash"></i></button>
            <input type="text" class="qty-val" id="modalQuantity" value="1" readonly>
            <button type="button" class="qty-btn" id="increaseQty" style="color: #0d6efd;"><i class="bi bi-plus"></i></button>
          </div>

          <button type="button" class="btn-add" id="addToCartBtn">
            Add to Order
          </button>
        </div>

      </div>
    </div>
  </div>
</div>