<?php

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Página Web Responsive</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style2.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<header>
  <nav class="navbar navbar-expand-lg bg-body-tertiary nv0">
    <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="main3.php">MyRankedGame</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
              aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item"><a class="nav-link active" href="#">Friends</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Account</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="main3.php">Log-in</a></li>
              <li><a class="dropdown-item" href="#">Log-out</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Create Account</a></li>
            </ul>
          </li>
          <li class="nav-item"><a class="nav-link disabled">Premium</a></li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
</header>

<main class="py-5 bg-white">
  <section class="container text-center mb-5">
    <h2>Welcome to MyRankedGames</h2>
    <p class="lead">To use our services, please create an account or log in with an existing account.</p>
  </section>

  <section class="container">
    <h3 class="mb-4">Account</h3>
    <div class="p-4 rounded bg-light shadow-sm">
      <h4>Create Account</h4>
      <form action="create_account.php" method="POST" class="row g-3">
        <div class="col-md-6">
          <label for="username" class="form-label">Nombre de Usuario:</label>
          <input type="text" id="username" name="username" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="email" class="form-label">Correo Electrónico:</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="password" class="form-label">Contraseña:</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label for="birthdate" class="form-label">Fecha de Nacimiento:</label>
          <input type="date" id="birthdate" name="birthdate" class="form-control" required>
        </div>
        <div class="col-12 text-end">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </div>
  </section>
</main>

<footer class="bg-dark text-white text-center py-3 mt-5">
  <div class="container">
    <p class="mb-0">&copy; 2025 Pablo Manuel Jimenez Torres.</p>
  </div>
</footer>

</body>
</html>
