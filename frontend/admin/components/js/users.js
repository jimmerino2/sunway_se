/**
 * Global storage for state management
 */
let currentUserId = null;
let editModalInstance = null;
let deactivateReactivateModalInstance = null;
let initialFormState = {};

const API_URL = "http://localhost/software_engineering/backend/user";

document.addEventListener('DOMContentLoaded', () => {
    fetchUsersData();
    setupDeactivateReactivateConfirmation();
    setupEditLogic();
    setupFormChangeListener();
});

/**
 * FETCH: Get all users and sanitize data to prevent the .toLowerCase() crash
 */
async function fetchUsersData() {
    try {
        const response = await getApiResponse(API_URL, "GET");

        if (response && response.success && Array.isArray(response.data)) {
            const tableRows = response.data.map(user => {
                const isActive = parseInt(user.active) === 1;

                // SANITIZATION: Ensure every value is a string. 
                // This prevents the "toLowerCase" error on null/undefined values.
                const userName = user.name ?? "";
                const userEmail = user.email ?? "";
                const userRoleValue = user.role ?? "";

                const roleMap = {
                    'A': '<span class="badge bg-danger">Admin</span>',
                    'K': '<span class="badge bg-warning text-dark">Kitchen</span>',
                    'C': '<span class="badge bg-info">Cashier</span>'
                };

                const roleBadge = roleMap[userRoleValue] || userRoleValue;

                // Define Actions HTML
                let actions = '';
                if (isActive) {
                    actions = `
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success btn-sm me-2" onclick="window.editUser('${user.id}')" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm ${user.id == 1 ? 'opacity-50' : ''}" 
                                    onclick="window.openDeactivateReactivateModal('${user.id}', false)" 
                                    title="${user.id == 1 ? 'System Protected' : 'Deactivate'}"
                                    ${user.id == 1 ? 'disabled' : ''}>
                                <i class="fas fa-user-slash"></i>
                            </button>
                        </div>`;
                } else {
                    actions = `
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-success btn-sm" 
                                    onclick="window.openDeactivateReactivateModal('${user.id}', true)" 
                                    title="Reactivate">
                                <i class="fas fa-user-plus"></i>
                            </button>
                        </div>`;
                }

                return [userName, userEmail, roleBadge, actions];
            });

            renderDataTable(tableRows);
        }
    } catch (error) {
        console.error("Fetch Error:", error);
    }
}

/**
 * RENDER: Using Event Listeners to force HTML persistence during Sort/Search
 */
function renderDataTable(rows) {
    const tableElement = document.getElementById('datatablesUsers');

    if (tableElement && tableElement.dataTableInstance) {
        tableElement.dataTableInstance.destroy();
    }

    if (tableElement && typeof simpleDatatables !== 'undefined') {
        const dataTable = new simpleDatatables.DataTable(tableElement, {
            data: {
                headings: ["Name", "Email", "Role", "Actions"],
                data: rows
            },
            columns: [
                { select: 0, sortable: true, type: "string" },
                { select: 1, sortable: true, type: "string" },
                { select: 2, cellClass: 'text-center' },
                {
                    select: 3,
                    sortable: false,
                    searchable: false,
                    cellClass: 'text-center'
                }
            ],
            perPage: 10
        });

        // RE-INJECT LOGIC: Force icons to appear after every table change
        const events = ["datatable.init", "datatable.page", "datatable.sort", "datatable.search"];
        events.forEach(event => {
            dataTable.on(event, () => reInjectIcons(dataTable));
        });

        tableElement.dataTableInstance = dataTable;
    }
}

/**
 * Helper to ensure the Actions column (Index 3) always renders HTML
 */
function reInjectIcons(dataTable) {
    const body = dataTable.dom.tBodies[0];
    if (!body) return;

    Array.from(body.rows).forEach(row => {
        const actionCell = row.cells[3];
        // If the library escaped the HTML (shows as text), convert it back to elements
        if (actionCell && actionCell.innerHTML.includes('&lt;')) {
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = actionCell.innerText;
            actionCell.innerHTML = tempDiv.innerHTML;
        }
    });
}

/**
 * MODAL: Edit User Logic
 */
window.editUser = async function (userId) {
    currentUserId = userId;
    try {
        const fetchUrl = `${API_URL}?id=${userId}`;
        const response = await getApiResponse(fetchUrl, "GET");
        let user = (response && response.success) ? response.data : response;

        if (user && user.id) {
            document.getElementById('editName').value = user.name || "";
            document.getElementById('editEmail').value = user.email || "";
            initialFormState = { name: user.name || "", email: user.email || "" };

            document.getElementById('oldPassword').value = "";
            document.getElementById('newPassword').value = "";
            document.getElementById('confirmNewPassword').value = "";
            document.getElementById('saveEditBtn').disabled = true;

            clearValidationFeedback();

            if (!editModalInstance) {
                editModalInstance = new bootstrap.Modal(document.getElementById('editUserModal'));
            }
            editModalInstance.show();
        }
    } catch (err) {
        console.error("Edit fetch error:", err);
    }
};

function setupEditLogic() {
    document.getElementById('saveEditBtn')?.addEventListener('click', async () => {
        if (!validateEditForm()) return;

        const payload = {
            id: currentUserId,
            name: document.getElementById('editName').value,
            email: document.getElementById('editEmail').value
        };

        const oldPass = document.getElementById('oldPassword').value;
        const newPass = document.getElementById('newPassword').value;

        if (oldPass && newPass) {
            payload.old_password = oldPass;
            payload.password = newPass;
        }

        try {
            const res = await getApiResponse(`${API_URL}/${currentUserId}`, "PATCH", payload);
            if (res?.success) {
                editModalInstance.hide();
                location.reload();
            } else {
                alert("Update failed: " + (res.message || "Email already exists."));
            }
        } catch (error) {
            console.error("Update error:", error);
        }
    });
}

/**
 * MODAL: Deactivate/Reactivate Logic
 */
window.openDeactivateReactivateModal = (userId, isReactivation) => {
    if (!isReactivation && userId == 1) {
        alert("System Error: Primary Admin cannot be deactivated.");
        return;
    }

    currentUserId = userId;
    const modalElement = document.getElementById('deleteUserModal');
    const modalTitle = modalElement.querySelector('#deleteModalLabel');
    const modalBody = modalElement.querySelector('.modal-body');
    const confirmButton = document.getElementById('confirmDeleteBtn');

    if (isReactivation) {
        modalTitle.textContent = "Confirm Reactivation";
        modalBody.innerHTML = "Are you sure you want to reactivate this account?";
        confirmButton.className = "btn btn-success";
        confirmButton.textContent = "Reactivate Account";
    } else {
        modalTitle.textContent = "Confirm Deactivation";
        modalBody.innerHTML = "Are you sure you want to deactivate this account?";
        confirmButton.className = "btn btn-danger";
        confirmButton.textContent = "Deactivate Account";
    }

    confirmButton.setAttribute('data-action-type', isReactivation ? 'reactivate' : 'deactivate');

    if (!deactivateReactivateModalInstance) {
        deactivateReactivateModalInstance = new bootstrap.Modal(modalElement);
    }
    deactivateReactivateModalInstance.show();
};

function setupDeactivateReactivateConfirmation() {
    document.getElementById('confirmDeleteBtn')?.addEventListener('click', async (e) => {
        const type = e.target.getAttribute('data-action-type');
        try {
            const res = await getApiResponse(`${API_URL}/${currentUserId}`, "PATCH", {
                id: currentUserId,
                active: type === 'reactivate' ? 1 : 0
            });

            if (res?.success) {
                deactivateReactivateModalInstance.hide();
                location.reload();
            }
        } catch (err) {
            console.error("Status update error:", err);
        }
    });
}

/**
 * FORM HELPERS
 */
function setupFormChangeListener() {
    document.getElementById('editUserForm')?.addEventListener('input', () => {
        const name = document.getElementById('editName').value;
        const email = document.getElementById('editEmail').value;
        const hasPass = document.getElementById('oldPassword').value || document.getElementById('newPassword').value;
        const changed = name !== initialFormState.name || email !== initialFormState.email || hasPass;
        document.getElementById('saveEditBtn').disabled = !changed;
    });
}

function validateEditForm() {
    let isValid = true;
    const nameInput = document.getElementById('editName');
    const emailInput = document.getElementById('editEmail');

    if (!nameInput.value.trim()) {
        applyFeedback(nameInput, false, 'Name is required.');
        isValid = false;
    } else applyFeedback(nameInput, true);

    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(emailInput.value)) {
        applyFeedback(emailInput, false, 'Invalid email.');
        isValid = false;
    } else applyFeedback(emailInput, true);

    return isValid;
}

function applyFeedback(element, isValid, message = '') {
    element.classList.toggle('is-invalid', !isValid);
    element.classList.toggle('is-valid', isValid);
}

function clearValidationFeedback() {
    document.querySelectorAll('#editUserForm .form-control').forEach(el => {
        el.classList.remove('is-valid', 'is-invalid');
    });
}