<?php
session_start();
include("funcs.php");
sschk();

$pdo = db_conn();

$item_name  = trim($_POST["item_name"] ?? "");
$genre      = $_POST["genre"] ?? "";
$importance = $_POST["importance"] ?? "";
$quantity   = $_POST["quantity"] ?? "";
$memo       = $_POST["memo"] ?? "";

if ($item_name === "") {
    exit("商品名が未入力です。");
}
if (!is_numeric($quantity) || (int)$quantity < 1) {
    exit("数量が不正です。");
}

$sql = "INSERT INTO shopping_items (item_name, genre, importance, quantity, memo)
        VALUES (:item_name, :genre, :importance, :quantity, :memo)";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':item_name',  $item_name,  PDO::PARAM_STR);
$stmt->bindValue(':genre',      $genre,      PDO::PARAM_STR);
$stmt->bindValue(':importance', $importance, PDO::PARAM_STR);
$stmt->bindValue(':quantity',   $quantity,   PDO::PARAM_INT);
$stmt->bindValue(':memo',       $memo,       PDO::PARAM_STR);

$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
} else {
    redirect("select.php");
}