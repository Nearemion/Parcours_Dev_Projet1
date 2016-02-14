<?php
$today = new \DateTime('now');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Tiriel's Home Made Blog</title>
    <meta charset="utf-8" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>
<body>
<div class="container">
    <header class="jumbotron">
        <h1>Tiriel's Home Made Blog</h1>
        <p>Baked with love!</p>
    </header>
    <section>
        <?php echo $content; ?>
    </section>
    <footer class="footer text-center">
        <div class="row">
            <p>Made by Tiriel, © <?php echo $today->format('Y'); ?> and beyond</p>
            <p><a href="https://github.com/Nearemion/Parcours_Dev_Projet1">Le gitHub du projet</a></p>
        </div>
    </footer>
</div>
</body>
</html>