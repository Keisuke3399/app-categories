<?php
require_once("../categories/my_functions.php");

$id = (int)filter_input(INPUT_GET, "id");

try {
  $pdo = new_pdo();

  $sql = "delete from courses where id = :id";

  $ps = $pdo->prepare($sql);
  $ps->bindValue(":id", $id, PDO::PARAM_INT);
  $ps->execute();

  header("Location: index.php");
} catch (PDOException $e) {
  error_log("PDOException: " . $e->getMessage());
  header("Location: error.php");
  exit();
}
