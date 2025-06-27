<?php 
    include "../admin-page/koneksi.php";

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Makanan - Dapur Mama Ria</title>
    <link rel="stylesheet" href="menu_styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Cari menu...">
                    <button type="button" id="searchButton"><i class="fas fa-search"></i></button>
                </div>
                <nav>
                    <div class="logo">Dapur Mama Ria</div>
                    <ul class="nav-links">
                        <li><a href="index.php">Beranda</a></li>
                        <li><a href="index.php#about">Profil Kami</a></li>
                        <li><a href="menu.php" class="active">Menu</a></li>
                        <li><a href="index.php#contact">Kontak</a></li>
                        <li><a href="../admin-page/login.php">Masuk</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main class="container">
        <h1 class="menu-title">Menu Makanan dan Minuman Dapur Mama Ria</h1>

        <!-- <h2 class="category-title">Makanan</h2> -->

        <div class="menu-container" id="menuContainer">
            <?php 
                $query = "SELECT * FROM menu";
                $all_menu = mysqli_query($koneksi,$query);

                while($menu = mysqli_fetch_assoc($all_menu)){
                ?> 
                    <div class="menu-item" data-name="ayam geprek">
                        <div class="menu-image">
                            <img src="../profil-page/images/<?= $menu["images"]; ?>" alt="Error Image">
                        </div>
                        
                        <div class="menu-details">
                            <h2><?= $menu["nama_menu"];?></h2>
                            <p class="description"><?= $menu["deskripsi"];?></p>
                            <p class="price">Rp. <?= $menu["harga"];?></p>
                        </div>
                    </div>
            <?php } ?>
            
            
        </div>

        <div class="no-results" id="noResults" style="display: none;">
            <p>Tidak ada menu yang sesuai dengan pencarian Anda.</p>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Dapur Mama Ria. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script src="menu_script.js"></script>
</body>
</html>