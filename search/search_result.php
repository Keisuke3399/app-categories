<?php
require_once("../categories/my_functions.php");

$title_q = (string)filter_input(INPUT_GET, "title_q");
$lt_q_min = (int)filter_input(INPUT_GET, "lt_q_min");
// var_dump($title_q);
// var_dump($lt_q_min);
// die('debug');

$pdo = new_pdo();
// var_dump($pdo);

$sql = "select id, title, learning_time from courses where title like :title_q";
if ($lt_q_min !== 0) {
  $sql .= " and learning_time = :lt_q_min";
}
// var_dump($sql);

$ps = $pdo->prepare($sql);
$title_q = "%" . $title_q . "%";
$ps->bindValue(":title_q", $title_q, PDO::PARAM_STR);

if ($lt_q_min !== 0) {
  $ps->bindValue(":lt_q_min", $lt_q_min, PDO::PARAM_INT);
}
var_dump($ps);

$ps->execute();
$course_search = $ps->fetchAll();

// var_dump($course_search);

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>

<body>
  <h3>Course Search</h3>
  <hr>
  <p> <input type="text" name="title_q" value="<?= $_GET['title_q'] ?>">
    <input type="number" name="lt_q_min" value="<?= $_GET['lt_q_min'] ?>">
    <button type="submit">search</button>
  </p>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>TITLE</th>
      <th>LT</th>
    </tr>
    <?php foreach ($course_search as $searched_value) { ?>
      <tr>
        <td><?= htmlspecialchars($searched_value['id']) ?></td>
        <td><?= htmlspecialchars($searched_value['title']) ?></td>
        <td><?= htmlspecialchars($searched_value['learning_time']) ?></td>
      </tr>
    <?php } ?>
  </table>
</body>

</html>