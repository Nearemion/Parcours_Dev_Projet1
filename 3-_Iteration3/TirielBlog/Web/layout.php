<?php
$today = new \DateTime('now');

function activeTab($string)
{
    if (preg_match('#^'.$string.'$#', $_SERVER['REQUEST_URI'])) {
        return 'class="active"';
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ben's Home Made Blog</title>
    <meta charset="utf-8" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha256-7s5uDGW3AHqw6xtJmNNtr+OBRJUlgkNJEo78P4b0yRw= sha512-nNo+yCHEyn0smMxSswnf/OnX6/KwJuZTlNZBjauKhTK0c+zT+q5JOCx0UFhXQ6rJR9jg6Es8gPuD2uZcYDLqSw==" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="/Web/css/main.css" />
</head>
<body>
<div class="container-fluid">
    <header class="jumbotron">
        <h1>Ben's Home Made Blog</h1>
        <p>Baked with love!</p>
    </header>
    <nav>
        <ul class="nav nav-tabs nav-justified">
            <li <?= activeTab('/\d*'); ?> ><a href="/">Accueil</a></li>
            <li <?= activeTab('/contact'); ?> ><a href="/contact">Contact</a></li>
            <?php if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'] == true && $_SESSION['role'] == 2) { ?>
            <li <?= activeTab('/admin/'); ?> ><a href="/admin/">Administration</a></li>
            <?php } else { ?>
            <li <?= activeTab('/login'); ?> ><a href="/login">Connexion</a></li>
            <?php } ?>
        </ul>
    </nav>
    <section class="row">
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