// Script untuk fungsionalitas search bar
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const menuItems = document.querySelectorAll('.menu-item');
    const noResults = document.getElementById('noResults');
    
    // Fungsi untuk melakukan pencarian
    function performSearch() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let resultsFound = false;
        
        // Jika search term kosong, tampilkan semua menu
        if (searchTerm === '') {
            menuItems.forEach(item => {
                item.style.display = 'block';
            });
            noResults.style.display = 'none';
            return;
        }
        
        // Filter menu berdasarkan search term
        menuItems.forEach(item => {
            const menuName = item.getAttribute('data-name');
            const menuText = item.textContent.toLowerCase();
            
            if (menuName.includes(searchTerm) || menuText.includes(searchTerm)) {
                item.style.display = 'block';
                resultsFound = true;
            } else {
                item.style.display = 'none';
            }
        });
        
        // Tampilkan pesan jika tidak ada hasil
        if (resultsFound) {
            noResults.style.display = 'none';
        } else {
            noResults.style.display = 'block';
        }
    }
    
    // Event listener untuk tombol search
    searchButton.addEventListener('click', performSearch);
    
    // Event listener untuk input search (ketika user menekan Enter)
    searchInput.addEventListener('keyup', function(event) {
        if (event.key === 'Enter') {
            performSearch();
        }
        
        // Real-time search saat mengetik
        performSearch();
    });
    
    // Animasi untuk menu items
    menuItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.querySelector('.menu-image img').style.transform = 'scale(1.05)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.querySelector('.menu-image img').style.transform = 'scale(1)';
        });
    });

    // Toggle deskripsi satu per satu (hanya satu menu terbuka)
document.querySelectorAll('.menu-image').forEach(image => {
    image.addEventListener('click', () => {
        const menuItem = image.closest('.menu-item');
        const isActive = menuItem.classList.contains('active');

        // Tutup semua deskripsi
        document.querySelectorAll('.menu-item').forEach(item => item.classList.remove('active'));

        // Jika item belum aktif, buka
        if (!isActive) {
            menuItem.classList.add('active');
        }
    });
});


});
