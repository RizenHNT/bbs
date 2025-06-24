<?php
$dataFile = 'data.json';
$posts = [];
if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $posts = json_decode($json, true) ?: [];
}

$message = '';

// 新規投稿処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $subtitle = trim($_POST['subtitle'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $date = trim($_POST['date'] ?? '');
    $content = trim($_POST['content'] ?? '');
    // 日付のフォーマットを変換
    $date = str_replace('/', '-', $date);

    // 入力チェック
    if ($title === '' || $author === '' || $content === '' || $date === '') {
       header('Location: create.php?message=' . urlencode('タイトル・投稿者名・内容・日付は必須です。'));
        exit;  
    } else {
        $newPost = [
            'id' => uniqid(),
            'title' => $title,
            'subtitle' => $subtitle,
            'author' => $author,
            'date' => $date,
            'content' => $content,
            'comments' => []
        ];
        $posts[] = $newPost;
        file_put_contents($dataFile, json_encode($posts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        header('Location: index.php?message=' . urlencode('新規投稿が完了しました！'));
        exit;
    }
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規投稿 - BBS</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/edit.css">
    <script src="js/main.js"></script>
</head>

<body>
    <div class="container">
        <div class="content">
            <h1 class="title">新規投稿</h1>
            <form action="create.php<?php echo isset($post_id) ? '?id=' . $post_id : ''; ?>" method="post"
                id="createForm">
                <div class="form-group">
                    <label for="title">タイトル:</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="subtitle">副タイトル:</label>
                    <input type="text" id="subtitle" name="subtitle">
                </div>
                <div class="form-group">
                    <label for="author">投稿者名:</label>
                    <input type="text" id="author" name="author" required>
                </div>
                <div class="form-group">
                    <label for="date">日付:</label>
                    <input type="date" id="date" name="date" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group">
                    <label for="content">内容:</label>

                    <textarea id="content" name="content" rows="7" required></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn">投稿する</button>
                    <a href="index.php" class="btn">戻る</a>
                </div>
            </form>
        </div>
    </div>
    <!-- イースターエッグ -->
    <div id="rizen-easter-egg"
        style="display:none;position:fixed;left:50%;bottom:32px;transform:translateX(-50%) scale(1);background:#318af7;color:#fff;border-radius:24px;padding:16px 32px;font-size:1.1em;box-shadow:0 4px 16px rgba(49,138,247,0.15);z-index:9999;text-align:center;transition:opacity 0.3s,transform 0.3s;opacity:0;pointer-events:none;">
        <span style="font-family:'Segoe Script','Comic Sans MS',cursive;font-size:1.1em;">✨ made by <b
                style='color:#ffd966;'>Rizen（黄）</b> ✨</span>
    </div>
</body>
<?php if (!empty($_GET['message'])): ?>
<script>
    alert("<?php echo addslashes($_GET['message']); ?>");
</script>
<?php endif; ?>
</html>