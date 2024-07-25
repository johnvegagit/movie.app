<?php
function output_header_menu()
{
  if (isset($_SESSION['user_id'])) {
    echo '
          <header id="user-header" >
            <a href="' . URLPATH . '"><h1>moovie.</h1></a>

            <nav>
              <a href="">Home</a>
              <a href="">Series</a>
              <a href="">Movies</a>
              <a href="">Kids & family</a>
            </nav>

            <ul>
              <li>' . $_SESSION["user_name"] . ' ' . $_SESSION["user_surname"] . '</li>
              <form action="' . URLPATH . 'logout" method="post">
                <button type="submit" class="nav-item pl-1"><i class="bi bi-box-arrow-right"></i></button>
              </form>
            </ul>

          </header>
          ';
  } else {
    echo '
          <header id="welcome-header">
            <a href="' . URLPATH . '">
              <h1>moovie.</h1>
            </a>

            <ul class="navbar-nav">
              <li class="nav-item"><a class="nav-link" href="' . URLPATH . 'login">LOGIN</a></li>
              <li class="nav-item"><a class="nav-link" href="' . URLPATH . 'subscribe">SUBSCRIBE NOW</a></li>
            </ul>
          </header>
          ';
  }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="<?= URLPATH ?>public/assets/style/signup.css">
  <link rel="stylesheet" href="<?= URLPATH ?>public/assets/style/index.css">
  <link rel="stylesheet" href="<?= URLPATH ?>public/assets/style/movie.css">
  <script type="module" src="<?= URLPATH ?>public/assets/script/main.js" defer></script>
  <title><?= $data['title'] ?></title>
</head>

<body>
  <?= output_header_menu();