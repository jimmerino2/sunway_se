<nav class="navbar fixed-top bg-white border-bottom shadow-sm px-3" style="height: 60px; z-index: 1030;">
    <div class="d-flex justify-content-between align-items-center w-100">

        <?php if (isset($currentPage) && $currentPage === 'menu'): ?>
            <span class="fw-bold fs-4 text-primary" style="letter-spacing: -0.5px;">
                <i class="bi bi-cake2-fill me-1"></i>Cakeaway
            </span>
        <?php else: ?>
            <span class="fw-bold fs-4 text-dark">
                <?php echo isset($pageHeader) ? $pageHeader : 'Cakeaway'; ?>
            </span>
        <?php endif; ?>

        <span class="badge bg-light text-dark border rounded-pill fw-normal px-3 py-2">
            Table <span id="display-table-no">...</span>
        </span>
    </div>
</nav>