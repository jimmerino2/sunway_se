document.addEventListener('DOMContentLoaded', () => {
    const productContainer = document.getElementById('productContainer');
    const genreSelect = document.getElementById('genre');

    const PRODUCT_API = 'http://localhost/software_engineering/backend/item';

    async function fetchProducts(selectedGenre) {
        try {
            const res = await fetch(PRODUCT_API);
            const data = await res.json();
            if (!data.success) return;

            // Clear previous products
            productContainer.innerHTML = '';

            // Filter products based on selected genre
            const filtered = selectedGenre === 'All'
                ? data.data
                : data.data.filter(p => p.category_name === selectedGenre);

            if (filtered.length === 0) {
                const empty = document.createElement('p');
                empty.className = 'text-center text-muted fs-5';
                empty.textContent = 'No products found for this genre.';
                productContainer.appendChild(empty);
                return;
            }

            // Insert products (keeping the HTML structure same)
            filtered.forEach(p => {
                const col = document.createElement('div');
                col.className = 'col mb-5 product-card';
                col.innerHTML = `
                    <div class="card h-100 shadow-sm">
                        <img class="card-img-top" src="/software_engineering/backend/public/storage${p.image_url}" alt="${p.name}">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bolder">${p.name}</h5>
                            RM${parseFloat(p.price).toFixed(2)}
                        </div>
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent text-center">
                            <a class="btn btn-outline-dark mt-auto" href="#">View Details</a>
                        </div>
                    </div>
                `;
                productContainer.appendChild(col);
            });
        } catch (err) {
            console.error('Error fetching products:', err);
        }
    }

    // Initial load
    fetchProducts(genreSelect.value);

    // On genre change
    genreSelect.addEventListener('change', () => {
        fetchProducts(genreSelect.value);
    });
});
