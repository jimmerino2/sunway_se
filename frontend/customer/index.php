<?php
$pageTitle = "Menu | Cakeaway";
$currentPage = "menu";
$paddingTop = "115px";
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'components/src/head.php'; ?>

<body>
    <?php include 'components/src/top_nav.php'; ?>

    <div class="bg-white border-bottom fixed-top py-2 px-3 category-scroll d-flex gap-2" style="top: 60px; z-index: 1020;">
        <button class="btn btn-sm btn-dark rounded-pill px-4 category-btn fw-bold shadow-sm" data-id="" onclick="filterGenre(this, '')">All</button>
        <div id="category-container" class="d-flex gap-2"></div>
    </div>

    <div class="container px-3">
        <div id="container-item" class="d-flex flex-column gap-3">
            <div class="text-center py-5 mt-4">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="text-muted small mt-2">Loading menu...</p>
            </div>
        </div>
    </div>

    <?php include 'components/src/bottom_nav.php'; ?>
    <?php include 'components/src/toast.html'; ?>
    <?php include 'components/src/menuDetails_modal.php'; ?>

    <?php include 'components/src/scripts.php'; ?>
    <script src="components/js/index.js"></script>
</body>

</html>