<html>
<?php
$dataFile = 'data.json';// データファイルのパス
// データファイルが存在しない場合は空の配列を初期化
$posts = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);// ファイルの内容を取得
    $posts = json_decode($json, true) ?: [];// JSONを配列に変換

}
$id = $_GET['id'] ?? null; // URL参数からIDを取得

// IDが指定されていれば該当投稿を探す
$target = null;
if ($id) {
    foreach ($posts as $post) {// 各投稿をループ処理
        if ($post['id'] == $id) {// IDが一致する投稿を探す
            $target = $post;// 見つかった投稿を保存
            break;// ループを抜ける
        }
    }
}
// POSTリクエストで編集が送信された場合
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];// 投稿IDを取得
    $title = trim($_POST['title'] ?? '');// タイトルを取得
    $author = trim($_POST['author'] ?? '');// 投稿者名を取得
    $content = trim($_POST['content'] ?? '');// 内容を取得
    $date = trim($_POST['date'] ?? '');// 日付を取得
    $subtitle = trim($_POST['subtitle'] ?? '');// 副タイトルを取得

    // 入力チェック
    if ($title === '' || $author === '' || $content === '' || $date === '') {
        $message = 'タイトル・投稿者・内容・日付は必須です。';

    } else {
        foreach ($posts as &$post) {// 投稿をループして該当の投稿を探す
            if ($post['id'] == $post_id) {// 投稿IDが一致する場合
                $post['title'] = $title;// タイトルを更新
                $post['subtitle'] = $subtitle;// 副タイトルを更新
                $post['author'] = $author;// 投稿者名を更新
                $post['date'] = $date;// 日付を更新
                $post['content'] = $content;// 内容を更新
                break;
            }
        }
        unset($post);// 参照を解除
        file_put_contents($dataFile, json_encode($posts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));// 更新されたデータをファイルに保存
        header('Location: read.php?id=' . urlencode($post_id));// 編集後、該当の投稿の詳細ページへリダイレクト
        exit;// 投稿編集完了後はリダイレクト
    }
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- タイトル -->
    <title>投稿編集 - BBS</title>
    <!-- CSSファイルの読み込み -->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/edit.css">
    <!-- JavaScriptファイルの読み込み -->
    <script src="js/main.js"></script>
</head>

<body>
    <!-- ヘッダーバー -->
    <div class="header-bar"></div>
    <div class="decor-bar green"></div>
    <div class="decor-bar blue"></div>
    <!-- コンテナ -->
    <div class="container">
        <!-- コンテンツ -->
        <div class="content">
            <!-- タイトル -->
            <h1 class="title">投稿編集</h1>
            <!-- 投稿編集フォーム -->
            <form action="edit.php?id=<?php echo htmlspecialchars($target['id'], ENT_QUOTES, 'UTF-8'); ?>" method="post"
                id="editForm">
                <!-- 投稿IDの隠しフィールド -->
                <input type="hidden" name="post_id"
                    value="<?php echo htmlspecialchars($target['id'], ENT_QUOTES, 'UTF-8'); ?>">
                <!-- 各フィールドの入力フォーム -->
                <div class="form-group">
                    <label for="title">タイトル:</label>
                    <input type="text" id="title" name="title"
                        value="<?php echo htmlspecialchars($target['title'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="subtitle">副タイトル:</label>
                    <input type="text" id="subtitle" name="subtitle"
                        value="<?php echo htmlspecialchars($target['subtitle'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                </div>
                <div class="form-group">
                    <label for="author">投稿者:</label>
                    <input type="text" id="author" name="author"
                        value="<?php echo htmlspecialchars($target['author'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required>
                </div>
                <div class="form-group">
                    <label for="date">日付:</label>
                    <input type="date" id="date" name="date" value="<?php
                    $date = $target['date'] ?? '';
                    // 日付のフォーマットを変換
                    $date = str_replace('/', '-', $date);
                    echo htmlspecialchars($date !== '' ? $date : date('Y-m-d'), ENT_QUOTES, 'UTF-8');
                    ?>">
                </div>
                <div class="form-group">
                    <label for="content">内容:</label>
                    <textarea id="content" name="content" rows="7"
                        required><?php echo htmlspecialchars($target['content'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">編集する</button>
                    <a href="index.php" class="btn">キャンセル</a>
                </div>
            </form>
            <?php if (!$target): ?>
                <p style="color:red;">投稿が見つかりません。</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- イースターエッグ -->
    <div id="rizen-easter-egg"
        style="display:none;position:fixed;left:50%;bottom:32px;transform:translateX(-50%) scale(1);background:#318af7;color:#fff;border-radius:24px;padding:16px 32px;font-size:1.1em;box-shadow:0 4px 16px rgba(49,138,247,0.15);z-index:9999;text-align:center;transition:opacity 0.3s,transform 0.3s;opacity:0;pointer-events:none;">
        <span style="font-family:'Segoe Script','Comic Sans MS',cursive;font-size:1.1em;">✨ made by <b
                style='color:#ffd966;'>Rizen（黄）</b> ✨</span>
    </div>
    <!-- デコレーションバー -->
    <div class="decor-bar green right-bottom"></div>
    <div class="decor-bar blue right-bottom"></div>
</div>

</body>
<?php if (!empty($_GET['message'])): ?>
    <script>
        alert("<?php echo addslashes($_GET['message']); ?>");
    </script>
<?php endif; ?>

</html>