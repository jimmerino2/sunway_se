/**
 * index.js
 * Logic for Menu, Product Modal, and Add to Cart.
 */

// Store current item details being viewed in the modal
let currentModalItem = {
    id: null,
    name: "",
    price: 0,
    image: "",
    image_url: "",
    quantity: 1
};

document.addEventListener('DOMContentLoaded', () => {
    // 1. Setup Table from URL
    const urlParams = new URLSearchParams(window.location.search);
    const urlTable = urlParams.get('table_no');

    if (urlTable) {
        TableManager.set(urlTable);
        window.history.replaceState({}, document.title, window.location.origin + window.location.pathname);
    }

    // 2. Initialize Data
    loadCategories();
    loadItems(); // Initial load fetches only active items

    // 3. Setup Modal Event Listeners
    setupModalLogic();

    // 4. Badge Polling
    setInterval(() => CartNotification.update(), 1000);
});

// --- API & RENDER LOGIC ---

async function loadCategories() {
    const container = document.getElementById('category-container');
    if (!container) return;

    try {
        const res = await getApiResponse('http://localhost/software_engineering/backend/category');
        if (res && res.data) {
            res.data.forEach(cat => {
                const btn = document.createElement('button');
                btn.className = 'btn btn-sm btn-outline-dark rounded-pill px-3 category-btn text-nowrap border-0 bg-white fw-medium';
                btn.textContent = cat.name;
                btn.onclick = () => filterGenre(btn, cat.id);
                container.appendChild(btn);
            });
        }
    } catch (err) {
        console.error("Cat Load Error:", err);
    }
}

async function loadItems(categoryId = '') {
    const container = document.getElementById('container-item');
    if (!container) return;

    container.innerHTML = `<div class="text-center py-5"><div class="spinner-border text-primary"></div><div class="small mt-2">Loading...</div></div>`;

    // START: Specific URL requested
    let url = 'http://localhost/software_engineering/backend/item?active=1';

    // Conditionally append category_id using '&'
    if (categoryId) {
        url += `&category_id=${categoryId}`;
    }
    // END: Specific URL requested

    try {
        const res = await getApiResponse(url);
        container.innerHTML = '';

        if (res && res.data && res.data.length > 0) {
            res.data.forEach(item => {
                container.appendChild(renderMobileItemCard(item));
            });
        } else {
            container.innerHTML = `<div class="text-center py-5 text-muted"><h6>No Items Found</h6></div>`;
        }
    } catch (err) {
        console.error("Item Load Error:", err);
        container.innerHTML = `<div class="text-center text-danger py-4">Failed to load data.</div>`;
    }
}

function filterGenre(activeBtn, id) {
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.classList.remove('btn-dark', 'text-white', 'shadow-sm');
        btn.classList.add('btn-outline-dark', 'bg-white', 'border-0');
    });
    activeBtn.classList.remove('btn-outline-dark', 'bg-white', 'border-0');
    activeBtn.classList.add('btn-dark', 'text-white', 'shadow-sm');

    loadItems(id);
}

function renderMobileItemCard(item) {
    const prefix = '../../backend/public/storage';
    const rawImage = item.image_url || '';
    const finalSrc = rawImage ? (prefix + rawImage) : 'https://dummyimage.com/100x100/dee2e6/6c757d.jpg&text=No+Img';

    const div = document.createElement('div');
    div.className = 'card item-card p-2 bg-white mb-0 position-relative shadow-sm border-0';
    div.style.cursor = 'pointer';
    div.dataset.bsToggle = 'modal';
    div.dataset.bsTarget = '#menuDetails';

    // Store data in attributes to be read by the modal listener
    div.dataset.id = item.id;
    div.dataset.name = item.name;
    div.dataset.price = item.price;
    div.dataset.description = item.description || '';
    div.dataset.image = finalSrc;
    div.dataset.image_url = rawImage; // Keep raw for backend ref

    div.innerHTML = `
        <div class="d-flex align-items-center">
            <div class="flex-shrink-0"><img src="${finalSrc}" class="rounded-3" style="width:90px; height:90px; object-fit:cover;"></div>
            <div class="flex-grow-1 ms-3" style="min-width:0;">
                <h6 class="mb-1 fw-bold text-truncate">${item.name}</h6>
                <p class="mb-2 text-secondary small text-truncate">${item.description || 'Tasty item'}</p>
                <div class="d-flex justify-content-between align-items-end">
                    <span class="fw-bold">RM ${parseFloat(item.price).toFixed(2)}</span>
                    <div class="btn btn-sm btn-light border rounded-circle text-primary" style="width:32px; height:32px; display:flex; align-items:center; justify-content:center;"><i class="bi bi-plus-lg"></i></div>
                </div>
            </div>
        </div>
    `;
    return div;
}

// --- MODAL & ADD TO CART LOGIC ---

function setupModalLogic() {
    const menuDetails = document.getElementById("menuDetails");
    const qtyInput = document.getElementById("modalQuantity");

    // 1. ON OPEN: Populate Data
    menuDetails.addEventListener("show.bs.modal", (event) => {
        const button = event.relatedTarget;

        // Reset State
        currentModalItem = {
            id: button.getAttribute("data-id"),
            name: button.getAttribute("data-name"),
            price: parseFloat(button.getAttribute("data-price")),
            image: button.getAttribute("data-image"),
            image_url: button.getAttribute("data-image_url"),
            quantity: 1
        };

        // Update UI
        document.getElementById("modalName").textContent = currentModalItem.name;
        document.getElementById("modalDescription").textContent = button.getAttribute("data-description") || "No description.";
        document.getElementById("modalImage").src = currentModalItem.image;
        qtyInput.value = 1;

        updateModalPriceDisplay();
    });

    // 2. Quantity Controls
    document.getElementById("increaseQty").onclick = () => {
        currentModalItem.quantity++;
        qtyInput.value = currentModalItem.quantity;
        updateModalPriceDisplay();
    };

    document.getElementById("decreaseQty").onclick = () => {
        if (currentModalItem.quantity > 1) {
            currentModalItem.quantity--;
            qtyInput.value = currentModalItem.quantity;
            updateModalPriceDisplay();
        }
    };

    // 3. ADD TO CART CLICK
    document.getElementById("addToCartBtn").onclick = () => {
        addToCart();

        // Close Modal
        const modalInstance = bootstrap.Modal.getInstance(menuDetails);
        if (modalInstance) modalInstance.hide();
    };
}

function updateModalPriceDisplay() {
    const total = (currentModalItem.price * currentModalItem.quantity).toFixed(2);
    document.getElementById("modalPrice").textContent = total;
}

function addToCart() {
    const tableNo = TableManager.get();
    const storedOrders = localStorage.getItem("orders_" + tableNo);
    let currentOrders = storedOrders ? JSON.parse(storedOrders) : [];

    if (!Array.isArray(currentOrders)) currentOrders = [];

    // Create Order Object
    const newOrder = {
        item_id: currentModalItem.id,
        name: currentModalItem.name,
        price: currentModalItem.price,
        quantity: currentModalItem.quantity,
        image: currentModalItem.image,
        image_url: currentModalItem.image_url
    };

    currentOrders.push(newOrder);

    // Save to LocalStorage
    localStorage.setItem("orders_" + tableNo, JSON.stringify(currentOrders));

    // Update Badge Global
    CartNotification.set(currentOrders.length);

    if (window.showNotification) {
        showNotification(`Added ${newOrder.quantity}x ${newOrder.name}`);
    }
}