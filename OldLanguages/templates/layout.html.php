<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="oldlanguages.css">
    <title><?=$title?></title>
  </head>
  <body>
  <nav>
    <header>
    </header>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="index.php?route=originaltext/list">Original Text List</a></li>
      <li><a href="index.php?route=originaltext/save">Add a new Original Text</a></li>
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