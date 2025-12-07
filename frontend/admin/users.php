<?php
// 1. Page Configuration
$pageTitle = "Users Management | Cakeaway Admin"; // Updated page title
$currentPage = "users";
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
                <!-- Adopted wrapper style from orders.php -->
                <div class="container-fluid px-4">
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Users</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Manage all registered user accounts</li>
                        </ol>
                        <div class="card mb-4 mt-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i> User List
                            </div>
                            <div class="card-body">
                                <table id="datatablesUsers" class="table table-striped">
                                    <thead>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php include 'components/src/footer.php'; ?>
        </div>
    </div>
    <?php include 'components/src/modify_users_modal.html' ?>
    <?php include 'components/src/scripts.php'; ?>

</body>

</html>