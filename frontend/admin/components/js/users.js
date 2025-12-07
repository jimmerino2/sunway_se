// Global storage for the ID of the user being modified
let currentUserId = null;
let editModalInstance = null;

// Store initial non-password values when modal opens to check for changes
let initialFormState = {};

document.addEventListener('DOMContentLoaded', () => {
    fetchUsersData();
    setupDeleteConfirmation();
    setupEditLogic();
    setupFormChangeListener();
});

const API_URL = "http://localhost/software_engineering/backend/user";

async function fetchUsersData() {
    try {
        const response = await getApiResponse(API_URL, "GET");

        if (response && response.success && Array.isArray(response.data)) {
            // Keep only users that are not deactivated
            const activeUsers = response.data.filter(user => user.active == 1);

            const tableRows = activeUsers.map(user => {
                const roleMap = {
                    'A': '<span class="badge bg-danger">Admin</span>',
                    'K': '<span class="badge bg-warning text-dark">Kitchen</span>',
                    'C': '<span class="badge bg-info">Cashier</span>'
                };

                const actions = /*html*/`
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-success btn-sm me-2" onclick="editUser('${user.id}')" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-danger btn-sm ${user.id == 1 ? 'opacity-50' : ''}" 
                                onclick="window.confirmDeactivate('${user.id}')" 
                                title="${user.id == 1 ? 'System Protected' : 'Deactivate'}"
                                ${user.id == 1 ? 'disabled' : ''}>
                            <i class="fas fa-user-slash"></i>
                        </button>
                    </div>
                `;

                return [user.name, user.email, roleMap[user.role] || user.role, actions];
            });

            renderDataTable(tableRows);
        }
    } catch (error) {
        console.error("Fetch Error:", error);
    }
}

function renderDataTable(rows) {
    const tableElement = document.getElementById('datatablesUsers');
    if (tableElement && typeof simpleDatatables !== 'undefined') {
        new simpleDatatables.DataTable(tableElement, {
            data: {
                headings: ["Name", "Email", "Role", "Actions"],
                data: rows
            },
            columns: [
                { select: 0, sortable: true },
                { select: 1, sortable: true },
                { select: 2, cellClass: 'text-center' },
                { select: 3, sortable: false, searchable: false, cellClass: 'text-center' }
            ],
            perPage: 10
        });
    }
}

/**
 * Helper function to apply Bootstrap validation classes and feedback.
 */
function applyFeedback(element, isValid, message = '') {
    // Clear previous classes
    element.classList.remove('is-valid', 'is-invalid');

    // Find or create the feedback element
    let feedbackElement = element.parentNode.querySelector('.invalid-feedback');
    if (!feedbackElement) {
        feedbackElement = document.createElement('div');
        feedbackElement.classList.add('invalid-feedback');

        // Find the correct insertion point (after input or after container)
        let parentContainer = element.closest('.password-toggle-container') || element.closest('.mb-3') || element.closest('.mb-2');
        parentContainer.parentNode.insertBefore(feedbackElement, parentContainer.nextSibling);
    }

    if (isValid) {
        element.classList.add('is-valid');
        feedbackElement.textContent = '';
    } else {
        element.classList.add('is-invalid');
        feedbackElement.textContent = message;
    }
}

/**
 * Resets validation state for the edit form.
 */
function clearValidationFeedback() {
    const form = document.getElementById('editUserForm');
    if (form) {
        form.querySelectorAll('.form-control').forEach(input => {
            input.classList.remove('is-valid', 'is-invalid');
        });
        // Remove dynamically added feedback elements
        form.querySelectorAll('.invalid-feedback').forEach(feedback => {
            feedback.remove();
        });
    }
}

function setupModalEventCleanup() {
    const modalElement = document.getElementById('editUserModal');
    if (modalElement) {
        modalElement.addEventListener('hidden.bs.modal', clearValidationFeedback);
    }
}

/**
 * Checks if any form field (non-password or password) has changed.
 */
function checkFormChanges() {
    const name = document.getElementById('editName').value;
    const email = document.getElementById('editEmail').value;
    const oldPass = document.getElementById('oldPassword').value;
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmNewPassword').value;
    const saveBtn = document.getElementById('saveEditBtn');

    // 1. Check for basic profile changes
    const profileChanged = name !== initialFormState.name || email !== initialFormState.email;

    // 2. Check for password changes (requires all three fields to be filled)
    const passwordChanged = (oldPass || newPass || confirmPass);

    // The button should be enabled if EITHER the profile data changed OR the password section has any input
    const formAltered = profileChanged || passwordChanged;

    saveBtn.disabled = !formAltered;
}

/**
 * Sets up listeners on the form inputs to check for data changes.
 */
function setupFormChangeListener() {
    const form = document.getElementById('editUserForm');
    if (form) {
        form.addEventListener('input', checkFormChanges);
    }
}


/**
 * Logic to validate the form before saving changes.
 */
function validateEditForm() {
    let isValid = true;

    // --- 1. Get Elements ---
    const nameInput = document.getElementById('editName');
    const emailInput = document.getElementById('editEmail');
    const oldPassInput = document.getElementById('oldPassword');
    const newPassInput = document.getElementById('newPassword');
    const confirmPassInput = document.getElementById('confirmNewPassword');

    // --- 2. Validate Name ---
    if (!nameInput.value.trim()) {
        applyFeedback(nameInput, false, 'Name is required.');
        isValid = false;
    } else {
        applyFeedback(nameInput, true);
    }

    // --- 3. Validate Email ---
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailInput.value.trim()) {
        applyFeedback(emailInput, false, 'Email is required.');
        isValid = false;
    } else if (!emailRegex.test(emailInput.value)) {
        applyFeedback(emailInput, false, 'Enter a valid email address.');
        isValid = false;
    } else {
        applyFeedback(emailInput, true);
    }

    // --- 4. Validate Password Fields ---
    const oldPass = oldPassInput.value;
    const newPass = newPassInput.value;
    const confirmPass = confirmPassInput.value;
    const changingPassword = oldPass || newPass || confirmPass;

    // Reset password feedback first
    applyFeedback(oldPassInput, true);
    applyFeedback(newPassInput, true);
    applyFeedback(confirmPassInput, true);

    if (changingPassword) {
        // A. Current password required
        if (!oldPass) {
            applyFeedback(oldPassInput, false, 'Current password is required to change security settings.');
            isValid = false;
        }

        // B. New password match
        if (newPass !== confirmPass) {
            applyFeedback(newPassInput, false, 'New passwords must match.');
            applyFeedback(confirmPassInput, false, 'New passwords must match.');
            isValid = false;
        } else if (newPass && newPass.length < 6) {
            // C. New password length (only check if they provided a new password)
            applyFeedback(newPassInput, false, 'New password must be at least 6 characters.');
            isValid = false;
        }
    }

    return isValid;
}


/**
 * EDIT USER: Fetch individual user and prefill the centered modal.
 */
window.editUser = async function (userId) {
    currentUserId = userId;
    try {
        // FIX: Use ?id= to ensure backend routing works for single GET request
        const fetchUrl = `${API_URL}?id=${userId}`;
        const response = await getApiResponse(fetchUrl, "GET");

        // Logic check: The user object might be wrapped in .data or be the entire response object.
        let user = null;
        if (response && response.success && response.data) {
            user = response.data;
        } else if (response && response.id) {
            user = response;
        }

        if (user && user.id) {
            // Populate fields
            document.getElementById('editName').value = user.name || "";
            document.getElementById('editEmail').value = user.email || "";

            // --- Capture initial state ---
            initialFormState = {
                name: user.name || "",
                email: user.email || ""
            };
            // ---------------------------------

            // Reset password fields for security
            document.getElementById('oldPassword').value = "";
            document.getElementById('newPassword').value = "";
            document.getElementById('confirmNewPassword').value = "";

            // Disable button immediately until changes are made
            document.getElementById('saveEditBtn').disabled = true;

            // Clear all previous validation feedback
            clearValidationFeedback();

            // Reset eye icons and input types (Handled by password_toggle.js via DOMContentLoaded)

            if (!editModalInstance) {
                editModalInstance = new bootstrap.Modal(document.getElementById('editUserModal'));
            }
            editModalInstance.show();
        } else {
            console.error("Structure check failed. User object retrieved:", user);
            alert("Could not load user data. Check console for structure details.");
        }
    } catch (err) {
        console.error("Edit fetch error:", err);
        alert("Failed to reach server during user data retrieval.");
    }
};

/**
 * SAVE EDIT: Validates passwords before sending PATCH request.
 */
function setupEditLogic() {
    document.getElementById('saveEditBtn')?.addEventListener('click', async () => {

        if (!validateEditForm()) {
            return; // Stop if validation fails. Feedback is already displayed.
        }

        const name = document.getElementById('editName').value;
        const email = document.getElementById('editEmail').value;
        const oldPass = document.getElementById('oldPassword').value;
        const newPass = document.getElementById('newPassword').value;

        const payload = { id: currentUserId, name, email };

        // Triple-password verification logic (only include if passwords were provided)
        if (oldPass && newPass) {
            // We assume newPass matches confirmPass and is long enough because validateEditForm passed
            payload.old_password = oldPass;
            payload.password = newPass;
        }

        try {
            const res = await getApiResponse(`${API_URL}/${currentUserId}`, "PATCH", payload);
            if (res && res.success) {
                editModalInstance.hide();
                location.reload();
            } else {
                // If API update fails, it could be wrong old password or duplicate email
                alert("Update failed: " + (res.error || res.message || "Invalid current password or email already exists."));
            }
        } catch (error) {
            console.error("Update error:", error);
        }
    });
}

/**
 * DEACTIVATE: Soft-delete confirmation and server request.
 */
window.confirmDeactivate = (userId) => {
    // PREVENT DEACTIVATION OF ADMIN ID 1
    if (userId === "1" || userId === 1) {
        alert("System Error: The primary Administrator account (ID: 1) cannot be deactivated.");
        return;
    }

    currentUserId = userId;
    new bootstrap.Modal(document.getElementById('deleteUserModal')).show();
};

function setupDeleteConfirmation() {
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', async () => {
        try {
            const res = await getApiResponse(`${API_URL}/${currentUserId}`, "PATCH", {
                id: currentUserId,
                active: 0
            });

            if (res?.success) {
                location.reload();
            } else {
                alert("Account deactivation failed.");
            }
        } catch (err) {
            console.error("Deactivation error:", err);
        }
    });
}