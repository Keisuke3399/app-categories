<?php
require_once("my_functions.php");

$id = (int)filter_input(INPUT_POST, "id");
$title = (string)filter_input(INPUT_POST, "title");

try {
    $pdo = new_pdo();

    $sql = "insert into categories(id, title) values(:id, :title)";

    $ps = $pdo->prepare($sql);
    $ps->bindValue(":id", $id, PDO::PARAM_INT);
    $ps->bindValue(":title", $title, PDO::PARAM_STR);

    $ps->execute();
    $count = $ps->rowCount();

    header("Location: index.php");
} catch (PDOException $e) {
    error_log("PDOException: ") . $e->getMessage();
    header("Location: error.php");
    exit();
}
