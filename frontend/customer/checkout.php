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
    <link href="../css/customerDatatables.css" rel="stylesheet"> 
</head>

<body>
    <?php include 'components/header.html'?>

    <!-- Header -->
    <header class="bg-dark text-white text-center">
        <div class="container px-4 px-lg-5 my-5">
            <h1 class="display-5 fw-bolder">Checkout</h1>
            <p class="lead fw-normal text-white-50 mb-0">Review your items before confirming your order</p>
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
                        <th style="text-align:left" colspan="3">Total:</th>
                        <th style="text-align:right"></th>
                        <th></th> 
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div id="submitBtn" style="text-align: center; margin-top: 20px;">
            <button class="btn btn-outline-dark" style="max-width: 200px;"
                    data-bs-toggle="modal" data-bs-target="#submitOrderModal">
                Submit Order
            </button>
        </div>
    </section>


    <?php include 'components/footer.html'?>
</body>

<!-- Edit Modal -->
<div class="modal fade" id="changeStatusModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- Item Image -->
                <div class="text-center mb-3">
                    <img id="modalImage" src="" style="max-width: 200px; border-radius: 6px;">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Item Name</label>
                    <p id="modalItemName" class="mb-0"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Price</label>
                    <p id="modalPrice" class="mb-0"></p>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Quantity</label>
                    <input type="number" min="1" id="modalQuantity" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-success" id="saveChangesBtn" data-bs-dismiss="modal">
                    Save Changes
                </button>
            </div>

        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="removeOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title text-danger">Remove Order</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            Are you sure you want to remove:
            <strong id="removeItemName"></strong> ?
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button class="btn btn-danger" id="confirmRemoveBtn" data-bs-dismiss="modal">
            Remove
            </button>
        </div>
        </div>
    </div>
</div>

<!-- Submit Order Confirmation Modal -->
<div class="modal fade" id="submitOrderModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Confirm Submit</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            Are you sure you want to submit the order?
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-success" id="confirmSubmitBtn">Submit</button>
        </div>
        </div>
    </div>
</div>
</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="components/TableCheckout.js"></script>

<script>
const tableNo = localStorage.getItem("table_no");
const orders = JSON.parse(localStorage.getItem("orders_" + tableNo)) || [];
const submitBtn = document.getElementById('submitBtn');
if (orders.length === 0) {
    submitBtn.style.display = 'none';
} else {
    submitBtn.style.display = 'inline-block'; 
}

document.querySelector("#confirmSubmitBtn")?.addEventListener("click", async () => {
    const closeBtn = document.querySelector("#submitOrderModal .btn-close");
    if (closeBtn) closeBtn.click();

    try {
        for (const order of orders) {
            const orderData = {
                item_id: order.item_id,
                quantity: order.quantity,
                status: 'O',
                is_complete: 'N',
                order_time: new Date().toISOString(), 
                table_id: tableNo,
            };

            const response = await getApiResponse(
                "http://localhost/software_engineering/backend/orders",
                "POST",
                orderData
            );
        }

        localStorage.setItem('orders_' + tableNo, []); 
        localStorage.setItem('cart_count', 0); 

        showNotification('Your order has been successfully submitted.');
        setTimeout(() => {
            window.location.href = "index.php";
        }, 1000);

    } catch (error) {
        console.error("Error submitting orders:", error);
        showNotification('Failed to submit order. Please try again.');
    }
});
</script>