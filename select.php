<?php
session_start();
include("funcs.php");
sschk();

$pdo = db_conn();

$sql = "SELECT * FROM shopping_items ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status === false) {
  sql_error($stmt);
}

$values = $stmt->fetchAll(PDO::FETCH_ASSOC);
$json = json_encode($values, JSON_UNESCAPED_UNICODE);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>買い物リスト一覧</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding:10px;font-size:16px;}</style>
</head>
<body>
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      </div>
      <?= h(($_SESSION["name"] ?? "") . " さん"); ?>
        <?php include("menu.php"); ?>

      </p>
    </div>
  </nav>
</header>

<div class="container jumbotron">
  <h3>買い物リスト一覧</h3>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>ID</th>
        <th>商品名</th>
        <th>ジャンル</th>
        <th>重要度</th>
        <th>数量</th>
        <th>メモ</th>
        <th>更新</th>
        <th>削除</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($values as $v): ?>
        <tr>
          <td><?= h($v["id"] ?? "") ?></td>
          <td><?= h($v["item_name"] ?? "") ?></td>
          <td><?= h($v["genre"] ?? "") ?></td>
          <td><?= h($v["importance"] ?? "") ?></td>
          <td><?= h($v["quantity"] ?? "") ?></td>
          <td><?= h($v["memo"] ?? "") ?></td>

          <td>
            <a class="btn btn-xs btn-primary" href="detail.php?id=<?= h($v["id"] ?? "") ?>">更新</a>
          </td>
          <td>
            <a class="btn btn-xs btn-danger"
               href="delete.php?id=<?= h($v["id"] ?? "") ?>"
               onclick="return confirm('本当に削除しますか？（元に戻せません）');">
               削除
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  const a = <?= $json ? $json : "[]" ?>;
  console.log(a);
</script>

</body>
</html>