<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/common.js"></script>
<?php include 'components/toast.html'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Cakeaway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
    <link href="../css/customer.css" rel="stylesheet"> 
    <link href="../css/customerDatatablesOrders.css" rel="stylesheet"> 
</head>

<body>
    <?php include 'components/header.html'?>

    <!-- Header -->
    <header class="bg-dark text-white text-center">
        <div class="container px-4 px-lg-5 my-5">
            <h1 class="display-5 fw-bolder">Orders</h1>
            <p class="lead fw-normal text-white-50 mb-0">See the items you have ordered as well as their status</p>
        </div>
    </header>

    <!-- Cart Items -->
    <section style="display: flex; flex-direction: column; flex-grow: 1; position: relative; padding: 20px;">
        <div id="container-parent" style="flex-grow: 1; overflow-y: auto;">
            <table id="table-order" style="width: 100%; border-collapse: collapse;">
                <thead id="table-order-header"></thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <th style="text-align:right" colspan="2">Total:</th>
                        <th style="text-align:right"></th>
                        <th style="text-align:right"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <?php include 'components/footer.html'?>
</body>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="components/TableOrders.js"></script>