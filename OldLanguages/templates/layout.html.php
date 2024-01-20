<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/styles/oldlanguages.css">
    <title><?=$title?></title>
  </head>
  <body>
  <nav>
    <header>
    </header>
    <ul>
      <li><a href="/originaltext">Home</a></li>
      <li><a href="/originaltext/list">Original Text List</a></li>
      <?php if ($loggedIn): ?>
      <li><a href="/originaltext/save">Add a new Original Text</a></li>
      <?php endif; ?>
      <?php if ($loggedIn): ?>
      <li><a href="/login/logout">Log out</a></li>
      <?php else: ?>
      <li><a href="/login/login">Log in</a></li>
      <?php endif; ?>

    </ul>
  </nav>

  <main>
  <?=$output?>
  </main>

  <footer>
  &copy; Ludvik Valicek 2024
  </footer>
  </body>
</html>