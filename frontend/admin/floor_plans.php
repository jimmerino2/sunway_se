<?php
$pageTitle = "Floor Plans | Cakeaway Admin";
$currentPage = "floor_plan";
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
                <div class="container-fluid my-4">

                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Floor plan</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Manage all Customer tables</li>
                        </ol>

                        <ul class="nav nav-tabs" id="floorTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="floor1-tab" data-bs-toggle="tab"
                                    data-bs-target="#floor1" type="button" role="tab">Ground Floor</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="floor2-tab" data-bs-toggle="tab" data-bs-target="#floor2"
                                    type="button" role="tab">Second Floor</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="floorTabsContent">
                            <div class="tab-pane fade show active" id="floor1" role="tabpanel">
                                <div class="floor-container">
                                    <h5 class="text-center mb-3">Ground Floor Layout</h5>
                                    <div class="Building_frame">
                                        <div class="row d-flex h-100">
                                            <div class="col-md-3 d-flex flex-column">
                                                <h6><i class="fas fa-users me-2"></i> Private Room</h6>
                                                <div class="room d-flex flex-column" id="private-room-container"></div>
                                                <div class="d-flex row flex-grow-1">
                                                    <div class="d-flex flex-column col-md-6">
                                                        <h6><i class="fas fa-restroom me-2"></i> Facilities</h6>
                                                        <div class="room restroom flex-grow-1">Restrooms</div>
                                                    </div>
                                                    <div class="d-flex flex-column col-md-6">
                                                        <h6><i class="fas fa-cash-register me-2"></i> Service</h6>
                                                        <div class="room counter" style="height: 100px;">ORDER HERE</div>
                                                        <h6><i class="fas fa-fire-burner me-2"></i> Kitchen</h6>
                                                        <div class="room kitchen" style="height: 150px;">STAFF ONLY</div>
                                                    </div>
                                                </div>
                                                <div class="room" style="height: 80px; margin-top: auto;">
                                                    <i class="fas fa-stairs me-2"></i> Stairs
                                                </div>
                                            </div>
                                            <div class="col-md-9 d-flex flex-column">
                                                <h6><i class="fas fa-laptop me-2"></i> Solo Work Bar</h6>
                                                <div class="bar-seating-horizontal mb-3">
                                                    <div class="bar-table-horizontal" id="solo-bar-container"></div>
                                                </div>
                                                <h6><i class="fas fa-users me-2"></i> Group Work</h6>
                                                <div class="seating-zone h-100" id="group-work-container"></div>
                                                <h6><i class="fas fa-couch me-2"></i> Lounge Seating</h6>
                                                <div class="seating-zone" id="lounge-seating-container"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="floor2" role="tabpanel">
                                <div class="floor-container">
                                    <h5 class="text-center mb-3">Rooftop Layout</h5>
                                    <div class="Building_frame">
                                        <div class="row d-flex h-100">
                                            <div class="d-flex flex-column">
                                                <h6><i class="fas fa-glass-martini me-2"></i> Mini Bar</h6>
                                                <div class="room mini-bar">Service</div>
                                                <div class="bar-seating-horizontal mb-3">
                                                    <div class="bar-table-horizontal" id="mini-bar-container"></div>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <h6><i class="fas fa-cloud-sun me-2"></i> Open Dining</h6>
                                                <div class="seating-zone" id="open-dining-container"></div>
                                            </div>
                                            <div class="row d-flex h-100 mt-2">
                                                <div class="col-md-3 d-flex flex-column">
                                                    <div class="room" style="height: 80px;">
                                                        <i class="fas fa-stairs me-2"></i> Stairs
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <?php include 'components/src/clear_table_modal.html'; ?>

    <?php include 'components/src/scripts.php'; ?>
</body>

</html>