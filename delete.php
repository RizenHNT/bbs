<html>  
<?php
$dataFile = 'data.json'; // データファイルのパス
$posts = [];
$message = ''; // メッセージ初期化
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);// ファイルの内容を取得
    $posts = json_decode($json, associative: true) ?: [];//associative: trueを使用して配列を連想配列として取得
}

// 削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    // POSTリクエストで削除が送信された場合
    $post_id = $_POST['post_id'];// 投稿IDを取得
    $newPosts = [];// 新しい投稿配列を初期化
    foreach ($posts as $post) {
        if ($post['id'] != $post_id) {
            $newPosts[] = $post;
        }
    }
    file_put_contents($dataFile, json_encode($newPosts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    // 删除后跳转并带提示
    header('Location: index.php?message=' . urlencode('投稿を削除しました！'));
    exit;
}

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>削除確認 - BBS</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/main.js"></script>
</head>
<body>
    <div class="container">
        <div class="content">
            <h1 class="title">削除確認</h1>
            <p>本当にこの投稿を削除しますか？</p>
            <form action="delete.php?id=<?php echo htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" method="post" id="deleteForm">
                <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($_GET['id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="btn" id="deleteBtn">削除する</button>
                <a href="index.php" class="btn">戻る</a>
            </form>
        </div>
    </div>
    <!-- イースターエッグ --> <!-- イースターエッグ -->
    <div id="rizen-easter-egg"
         style="display:none;position:fixed;left:50%;bottom:32px;transform:translateX(-50%) scale(1);background:#318af7;color:#fff;border-radius:24px;padding:16px 32px;font-size:1.1em;box-shadow:0 4px 16px rgba(49,138,247,0.15);z-index:9999;text-align:center;transition:opacity 0.3s,transform 0.3s;opacity:0;pointer-events:none;">
        <span style="font-family:'Segoe Script','Comic Sans MS',cursive;font-size:1.1em;">✨ made by <b style='color:#ffd966;'>Rizen（黄）</b> ✨</span>
    </div>
</div>
<?php if (!empty($_GET['message'])): ?>
<script>
    alert("<?php echo addslashes($_GET['message']); ?>");
</script>
<?php endif; ?>
</body>
</html>