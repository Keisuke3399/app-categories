<?php
require_once("../categories/my_functions.php");

$id = (int)filter_input(INPUT_POST, "id");
$title = (string)filter_input(INPUT_POST, "title");
$learning_time = (int)filter_input(INPUT_POST, "learning_time");
$category_id = (int)filter_input(INPUT_POST, "category_id");

try {
  $pdo = new_pdo();

  $sql = "insert into courses(id, title, learning_time, category_id)
   values(:id, :title, :learning_time, :category_id)";

  $ps = $pdo->prepare($sql);
  $ps->bindValue(":id", $id, PDO::PARAM_INT);
  $ps->bindValue(":title", $title, PDO::PARAM_STR);
  $ps->bindValue(":learning_time", $learning_time, PDO::PARAM_INT);
  $ps->bindValue(":category_id", $category_id, PDO::PARAM_INT);

  $ps->execute();
  $count = $ps->rowCount();

  header("Location: index.php");
} catch (PDOException $e) {
  error_log("PDOException: " . $e->getMessage());
  header("Location: error.php");
  exit();
}
