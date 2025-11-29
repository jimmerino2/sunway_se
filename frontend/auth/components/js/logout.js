document.addEventListener('DOMContentLoaded', function () {

    // Get the modal element itself
    const logoutModal = document.getElementById('logoutModal');

    if (logoutModal) {

        // Listen for the 'show.bs.modal' event
        // This event fires when the modal is *about* to be shown
        logoutModal.addEventListener('show.bs.modal', function (event) {

            console.log('Logout modal is opening. Clearing session...');

            // 1. Clear the stored token and username immediately
            localStorage.removeItem('authToken');
            localStorage.removeItem('username');

            // 2. Redirect to the login page after a short delay
            //    This gives the user a moment to see the "Logging out..." message
            //    so it doesn't just flash and disappear.
            setTimeout(function () {
                window.location.href = '/software_engineering/frontend/auth/login.php';
            }, 1500); // 1.5 second delay
        });
    }
});