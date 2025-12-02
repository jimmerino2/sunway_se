/**
 * menu.js
 * Handles Fetching, Creating, Updating, and Deleting Menu Items.
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

    // Setup Delete Confirm Listener
    const deleteBtn = document.getElementById('confirmDeleteBtn');
    if (deleteBtn) deleteBtn.addEventListener('click', executeDelete);

    // Initial Load
    await loadMenuData();
});

/**
 * 1. FETCH & RENDER
 */
async function loadMenuData() {
    const container = document.getElementById('menuContainer');
    const spinner = document.getElementById('loadingSpinner');

    if (spinner) spinner.style.display = 'block';
    if (container) container.innerHTML = '';

    try {
        const response = await getApiResponse(`${API_BASE}/item`);

        if (response && response.success) {
            allItems = response.data || [];
            extractCategories(allItems);
            populateCategorySelect();
            renderMenu(allItems);
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
    for (const [category, items] of Object.entries(grouped)) {
        const section = document.createElement('div');
        section.className = 'mb-5';

        let html = `
            <div class="border-bottom mb-3 d-flex align-items-center">
                <h4 class="text-secondary mb-2"><i class="fas fa-layer-group me-2"></i>${category}</h4>
                <span class="badge bg-light text-dark border ms-2 mb-2">${items.length}</span>
            </div>
            <div class="row">
        `;

        items.forEach(item => {
            // Handle image path logic
            let fullImgUrl = 'https://dummyimage.com/600x400/dee2e6/6c757d.jpg&text=No+Image';

            if (item.image_url) {
                // Remove leading slash if present to avoid double slashes with base
                const cleanPath = item.image_url.startsWith('/') ? item.image_url.substring(1) : item.image_url;
                fullImgUrl = `${STORAGE_BASE}/${cleanPath}`;
            }

            html += `
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm border-0 menu-card">
                        <div class="ratio ratio-4x3">
                            <img src="${fullImgUrl}" 
                                 class="card-img-top object-fit-cover" 
                                 alt="${item.name}"
                                 onerror="this.src='https://dummyimage.com/600x400/dee2e6/6c757d.jpg&text=Image+Error'">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0 fw-bold text-truncate" title="${item.name}">${item.name}</h6>
                                <span class="badge bg-success">RM ${parseFloat(item.price).toFixed(2)}</span>
                            </div>
                            <p class="card-text text-muted small flex-grow-1" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                ${item.desc || item.description || ''}
                            </p>
                            
                            <div class="mt-3 d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm flex-fill" onclick="openEditModal(${item.id})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                <button class="btn btn-outline-danger btn-sm flex-fill" onclick="openDeleteModal(${item.id}, '${item.name.replace(/'/g, "\\'")}')">
                                    <i class="fas fa-trash"></i>
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

// Helpers
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

    // Keep default option
    select.innerHTML = '<option value="" disabled selected>Select a category</option>';

    categoriesMap.forEach((name, id) => {
        const option = document.createElement('option');
        option.value = id;
        option.textContent = name;
        select.appendChild(option);
    });
}

/**
 * 2. MODAL & FORM HANDLERS
 */

// Global scope functions for HTML onclick attributes
window.openAddModal = function () {
    document.getElementById('itemForm').reset();
    document.getElementById('itemId').value = '';
    document.getElementById('itemModalLabel').innerText = 'Add New Item';
    document.getElementById('saveBtn').innerText = 'Create Item';

    // Clear any previous invalid classes
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
    // Handle potential field name difference (desc vs description)
    document.getElementById('itemDesc').value = item.desc || item.description || '';

    // Clear file input (cannot set value programmatically for security)
    document.getElementById('itemImage').value = '';

    document.getElementById('itemModalLabel').innerText = 'Edit Item';
    document.getElementById('saveBtn').innerText = 'Update Item';

    // Clear any previous invalid classes
    document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    if (itemModal) itemModal.show();
}

// Handle Form Submit
window.handleFormSubmit = async function (event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);
    const id = formData.get('id');
    const isEdit = !!id; // If ID exists, it's an update

    // Base URL is always /item. Logic is handled by _method or ID in backend.
    let url = `${API_BASE}/item`;

    // CRITICAL FIX: Add _method for Updates so index.php treats it as PATCH
    // We send POST physically (to allow file upload), but logically it's PATCH.
    if (isEdit) {
        formData.append('_method', 'PATCH');
    }

    try {
        // Disable button to prevent double submit
        const btn = document.getElementById('saveBtn');
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Saving...';

        // Always use POST to support file uploads
        const response = await sendFormData(url, 'POST', formData);

        if (response && (response.success || response.message)) {
            if (itemModal) itemModal.hide();
            await loadMenuData(); // Refresh list

            // Optional: Bootstrap Toast or simple alert
            // alert(isEdit ? "Item Updated!" : "Item Created!");
        } else {
            console.error("Server Error Response:", response);
            alert("Failed: " + (response.error || "Unknown server error"));
        }
    } catch (error) {
        console.error("Form Submit Error:", error);
        alert("Network Error: Check console for details. (Likely 500 error or CORS)");
    } finally {
        // Re-enable button
        const btn = document.getElementById('saveBtn');
        btn.disabled = false;
        btn.innerText = isEdit ? 'Update Item' : 'Create Item';
    }
}

/**
 * 3. DELETE LOGIC
 */
window.openDeleteModal = function (id, name) {
    itemToDeleteId = id;
    const nameEl = document.getElementById('deleteItemName');
    if (nameEl) nameEl.innerText = name;
    if (deleteModal) deleteModal.show();
}

window.executeDelete = async function () {
    if (!itemToDeleteId) return;

    try {
        // Delete endpoint: DELETE /item?id=123
        const url = `${API_BASE}/item?id=${itemToDeleteId}`;
        const response = await getApiResponse(url, 'DELETE');

        if (response && (response.success || response.message)) {
            if (deleteModal) deleteModal.hide();
            await loadMenuData();
        } else {
            alert("Failed to delete: " + (response.error || "Unknown error"));
        }
    } catch (error) {
        console.error("Delete Error:", error);
        alert("Error deleting item. Check console.");
    }
}

/**
 * 4. CUSTOM API HELPER FOR FORMDATA (FILES)
 */
async function sendFormData(url, method, formData) {
    const token = localStorage.getItem('authToken');

    const headers = {};
    if (token) {
        headers['Authorization'] = `Bearer ${token}`;
    }
    // Note: Content-Type is NOT set here; fetch does it automatically for FormData boundaries.

    const response = await fetch(url, {
        method: method,
        headers: headers,
        body: formData
    });

    // Handle non-JSON responses (like 404 HTML pages or 500 PHP errors) gracefully
    const text = await response.text();
    try {
        return JSON.parse(text);
    } catch (e) {
        console.error("Server returned non-JSON:", text);
        throw new Error("Server returned invalid JSON. Check console.");
    }
}