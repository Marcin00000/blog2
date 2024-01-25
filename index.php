<?php
include 'functions.php';
template_head('Home')
?>

<body>

<?= template_nav() ?>

<main>
    <div class="parallax-container" id="home">
        <div class="logo-text">Marcin Wilk - BLOG</div>
    </div>

    <h3>KONTAKT</h3>

    <div class="contact-section" id="contact">
        <div class="w3-row contact-image">
            <img src="pic/contact.gif" alt="Contact Image">
        </div>
        <div class="contact-info">
            <br>
            <div><i class="fa-solid fa-map-marker fa-fw"></i> Wydział Nauk Ścisłych i Technicznych Uniwersytet Śląski
            </div>
            <div><i class="fa-solid fa-phone fa-fw"></i> Telefon: +48 323689866</div>
            <div><i class="fa-solid fa-envelope fa-fw"></i> Email: wnp@us.edu.pl</div>
            <div>
                <i class="fa-solid fa-coffee fa-fw"></i>
                <a href="https://niemyslniepytaj.github.io/hub/" target="_blank" rel="noopener noreferrer">
                    Strona o żółwiach
                </a>
            </div>
        </div>
    </div>
</main>

<?= template_foot() ?>

</body>
</html>