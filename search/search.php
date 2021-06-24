<?php
require_once("../categories/my_functions.php");

try {
  $pdo = new_pdo();
  $sql = "select title from categories";

  $st = $pdo->query($sql);
  $categories = $st->fetchAll();
} catch (PDOException $e) {
  error_log("PDOException: " . $e->getMessage());
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <title>Document</title>
</head>

<body>
  <h3>Course Search</h3>
  <hr />
  <form action="search_result.php" method="get">
    TITLE <input type="text" name="co_title" /> LT
    <input type="number" name="lt_q_min" /> 〜
    <input type="number" name="lt_q_max" />
    CATEGORY <select name="ca_title">
      <option value=""></option>
      <?php foreach ($categories as $category) { ?>
        <option value="<?= htmlspecialchars($category['title']) ?>">
          <?= htmlspecialchars($category['title']) ?>
        </option>
      <?php } ?>
    </select>
    <button type="submit">search</button>
  </form>
</body>

</html>