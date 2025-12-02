<?php
// 1. Page Configuration
$pageTitle = "Menu Management | Cakeaway Admin";
$currentPage = "menu";
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'components/src/head.php'; ?>

<body class="sb-nav-fixed">

    <?php include 'components/src/top_nav.php'; ?>

    <div id="layoutSidenav">
        <?php include 'components/src/side_nav.php'; ?>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between align-items-center mt-4 mb-4">
                        <div>
                            <h1>Cakeaway Menu</h1>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item active">Manage your products</li>
                            </ol>
                        </div>
                        <button class="btn btn-primary" onclick="openAddModal()">
                            <i class="fas fa-plus me-2"></i>Add New Item
                        </button>
                    </div>

                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Fetching menu items...</p>
                    </div>

                    <!-- Menu Content Container -->
                    <div id="menuContainer" class="pb-5"></div>
                </div>
            </main>

            <?php include 'components/src/footer.php'; ?>
        </div>
    </div>

    <?php include 'components/src/modify_item_modal.html'; ?>

    <?php include 'components/src/scripts.php'; ?>

</body>

</html>