<?php
require_once("../categories/my_functions.php");

$id = (int)filter_input(INPUT_GET, "id");

try {
  $pdo = new_pdo();

  $sql = "select id, title, learning_time, category_id from courses where id = :id";

  $ps = $pdo->prepare($sql);
  $ps->bindValue(":id", $id, PDO::PARAM_INT);
  $ps->execute();
  $course = $ps->fetch();

  if ($course === false) {
    error_log("Invalid id. $id");
    header("Location: error.php");
    exit();
  }

  $sql = "select id, title from categories order by id";

  $st = $pdo->query($sql);
  $categories = $st->fetchAll();
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
  <h3>Courses - Edit</h3>
  <hr>
  <form action="update.php" method="post">
    <input type="hidden" name="id" value="<?= htmlspecialchars($course['id']) ?>">
    <p>ID: <?= htmlspecialchars($course['id']) ?></p>
    <p>NAME: <input type="text" name="title" value="<?= htmlspecialchars($course['title']) ?>"></p>
    <p>LEARNING_TIME: <input type="number" name="learning_time" value="<?= htmlspecialchars($course['learning_time']) ?>"></p>
    <p>CATEGORY:
      <select name="category_id">
        <?php foreach ($categories as $category) { ?>
          # 三項演算子
          <option value="<?= htmlspecialchars($category['id']) ?>" <?= $category["id"] === $course["category_id"] ? "selected" : "" ?>>
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