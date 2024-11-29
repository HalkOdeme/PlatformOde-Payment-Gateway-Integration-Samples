<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anasayfa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            overflow: hidden;
        }

        .content {
            flex: 1;
            position: relative;
            text-align: center;
            color: white;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .background-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('mainSlider1.jpg');
            background-size: cover;
            background-position: center;
            z-index: 0;
        }

        .content h1 {
            position: relative;
            z-index: 1;
            margin-top: 50px;
        }

        .navbar-custom {
            background-color: #1b0565;
        }

        .navbar-custom .nav-link {
            color: white !important;
        }

        .navbar-brand {
            flex-grow: 1;
            text-align: center;
        }

        .navbar-nav {
            flex-direction: row;
            justify-content: center;
            width: 100%;
        }

        footer {
            background-color: #1b0565;
            color: white;
        }
    </style>
</head>

<body>
    <nav class='navbar navbar-expand-lg navbar-light navbar-custom'>
        <a class='navbar-brand' href='index.php'>
            <img src="platform-logo.svg" alt="Platform Ödeme" style="height: 40px;">
        </a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarNav' aria-controls='navbarNav' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
        </button>
        <div class='collapse navbar-collapse' id='navbarNav'>
            <ul class='navbar-nav'>
                <li class='nav-item'>
                    <a class='nav-link' href='index.php'>Anasayfa</a>
                </li>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                        Entegrasyonlar
                    </a>
                    <div class='dropdown-menu' aria-labelledby='navbarDropdown'>

                        <a class='dropdown-item' href='2d.php'>2D Entegrasyonu</a>
                        <a class='dropdown-item' href='3d.php'>3D Entegrasyonu</a>
                        <a class='dropdown-item' href='purchaselink.php'>Link ile Ödeme Entegrasyonu</a>
                        <a class='dropdown-item' href='refund.php'>İade Entegrasyonu</a><!-- refund -->
                        <a class='dropdown-item' href='checkstatus.php'>Ödeme Sorgulama</a> <!-- checkstatus -->
                        <div class="dropdown-divider"></div>
                        <a class='dropdown-item' href='installement.php'>Taksit Sayısı</a><!-- get installement -->
                        <a class='dropdown-item' href='getpost.php'>Taksit Gösterme Entegrasyonu</a><!-- taksit gösterme -->

                    </div>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='parameters.php'>Parametreler</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content">
        <div class="background-image"></div>
        <h1>Platform Ödeme Hizmetleri PHP Entegrasyonuna Hoş Geldiniz</h1>
    </div>

    <footer class="text-center text-lg-start">
        <div class="text-center p-3">
            <span>© 2024 Platform Ödeme Hizmetleri ve Elektronik Para A.Ş.</span>
        </div>
    </footer>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Smooth Scroll Script -->
    <script>
        $(document).ready(function() {
            $('.navbar-toggler').on('click', function() {
                $('html, body').animate({
                    scrollTop: $('.content').offset().top
                }, 800); // 800ms smooth scroll
            });
        });
    </script>
</body>

</html>