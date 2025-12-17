floor_plans<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="components/js/sidebartoggle.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
<script src="components/js/api.js"></script>

<?php if (isset($currentPage)): ?>

    <?php if ($currentPage === 'floor_plans'): ?>
        <script src="components/js/floor_plans.js"></script>

    <?php elseif ($currentPage === 'dashboard'): ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <script src="components/js/Order-rates-per-day.js"></script>
        <script src="components/js/Monthly-income-Bar.js"></script>
        <script src="components/js/datatables-order-list.js"></script>
        <script src="components/js/today_income.js"></script>
        <script src="components/js/available_table.js"></script>
        <script src="components/js/completed_orders_today.js"></script>
        <script src="components/js/pending_orders_today.js"></script>

    <?php elseif ($currentPage === 'orders'): ?>
        <script src="components/js/datatables-order-list.js"></script>

    <?php elseif ($currentPage === 'menu'): ?>
        <script src="components/js/menu.js"></script>

    <?php elseif ($currentPage === 'users'): ?>
        <script src="components/js/users.js"></script>
        <script src="../auth/components/js/password_toggle.js"></script>

    <?php endif; ?>

<?php endif; ?>