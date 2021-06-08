<?php
require_once("../categories/my_functions.php");

$id = (int)filter_input(INPUT_POST, "id");
$password = (string)filter_input(INPUT_POST, "password");

try {
  $pdo = new_pdo();
  $sql = "select * from users where id = :id and password = :password";

  $ps = $pdo->prepare($sql);
  $ps->bindValue(":id", $id, PDO::PARAM_INT);
  $ps->bindValue(":password", $password, PDO::PARAM_STR);
  $ps->execute();
  $user = $ps->fetch();
// var_dump($user);
// die('test');
} catch (PDOException $e) {
  error_log("PDOException: " . $e->getMessage());
  // exit();
}
  $message = "NG";
if ($user !== false) {
  $message = "OK";
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <title>Document</title>
</head>
<body>
  <?= $message ?>
</body>
</html>