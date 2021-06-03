<?php

$id = (int)filter_input(INPUT_GET, "id");

try {
  require_once("my_functions.php");
  $pdo = new_pdo();

  $sql = "select * from categories where id = :id";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(":id", $id, PDO::PARAM_INT);
  $ps->execute();
  $category = $ps->fetch();

  if ($category === false) {
    error_log("Invalid id. $id");
    header("Location: error.php");
    exit();
  }
} catch (PDOException $e) {
  error_log("PDOException: " . $e->getMessage());
  header("Location: error.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>PHP DB</title>
</head>

<body>
  <h3>Categories - Edit</h3>
  <hr>
  <form action="update.php" method="post">
  <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">
  <p>ID: <?= htmlspecialchars($category['id']) ?></p>
  <p>NAME: <input type="text" name="title" value="<?= htmlspecialchars($category['title']) ?>"></p>
  <p><input type="submit" value="SAVE"></p>
  </form>
  <hr>
  <a href="index.php">BACK</a>
</body>

</html>