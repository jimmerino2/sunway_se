<?php
// 1. Page Configuration
$pageTitle = "Dashboard | Cakeaway Admin";
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Users</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Configure user settings</li>
                    </ol>


                </div>
            </main>

            <?php include 'components/src/footer.php'; ?>
        </div>
    </div>

    <?php include 'components/src/scripts.php'; ?>

</body>

</html>