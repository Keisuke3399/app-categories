<?php

$id = (int)filter_input(INPUT_POST, "id");
$title = (string)filter_input(INPUT_POST, "title");

try{
  require_once("my_functions.php");
  $pdo = new_pdo();
  $sql = "update categories set title = :title where id = :id";
  $ps = $pdo->prepare($sql);
  $ps->bindValue(":title", $title, PDO::PARAM_STR);
  $ps->bindValue(":id", $id, PDO::PARAM_INT);
  $ps->execute();

  header("Location: index.php");
} catch(PDOException $e){
error_log("PDOException: " . $e->getMessage());
header("Location: error.php");
}