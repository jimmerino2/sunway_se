    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-bottom">
            <div class="modal-content drawer-content">
                <div class="drawer-img-header">
                    <button type="button" class="btn btn-light rounded-circle position-absolute top-0 end-0 m-3 shadow-sm d-flex align-items-center justify-content-center" data-bs-dismiss="modal" style="width:35px; height:35px;">
                        <i class="bi bi-x-lg"></i>
                    </button>
                    <img id="edit-img" src="" class="drawer-img" onerror="this.src='https://dummyimage.com/600x400/dee2e6/6c757d.jpg&text=No+Image'">
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <h4 id="edit-name" class="fw-bold mb-0 text-dark" style="font-size: 1.4rem; line-height: 1.2;"></h4>
                        <span class="fs-5 fw-bold text-primary ms-3 text-nowrap">RM <span id="edit-price"></span></span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3">
                        <div class="qty-pill">
                            <button class="qty-btn text-dark" id="qty-minus"><i class="bi bi-dash"></i></button>
                            <input type="text" id="qty-input" class="qty-input" value="1" readonly>
                            <button class="qty-btn text-primary" id="qty-plus"><i class="bi bi-plus"></i></button>
                        </div>
                        <button id="btn-save-changes" class="btn btn-primary rounded-pill flex-grow-1 fw-bold shadow-sm" style="height: 50px;">Update</button>
                    </div>
                    <button id="btn-delete-item" class="btn btn-outline-danger w-100 rounded-pill mt-3 fw-bold border-0 bg-light text-danger">Remove Item</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="comfirmOrderModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-body text-center p-4">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-check-lg fs-2 text-success"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Confirm Order?</h5>
                    <p class="text-muted small mb-4">Your total is RM <span id="confirm-total"></span>. This will be sent to the kitchen immediately.</p>
                    <div class="d-flex gap-2">
                        <button class="btn btn-light flex-grow-1 rounded-pill fw-bold" data-bs-dismiss="modal">Cancel</button>
                        <button id="btn-final-submit" class="btn btn-dark flex-grow-1 rounded-pill fw-bold">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    </div>