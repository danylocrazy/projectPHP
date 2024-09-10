<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css//style.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>DE/UA Immobilien</title>
</head>
<body>
    <div class="container">
        <header class="header-ukraine d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4">
            <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                <li><a href="#" class="nav-link px-2">Головна</a></li>
                <li><a href="#" class="nav-link px-2">Питання</a></li>
                <li><a href="#" class="nav-link px-2">Про нас</a></li>
            </ul>

            <form class="col-md-3 form-inline btn-container">
                <?php echo '<a href="login.php" class="btn btn-outline-primary me-2">Вхiд</a>'?>
                <button type="button" class="btn btn-primary">Створити</button>
            </form>

        </header>
    </div>

<?php
    $url = 'https://www.kleinanzeigen.de/s-wohnung-mieten/45768/c203l1774';
    $html = file_get_contents($url);
    
    if($html === FALSE) {
        echo 'Ну удалось!';
        exit;
    }

    preg_match_all('/<article class="aditem"[^>]*>(.*?)<\/article>/s', $html, $matches);
    

    if(!empty($matches[1])) {
        foreach ($matches[1] as $add) {
            // Извлечение заголовка
            preg_match('/<h2 class="text-module-begin">\s*<a[^>]*href="([^"]*)">([^<]+)<\/a>\s*<\/h2>/', $add, $titleMatch);
            $title = !empty($titleMatch[2]) ? htmlspecialchars($titleMatch[2]) : 'Без заголовка';
            $relativeLink = !empty($titleMatch[1]) ? htmlspecialchars($titleMatch[1]) : '#';
            $link = 'https://www.kleinanzeigen.de' . $relativeLink;

            // Извлечение цены
            preg_match('/<p class="aditem-main--middle--price-shipping--price">\s*([^<]+)\s*<\/p>/', $add, $priceMatch);
            $price = !empty($priceMatch[1]) ? htmlspecialchars($priceMatch[1]) : 'Без цены';

            //фото 
            preg_match('/<img[^>]*src="([^"]*)"[^>]*alt="[^"]*"/', $add, $imageMatch);
            $imageUrl = !empty($imageMatch[1]) ? htmlspecialchars($imageMatch[1]) : 'Нет изображения';

            echo "<div class='ad-item'>
                    <div class='image'>
                        <img src='$imageUrl' alt='$title'>
                    </div>
                <div class='details'>
                    <div class='title'><a href='$link'>$title</a></div>
                    <div class='price'>$price</div>
                </div>
              </div>";
        }
    } else {
        echo 'Не нашёл обьявления!';
    }
?>

<style>
 body {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    background-color: #f0f0f0;
}

.ad-item {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    padding: 10px;
    margin-bottom: 10px;
    width: 100%;
    max-width: 1200px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    box-sizing: border-box;
}

.image {
    margin-right: 20px;
}

.image img {
    width: 165px;
    height: 190px;
    object-fit: cover; /* Обрезка изображения для сохранения пропорций */
    border-radius: 5px;
}

.details {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex: 1;
}

.title {
    font-family: 'Arial', sans-serif;
    font-size: 20px;
    color: #333;
    margin-bottom: 5px;
}

.price {
    font-family: 'Arial', sans-serif;
    font-size: 18px;
    color: #e74c3c;
    font-weight: bold;
}

</style>


    <footer class="footer-ukraine py-4 mt-4">
        <div class="container text-center">
            <p class="mb-0">© 2024 DE/UA Immobilien. All rights reserved.</p>
            <p class="mb-0">
                <a href="#" class="footer-link">Privacy Policy</a> | 
                <a href="#" class="footer-link2">Terms of Service</a>
            </p>
        </div>
    </footer>
</body>
</html>