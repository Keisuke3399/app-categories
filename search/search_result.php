<?php
require_once("../categories/my_functions.php");

$co_title = (string)filter_input(INPUT_GET, "co_title");
$ca_title = (string)filter_input(INPUT_GET, "ca_title");
$lt_q_min = (int)filter_input(INPUT_GET, "lt_q_min");
$lt_q_max = (int)filter_input(INPUT_GET, "lt_q_max");
// var_dump($co_title);
// var_dump($lt_q_min);
// var_dump($lt_q_max);
// var_dump($ca_title);
// die('debug');

try {
  $pdo = new_pdo();
  // var_dump($pdo);
  $sql = "select co.id, co.title co_title, co.learning_time, ca.title ca_title from courses co left join categories ca on co.category_id = ca.id where co.title like :co_title";

  if ($lt_q_min !== 0 && $lt_q_max !== 0 && $ca_title !== "") {
    $sql .= " and co.learning_time >= :lt_q_min and co.learning_time <= :lt_q_max and ca.title = :ca_title";
  } else if ($lt_q_min !== 0 && $lt_q_max !== 0) {
    $sql .= " and co.learning_time between :lt_q_min and :lt_q_max";
  } else if ($lt_q_min !== 0) {
    $sql .= " and co.learning_time >= :lt_q_min";
  } else if ($lt_q_max !== 0) {
    $sql .= " and co.learning_time <= :lt_q_max";
  } else if ($ca_title !== "") {
    $sql .= " and ca.title = :ca_title";
  }
  // var_dump($sql);

  $ps = $pdo->prepare($sql);
  $co_title = "%" . $co_title . "%";
  $ps->bindValue(":co_title", $co_title, PDO::PARAM_STR);

  if ($lt_q_min !== 0 && $lt_q_max !== 0 && $ca_title !== "") {
    $ps->bindValue(":lt_q_min", $lt_q_min, PDO::PARAM_INT);
    $ps->bindValue(":lt_q_max", $lt_q_max, PDO::PARAM_INT);
    $ps->bindValue(":ca_title", $ca_title, PDO::PARAM_STR);
  } else if ($lt_q_min !== 0 && $lt_q_max !== 0) {
    $ps->bindValue(":lt_q_min", $lt_q_min, PDO::PARAM_INT);
    $ps->bindValue(":lt_q_max", $lt_q_max, PDO::PARAM_INT);
  } else if ($lt_q_min !== 0) {
    $ps->bindValue(":lt_q_min", $lt_q_min, PDO::PARAM_INT);
  } else if ($lt_q_max !== 0) {
    $ps->bindValue(":lt_q_max", $lt_q_max, PDO::PARAM_INT);
  } else if ($ca_title !== "") {
    $ps->bindValue(":ca_title", $ca_title, PDO::PARAM_STR);
  }
  // var_dump($ps);

  $ps->execute();
  $course_search = $ps->fetchAll();
} catch (PDOException $e) {
  error_log("PDOException :" . $e->getMessage());
}
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
  <p>
    TITLE <input type="text" name="co_title" value="<?= $_GET['co_title'] ?>">
    LT <input type="number" name="lt_q_min" value="<?= $_GET['lt_q_min'] ?>"> 〜
    <input type="number" name="lt_q_max" value="<?= $_GET['lt_q_max'] ?>">
    <select name="ca_title">
      <option value="<?= htmlspecialchars($_GET['ca_title']) ?>">
        <?= htmlspecialchars($_GET['ca_title']) ?>
      </option>
    </select>
    <button type="submit">search</button>
  </p>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>TITLE</th>
      <th>LT</th>
      <th>CATEGORY</th>
    </tr>
    <?php foreach ($course_search as $searched_value) { ?>
      <tr>
        <td><?= htmlspecialchars($searched_value['id']) ?></td>
        <td><?= htmlspecialchars($searched_value['co_title']) ?></td>
        <td><?= htmlspecialchars($searched_value['learning_time']) ?></td>
        <td><?= htmlspecialchars($searched_value['ca_title']) ?></td>
      </tr>
    <?php } ?>
  </table>
</body>

</html>