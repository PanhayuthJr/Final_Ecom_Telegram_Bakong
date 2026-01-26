document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productItems = document.querySelectorAll('.product-item');
    const productsContainer = document.getElementById('productsContainer');
    const emptyState = document.getElementById('emptyState');
    const resetFiltersBtn = document.getElementById('resetFilters');

    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase();
        const activeFilter = document.querySelector('.filter-btn.active').dataset.filter;
        let visibleCount = 0;

        productItems.forEach(item => {
            const name = item.querySelector('.product-title').textContent.toLowerCase();
            const desc = item.querySelector('.product-description').textContent.toLowerCase();
            const specs = item.querySelector('.product-specifications')?.textContent.toLowerCase() || '';
            const stock = item.dataset.stock;
            const category = item.dataset.category;

            const matchesSearch = (name + desc + specs).includes(searchTerm);
            const matchesFilter =
                activeFilter === 'all' ||
                (activeFilter === 'in-stock' && stock === 'in-stock') ||
                (activeFilter === 'out-of-stock' && stock === 'out-of-stock') ||
                (activeFilter === 'gaming' && category === 'gaming');

            item.style.display = matchesSearch && matchesFilter ? 'block' : 'none';
            if (matchesSearch && matchesFilter) visibleCount++;
        });

        productsContainer.classList.toggle('d-none', visibleCount === 0);
        emptyState.classList.toggle('d-none', visibleCount !== 0);
    }

    searchInput.addEventListener('input', filterProducts);

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            filterProducts();
        });
    });

    resetFiltersBtn?.addEventListener('click', () => {
        searchInput.value = '';
        filterButtons.forEach(b => b.classList.toggle('active', b.dataset.filter === 'all'));
        filterProducts();
    });
});
