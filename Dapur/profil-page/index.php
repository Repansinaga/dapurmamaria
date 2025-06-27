<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapur Mama Ria - Warung Makan Keluarga</title>
    <style>
        /* CSS Global */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }
        
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Header */
        header {
            background-color: #e74c3c;
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
        }
        
        .nav-links li {
            margin-left: 2rem;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-links a:hover {
            color: #f1c40f;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), 
                        url('hero-bg.jpg') center/cover no-repeat;
            height: 60vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
        }
        
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .hero-content p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 2rem;
        }
        
        .btn {
            display: inline-block;
            background-color: #f1c40f;
            color: #333;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            background-color: #f39c12;
            transform: translateY(-3px);
        }
        
        /* About Section */
        .about {
            padding: 5rem 0;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            font-size: 2.2rem;
            color: #e74c3c;
        }
        
        .about-content {
            display: flex;
            align-items: center;
            gap: 3rem;
        }
        
        .about-text {
            flex: 1;
        }
        
        .about-image {
            flex: 1;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .about-image img {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* Menu Section */
        .menu {
            padding: 5rem 0;
            background-color: #f9f9f9;
        }
        
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .menu-item {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .menu-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
        }
        
        .menu-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .menu-item-content {
            padding: 1.5rem;
        }
        
        .menu-item-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
            color: #e74c3c;
        }
        
        .menu-item-price {
            font-weight: bold;
            color: #f39c12;
            margin-bottom: 1rem;
        }
        
        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 3rem 0 1rem;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            color: #f1c40f;
        }
        
        .footer-column ul {
            list-style: none;
        }
        
        .footer-column ul li {
            margin-bottom: 0.8rem;
        }
        
        .footer-column ul li a {
            color: #ddd;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .footer-column ul li a:hover {
            color: #f1c40f;
            padding-left: 5px;
        }
        
        .copyright {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid #444;
            color: #aaa;
            font-size: 0.9rem;
        }
        .about {
    padding: 5rem 0;
    background: linear-gradient(to right, #fffaf0, #fff);
}

.decorated-title {
    position: relative;
    display: inline-block;
    padding-bottom: 0.5rem;
    margin-bottom: 2rem;
    font-size: 2.4rem;
    color: #e74c3c;
    text-align: center;
    width: 100%;
}

.decorated-title::after {
    content: '';
    width: 60px;
    height: 4px;
    background-color: #e74c3c;
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    border-radius: 5px;
}

.about-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
    flex-wrap: wrap;
    animation: fadeIn 1s ease-in;
}

.about-text {
    flex: 1;
    font-size: 1.05rem;
    line-height: 1.8;
    color: #444;
}

.about-text p {
    margin-bottom: 1rem;
}

.about-image {
    flex: 1;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.about-image img {
    width: 100%;
    height: auto;
    display: block;
    border-radius: 15px;
}

.about-image:hover {
    transform: scale(1.03);
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

    </style>
</head>
<body>
    <!-- Header Navigation -->
    <header>
        <div class="container">
            <nav>
                <div class="logo">Dapur Mama Ria</div>
                <ul class="nav-links">
                    <li><a href="#home">Beranda</a></li>
                    <li><a href="#about">Profil Kami</a></li>
                    <li><a href="menu.php">Menu</a></li>
                    <li><a href="#contact">Kontak</a></li>
                    <li><a href="../admin-page/login.php">Masuk</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Selamat Datang di Dapur Mama Ria</h1>
            <p>Rasakan kehangatan masakan rumahan dengan cita rasa otentik yang membuat Anda merasa seperti di rumah sendiri</p>
            <a href="./menu.php" class="btn">Lihat Menu Kami</a>
        </div>
    </section>

    <!-- About Section -->
<section class="about" id="about">
    <div class="container">
        <h2 class="section-title decorated-title">Profil Dapur Mama Ria</h2>
        <div class="about-content">
            <div class="about-text" style="text-align: justify;">
                <p><strong>Dapur Mama Ria</strong> Dapur Mama Ria adalah sebuah usaha warung makan yang telah berdiri dan melayani pelanggan selama kurang lebih dua tahun terakhir. Warung makan ini dimiliki dan dikelola oleh Mariatus Syafaah 48 tahun, yang lebih akrab disapa Ria. Sebagai seorang pemilik usaha kecil, Ria secara aktif mengelola berbagai aspek bisnisnya, mulai dari pengadaan/pengelolaan bahan baku hingga pencatatan keuangan.</p>
                <p>Warung makan ini beroperasi setiap hari Senin hingga Sabtu, melayani pelanggan dengan berbagai pilihan menu makanan khas Indonesia. Beberapa menu andalan yang tersedia antara lain soto, bakso, rawon, dan berbagai hidangan lainnya yang disukai oleh pelanggan setianya.</p>
                <p>Setiap hidangan dibuat dengan penuh cinta dan perhatian, seperti yang dilakukan seorang ibu untuk keluarganya.</p>
                <p>Konsep kami sederhana: <em>makanan enak, pelayanan ramah, dan suasana nyaman</em>.</p>
            </div>
            <div class="about-image">
                <img src="../profil-page/images/Profile.jpg" alt="Interior Dapur Mama Ria">
            </div>
        </div>
    </div>
</section>


    <!-- Menu Section -->
    <section class="menu" id="menu">
        <div class="container">
            <h2 class="section-title">Menu Favorit</h2>
            <div class="menu-grid">
                <!-- Menu Item 1 -->
                <div class="menu-item">
                    <!-- Tempat untuk foto menu -->
                    <img src="images/Bakso Tanggungg.jpg" alt="Nasi Goreng Dapur Mama Ria">
                    <div class="menu-item-content">
                        <h3 class="menu-item-title">Bakso Tanggung</h3>
                        <p class="menu-item-price">Rp 18.000</p>
                        <p>Bakso Tanggung adalah bakso berukuran sedang yang menawarkan keseimbangan sempurna antara rasa, tekstur, dan kepuasan. Dibuat dari daging sapi pilihan yang diolah dengan bumbu khas.</p>
                    </div>
                </div>
                
                <!-- Menu Item 2 -->
                <div class="menu-item">
                    <img src="images/Geprekk.jpg" alt="Ayam Geprek Dapur Mama Ria">
                    <div class="menu-item-content">
                        <h3 class="menu-item-title">Ayam Geprek</h3>
                        <p class="menu-item-price">Rp 10.000</p>
                        <p>Ayam geprek adalah hidangan ayam goreng renyah yang digeprek (dihancurkan) dan dicampur dengan sambal bawang pedas..</p>
                    </div>
                </div>
                
                <!-- Menu Item 3 -->
                <div class="menu-item">
                    <img src="images/Soto.jpg" alt="Soto Ayam Dapur Mama Ria">
                    <div class="menu-item-content">
                        <h3 class="menu-item-title">Soto Ayam</h3>
                        <p class="menu-item-price">Rp 18.000</p>
                        <p>Soto adalah sup ayam tradisional Indonesia dengan kuah kuning yang kaya rempah seperti kunyit, serai, dan daun jeruk.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="contact">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>Tentang Kami</h3>
                    <p>Dapur Mama Ria - Warung makan keluarga dengan cita rasa rumahan yang otentik dan nikmat.</p>
                </div>
                <div class="footer-column">
                    <h3>Kontak</h3>
                    <ul>
                        <li>Jl. Nanas III No. 328 Pondok Tjandra Indah, Tambakrejo, Waru, Kabupaten Sidoarjo. </li>
                        <li>08133257330</li>
                        <li>dapurmamaria@example.com</li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Jam Buka</h3>
                    <ul>
                        <li>Buka : selasa-minggu, 08.00 - 16.00</li>
                        <li>Senin Libur</li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Dapur Mama Ria. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>