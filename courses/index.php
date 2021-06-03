<?php
try {
  require_once("../categories/my_functions.php");
  $pdo = new_pdo();

  $sql = "select co.id, co.title, co.learning_time, ca.title category_title 
  from courses co left join categories ca on co.category_id = ca.id order by co.id";
  $st = $pdo->query($sql);
  $courses = $st->fetchAll();

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
  <title>Document</title>
</head>

<body>
  <h3>Courses - Index</h3>
  <hr>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>TITLE</th>
      <th>LEARNING_TIME</th>
      <th>CATEGORY</th>
    </tr>
    <?php foreach ($courses as $course) { ?>
      <tr>
        <td><?= htmlspecialchars($course['id']) ?></td>
        <td><?= htmlspecialchars($course['title']) ?></td>
        <td><?= htmlspecialchars($course['learning_time']) ?></td>
        <td><?= htmlspecialchars($course['category_title']) ?></td>
      </tr>
    <?php } ?>
  </table>
</body>

</html>