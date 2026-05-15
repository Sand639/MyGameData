<?php
// ① データベースへの接続設定
$dsn = 'mysql:host=db;dbname=gamedb;charset=utf8mb4';
$user = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $user, $password);
    $db_message = "データベース接続：OK";

    // ② 【SQL】テーブル（表）を作る (CREATE TABLE)
    // gamesという名前の表を作ります（すでに存在する場合はスキップ）
    $pdo->exec("CREATE TABLE IF NOT EXISTS games (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        status VARCHAR(50) NOT NULL
    )");

    // ③ 【SQL】データを入れる (INSERT)
    // データが0件（空っぽ）の時だけ、初期データを登録します
    $stmt = $pdo->query("SELECT COUNT(*) FROM games");
    if ($stmt->fetchColumn() == 0) {
        $pdo->exec("INSERT INTO games (title, status) VALUES ('Dave the Diver', 'クリア済')");
        $pdo->exec("INSERT INTO games (title, status) VALUES ('ELDEN RING', 'プレイ中')");
        $pdo->exec("INSERT INTO games (title, status) VALUES ('NieR:Automata', '積読')");
    }

    // ④ 【SQL】データを取得する (SELECT)
    // gamesテーブルからすべてのデータを引っ張ってきます
    $stmt = $pdo->query("SELECT * FROM games");
    $games = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    $db_message = "データベース接続失敗...: " . $e->getMessage();
    $games = []; // エラー時は空っぽにしておく
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
    <p><?= htmlspecialchars($db_message, ENT_QUOTES, 'UTF-8') ?></p>

    <hr>
    
    <h2>🎮 ゲームリスト</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>タイトル</th>
            <th>ステータス</th>
        </tr>
        <?php foreach ($games as $game): ?>
        <tr>
            <td><?= htmlspecialchars($game['id'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($game['title'], ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars($game['status'], ENT_QUOTES, 'UTF-8') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>