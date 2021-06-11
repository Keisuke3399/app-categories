<?php
require_once("../categories/my_functions.php");

try {
  $pdo = new_pdo();

  $sql = "select id, title from categories order by id";

  $st = $pdo->query($sql);
  $categories = $st->fetchAll();
} catch (PDOException $e) {
  error_log("PDOException: " . $e->getMessage());
  exit();
}
// var_dump($categories)
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>PHP DB</title>
</head>

<body>
  <h3>Courses - New</h3>
  <hr>
  <form action="create.php" method="post">
    <p>ID: <input type="number" name="id"></p>
    <p>NAME: <input type="text" name="title"></p>
    <p>LEARNING_TIME: <input type="number" name="learning_time"></p>
    <p>CATEGORY:
      <select name="category_id">
        <?php foreach ($categories as $category) { ?>
          <option value="<?= htmlspecialchars($category['id']) ?>">
            <?= htmlspecialchars($category['title']) ?>
          </option>
        <?php } ?>
      </select>
    </p>
    <button type="submit">SAVE</button>
  </form>
  <hr>
  <a href="index.php">BACK</a>
</body>

</html>