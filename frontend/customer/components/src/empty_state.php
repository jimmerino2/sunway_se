<div id="empty-state" class="text-center d-none d-flex flex-column justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3 shadow-sm" style="width: 100px; height: 100px;">
        <i class="bi <?php echo $emptyIcon ?? 'bi-info-circle'; ?> display-4 text-secondary opacity-50"></i>
    </div>
    <h5 class="fw-bold text-dark"><?php echo $emptyTitle ?? 'Nothing here'; ?></h5>
    <p class="text-muted small"><?php echo $emptyMessage ?? 'This list is currently empty.'; ?></p>

    <a href="index.php" class="btn btn-secondary rounded-pill px-4 mt-2 fw-bold">
        Browse Menu
    </a>
</div>