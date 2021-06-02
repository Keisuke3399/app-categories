<?php

function new_pdo()
{
  $options = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES => false
  ];
  $pdo = new PDO("mysql:host=localhost;dbname=nakadb", "root", "root", $options);
  return $pdo;
}
