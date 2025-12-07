<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="components/js/user_log.js"></script>
<script src="components/js/password_toggle.js"></script>

<?php if (isset($currentPage)): ?>

    <?php if ($currentPage === 'login'): ?>
        <script src="components/js/login.js"></script>

    <?php elseif ($currentPage === 'Register'): ?>
        <script src="components/js/create_user.js"></script>

    <?php endif; ?>

<?php endif; ?>