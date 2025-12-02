/**
 * menu.js
 * Handles Fetching, Creating, Updating, and Deleting Menu Items (Admin View).
 */

// Configuration
const API_BASE = 'http://localhost/software_engineering/backend';
const STORAGE_BASE = 'http://localhost/software_engineering/backend/public/storage';

// State
let allItems = [];
let categoriesMap = new Map();
let itemModal = null;
let deleteModal = null;
let itemToDeleteId = null;

document.addEventListener('DOMContentLoaded', async () => {
    // Initialize Modals (Bootstrap 5)
    const itemModalEl = document.getElementById('itemModal');
    const deleteModalEl = document.getElementById('deleteModal');

    if (itemModalEl) itemModal = new bootstrap.Modal(itemModalEl);
    if (deleteModalEl) deleteModal = new bootstrap.Modal(deleteModalEl);

    // Setup Status Change Confirm Listener (Reusing delete modal/button for status change)
    const deleteBtn = document.getElementById('confirmDeleteBtn');
    if (deleteBtn) deleteBtn.addEventListener('click', executeStatusChange);

    // Initial Load
    await loadMenuData();
});

// --- API HELPERS ---

// General-purpose API fetcher for GET/DELETE (No body required, returns JSON)
async function getApiResponse(url, method = 'GET') {
    const token = localStorage.getItem('authToken');
    const headers = {};
    if (token) headers['Authorization'] = `Bearer ${token}`;

    try {
        const response = await fetch(url, { method, headers });
        const text = await response.text();

        // Check for server-side errors before trying to parse
        if (!response.ok) {
            console.error(`API Error (${response.status} ${response.statusText}):`, text);
            try {
                const json = JSON.parse(text);
                return { success: false, error: json.error || `Server Error: ${response.status}` };
            } catch (e) {
                return { success: false, error: `Server Error: ${response.status}. Check console for details.` };
            }
        }

        // Success response
        return JSON.parse(text);

    } catch (error) {
        console.error("Network or Parsing Error:", error);
        return { success: false, error: `Network error: ${error.message}` };
    }
}

// Custom API helper for POST/PATCH (Handles FormData/Files)
async function sendFormData(url, method, formData) {
    const token = localStorage.getItem('authToken');
    const headers = {};
    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }

    const response = await fetch(url, {
        method: method,
        headers: headers,
        body: formData
    });

    const text = await response.text();

    if (!response.ok) {
        console.error(`Server Error (${response.status} ${response.statusText}):`, text);
        try {
            return JSON.parse(text);
        } catch (e) {
            return { success: false, error: `Server Error: ${response.status}. Check console for details.` };
        }
    }

    try {
        return JSON.parse(text);
    } catch (e) {
        console.error("Server returned non-JSON on success:", text);
        return { success: true, message: "Operation completed." };
    }
}


// --- FETCH & RENDER ---

async function loadMenuData() {
    const container = document.getElementById('menuContainer');
    const spinner = document.getElementById('loadingSpinner');

    if (spinner) spinner.style.display = 'block';
    if (container) container.innerHTML = '';

    try {
        const response = await getApiResponse(`${API_BASE}/item`);

        // Define the data array to check:
        let dataArray = response;

        // 🌟 FIX: Extract the item array from the 'data' key if the response is wrapped.
        if (response && typeof response === 'object' && response.data) {
            dataArray = response.data;
        }

        if (Array.isArray(dataArray)) {
            allItems = dataArray; // Use the extracted array
            extractCategories(allItems);
            populateCategorySelect();
            renderMenu(allItems);
        } else if (response && response.error) {
            if (container) container.innerHTML = `<div class="alert alert-danger">Error loading menu: ${response.error}</div>`;
        } else {
            if (container) container.innerHTML = `<div class="alert alert-warning">No items found.</div>`;
        }
    } catch (error) {
        console.error("Load Error:", error);
        if (container) container.innerHTML = `<div class="alert alert-danger">Error loading menu. Check console for details.</div>`;
    } finally {
        if (spinner) spinner.style.display = 'none';
    }
}

function renderMenu(items) {
    const container = document.getElementById('menuContainer');
    if (!container) return;

    // Group by Category
    const grouped = items.reduce((acc, item) => {
        const cat = item.category_name || 'Uncategorized';
        if (!acc[cat]) acc[cat] = [];
        acc[cat].push(item);
        return acc;
    }, {});

    // Generate HTML
    container.innerHTML = '';
    for (const [category, items] of Object.entries(grouped)) {
        const section = document.createElement('div');
        section.className = 'mb-5';

        let html = `
            <div class="border-bottom mb-3 d-flex align-items-center">
                <h4 class="text-secondary mb-2"><i class="fas fa-layer-group me-2"></i>${category}</h4>
                <span class="badge bg-light text-dark border ms-2 mb-2">${items.length} total</span>
            </div>
            <div class="row">
        `;

        items.forEach(item => {
            let fullImgUrl = 'https://dummyimage.com/600x400/dee2e6/6c757d.jpg&text=No+Image';
            if (item.image_url) {
                const cleanPath = item.image_url.startsWith('/') ? item.image_url.substring(1) : item.image_url;
                fullImgUrl = `${STORAGE_BASE}/${cleanPath}`;
            }

            // Determine active status and styling for Admin View
            const isActive = item.active == 1;
            const statusBadge = isActive
                ? `<span class="badge bg-success ms-2">Active</span>`
                : `<span class="badge bg-warning text-dark ms-2">Inactive</span>`;

            const cardClass = isActive ? 'shadow-sm' : 'shadow-none border border-warning opacity-75';
            const statusAction = isActive ? 'Deactivate' : 'Reactivate';
            const statusButtonClass = isActive ? 'btn-outline-danger' : 'btn-outline-success';
            const statusButtonIcon = isActive ? 'fas fa-trash' : 'fas fa-redo';

            html += `
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 ${cardClass} border-0 menu-card">
                        <div class="ratio ratio-4x3">
                            <img src="${fullImgUrl}" 
                                 class="card-img-top object-fit-cover" 
                                 alt="${item.name}"
                                 onerror="this.src='https://dummyimage.com/600x400/dee2e6/6c757d.jpg&text=Image+Error'">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0 fw-bold text-truncate" title="${item.name}">${item.name}</h6>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-success">RM ${parseFloat(item.price).toFixed(2)}</span>
                                    ${statusBadge}
                                </div>
                            </div>
                            <p class="card-text text-muted small flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                ${item.description || ''}
                            </p>
                            
                            <div class="mt-3 d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm flex-fill" onclick="openEditModal(${item.id})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn ${statusButtonClass} btn-sm flex-fill" 
                                        onclick="openStatusModal(${item.id}, '${item.name.replace(/'/g, "\\'")}', ${isActive})">
                                    <i class="${statusButtonIcon}"></i> ${statusAction}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        html += `</div>`;
        section.innerHTML = html;
        container.appendChild(section);
    }
}

function extractCategories(items) {
    categoriesMap.clear();
    items.forEach(item => {
        if (item.category_id && item.category_name) {
            categoriesMap.set(item.category_id, item.category_name);
        }
    });
}

function populateCategorySelect() {
    const select = document.getElementById('itemCategory');
    if (!select) return;

    select.innerHTML = '<option value="" disabled selected>Select a category</option>';
    const sortedCategories = Array.from(categoriesMap.entries()).sort((a, b) => a[1].localeCompare(b[1]));

    sortedCategories.forEach(([id, name]) => {
        const option = document.createElement('option');
        option.value = id;
        option.textContent = name;
        select.appendChild(option);
    });
}

// --- MODAL & FORM HANDLERS (Create/Update) ---

window.openAddModal = function () {
    document.getElementById('itemForm').reset();
    document.getElementById('itemId').value = '';
    document.getElementById('itemModalLabel').innerText = 'Add New Item';
    document.getElementById('saveBtn').innerText = 'Create Item';
    document.getElementById('itemImage').required = true;
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    if (itemModal) itemModal.show();
}

window.openEditModal = function (id) {
    const item = allItems.find(i => i.id == id);
    if (!item) return;

    document.getElementById('itemId').value = item.id;
    document.getElementById('itemName').value = item.name;
    document.getElementById('itemPrice').value = item.price;
    document.getElementById('itemCategory').value = item.category_id;
    document.getElementById('itemDesc').value = item.description || '';

    document.getElementById('itemImage').value = '';
    document.getElementById('itemImage').required = false;

    document.getElementById('itemModalLabel').innerText = 'Edit Item';
    document.getElementById('saveBtn').innerText = 'Update Item';
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    if (itemModal) itemModal.show();
}

window.handleFormSubmit = async function (event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const id = formData.get('id');
    const isEdit = !!id;

    // Basic client-side validation
    // FIX: 'desc' is the name of the textarea in menu.php
    const requiredFields = ['name', 'price', 'category_id', 'desc'];
    let isValid = true;
    requiredFields.forEach(fieldName => {
        // Find the input element by its 'name' attribute
        const inputEl = form.elements[fieldName];
        const value = inputEl ? inputEl.value : formData.get(fieldName); // Get value from input or formData

        if (!value) {
            // Check if inputEl exists before accessing classList
            if (inputEl) inputEl.classList.add('is-invalid');
            isValid = false;
        } else {
            if (inputEl) inputEl.classList.remove('is-invalid');
        }
    });

    if (!isEdit && document.getElementById('itemImage').files.length === 0) {
        document.getElementById('itemImage').classList.add('is-invalid');
        isValid = false;
    } else if (isEdit) {
        document.getElementById('itemImage').classList.remove('is-invalid');
    }

    if (!isValid) {
        alert("Please fill out all required fields and upload an image (for new items).");
        return;
    }

    // FIX: Use 'desc' key to get the value, and append it as 'description' 
    // which the backend ItemController expects.
    formData.append('description', formData.get('desc'));
    formData.delete('desc');

    let url = `${API_BASE}/item`;

    try {
        const btn = document.getElementById('saveBtn');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Saving...';

        if (isEdit) {
            formData.append('_method', 'PATCH');
        }

        const response = await sendFormData(url, 'POST', formData);

        if (response && (response.success || response.message)) {
            console.log("Operation Success:", response);
            if (itemModal) itemModal.hide();
            await loadMenuData();
            alert(response.message || (isEdit ? "Item Updated!" : "Item Created!"));
        } else {
            console.error("Server Error Response:", response);
            alert("Operation Failed: " + (response.error || "Unknown server error"));
        }
    } catch (error) {
        console.error("Form Submit Error:", error);
        alert("Fatal Error: Check console for network or parsing errors.");
    } finally {
        const btn = document.getElementById('saveBtn');
        btn.disabled = false;
        btn.innerHTML = isEdit ? 'Update Item' : 'Create Item';
    }
}

// --- STATUS CHANGE LOGIC (Soft Delete/Reactivate) ---

window.openStatusModal = function (id, name, isActive) {
    itemToDeleteId = id;
    const nameEl = document.getElementById('deleteItemName');
    const action = isActive ? 'deactivate' : 'reactivate';

    if (nameEl) nameEl.innerHTML = `Are you sure you want to ${action} ${name} from the user menu?`;

    const confirmBtn = document.getElementById('confirmDeleteBtn');
    if (confirmBtn) {
        confirmBtn.innerText = action.charAt(0).toUpperCase() + action.slice(1);
        confirmBtn.className = `btn ${isActive ? 'btn-danger' : 'btn-success'}`;
        // Store the target active status (0 for deactivate, 1 for reactivate)
        confirmBtn.setAttribute('data-target-active', isActive ? '0' : '1');
    }

    if (deleteModal) deleteModal.show();
}

window.executeStatusChange = async function () {
    if (!itemToDeleteId) return;

    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const targetActiveStatus = confirmBtn.getAttribute('data-target-active');

    if (targetActiveStatus === null) return;

    try {
        const actionMessage = targetActiveStatus === '0' ? 'deactivate' : 'reactivate';

        // 1. If targetActiveStatus is '0', we trigger the dedicated DELETE endpoint 
        // which the ItemController maps to soft deletion (active=0).
        if (targetActiveStatus === '0') {
            const deleteUrl = `${API_BASE}/item?id=${itemToDeleteId}`;
            const response = await getApiResponse(deleteUrl, 'DELETE');

            if (response && (response.success || response.message)) {
                console.log("Deactivation Success:", response);
                if (deleteModal) deleteModal.hide();
                await loadMenuData();
                alert(`Item successfully ${actionMessage}d.`);
            } else {
                console.error("Deactivation Error:", response);
                alert(`Failed to ${actionMessage} item: ` + (response.error || "Unknown error"));
            }

        } else {
            // 2. If targetActiveStatus is '1', we trigger the PATCH endpoint (Reactivate)
            const url = `${API_BASE}/item`;
            const formData = new FormData();
            formData.append('id', itemToDeleteId);
            formData.append('active', targetActiveStatus);
            // This relies on the _method PATCH override being added to index.php
            formData.append('_method', 'PATCH');

            const response = await sendFormData(url, 'POST', formData);

            if (response && (response.success || response.message)) {
                console.log("Reactivation Success:", response);
                if (deleteModal) deleteModal.hide();
                await loadMenuData();
                alert(`Item successfully ${actionMessage}d.`);
            } else {
                console.error("Reactivation Error:", response);
                alert(`Failed to ${actionMessage} item: ` + (response.error || "Unknown error"));
            }
        }
    } catch (error) {
        console.error("Status Change Error:", error);
        alert("Error changing item status. Check console.");
    }
}