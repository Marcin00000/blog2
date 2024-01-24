<?php
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'root';
    $DATABASE_PASS = '';
    $DATABASE_NAME = 'blog';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname=' . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    } catch (PDOException $exception) {
        // If there is an error with the connection, stop the script and display the error.
        exit('Failed to connect to database!');
    }
}
    function template_header($title) {
    echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>$title</title>
		<link href="style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="../fontawesome6.5.1-web/css/all.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Panel administracyjny</h1>
    		<a href="../index.php"><i class='fa-solid fa-house'></i> Blog </a>
            <a href="index.php"><i class="fas fa-home"></i>Home</a>
    		<a href="read.php"><i class="fa-solid fa-users"></i>Użytkownicy</a>
    		<a href="readArticle.php"><i class="fa-solid fa-book"></i>Artykuły</a>
    		<a href="../test/profile.php"><i class="fas fa-user-circle"></i>Profil</a>		
    	</div>
    </nav>
EOT;
}
function template_footer() {
    echo <<<EOT
    </body>
</html>
EOT;
}
?>