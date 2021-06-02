<?php

function new_pdo()
{
  $pdo = new PDO("mysql:host=localhost;dbname=nakadb", "root", "root");
  return $pdo;
}
