<?php
require_once("my_functions.php");

$id = (int)filter_input(INPUT_GET, "id");

try {
  $pdo = new_pdo();

  $sql = "delete from categories where id = :id";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(":id", $id, PDO::PARAM_INT);
  $ps->execute();
  // $count = $ps->rowCount();

  header("Location: index.php");
} catch (PDOException $e) {
  error_log("PDOException: " . $e->getMessage());
  header("Location: error.php");
}
