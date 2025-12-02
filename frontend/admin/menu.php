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

    <!-- 1. Add/Edit Item Modal -->
    <div class="modal fade" id="itemModal" tabindex="-1" aria-labelledby="itemModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="itemForm" onsubmit="handleFormSubmit(event)">
                    <div class="modal-header">
                        <h5 class="modal-title" id="itemModalLabel">Add New Item</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden ID for Edit Mode -->
                        <input type="hidden" id="itemId" name="id">

                        <div class="mb-3">
                            <label for="itemName" class="form-label">Item Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="itemName" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="itemPrice" class="form-label">Price (RM) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="itemPrice" name="price" required>
                        </div>

                        <div class="mb-3">
                            <label for="itemCategory" class="form-label">Category <span class="text-danger">*</span></label>
                            <select class="form-select" id="itemCategory" name="category_id" required>
                                <option value="" disabled selected>Select a category</option>
                                <!-- Populated by JS -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="itemDesc" class="form-label">Description</label>
                            <textarea class="form-control" id="itemDesc" name="desc" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="itemImage" class="form-label">Item Image</label>
                            <input class="form-control" type="file" id="itemImage" name="image" accept="image/png, image/jpeg, image/jpg">
                            <div class="form-text">Allowed: .png, .jpg, .jpeg</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn">Save Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 2. Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Delete Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <b id="deleteItemName">this item</b>?</p>
                    <p class="small text-muted">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/src/scripts.php'; ?>

</body>

</html>