<?php
// ① データベースへの接続情報
// hostの部分は、docker-compose.ymlで定義したサービス名「db」を指定します
$dsn = 'mysql:host=db;dbname=gamedb;charset=utf8mb4';
$user = 'root';
$password = 'root';

// ② 接続テスト
try {
    // PDOという仕組みを使ってMySQLに接続します
    $pdo = new PDO($dsn, $user, $password);
    $db_message = "データベース（MySQL）への接続に成功しました！🎉";
} catch (PDOException $e) {
    // 接続に失敗した場合はエラーメッセージを表示します
    $db_message = "データベース接続失敗...: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>My Game Data</title>
</head>
<body>
    <h1>My Game Data アプリ</h1>
    <p>PHPの動作：OK</p>
    <p>DBの動作：<?php echo $db_message; ?></p>
</body>
</html>