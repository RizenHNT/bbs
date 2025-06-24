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


// コメント投稿処理
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['comment'], $_POST['user'])) {// POSTリクエストでコメントが送信された場合
    $post_id = $_POST['post_id'];// 投稿IDを取得
    $comment = trim($_POST['comment']);// コメント内容を取得
    $user = trim($_POST['user']);// ユーザー名を取得
    if ($post_id && $comment && $user) {// 投稿ID、コメント内容、ユーザー名がすべて存在する場合
        foreach ($posts as &$post) {
            if ($post['id'] == $post_id) {// 投稿IDが一致する投稿を探す
                if (!isset($post['comments']) || !is_array($post['comments'])) {// コメントがまだない場合
                    $post['comments'] = [];// コメント配列を初期化
                }
                $post['comments'][] = [// コメントを追加
                    'commentDate' => date('Y/m/d'),// コメント日時を現在の日付に設定
                    'comment' => $comment,// コメント内容
                    'user' => $user,// ユーザー名
                ];
                break;
            }
        }
        unset($post);
        file_put_contents($dataFile, json_encode($posts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        // 成功提示
        $message = 'コメントを追加しました！';
    } else {
        $message = 'コメント内容と名前を入力してください。';
    }
    // POST後リダイレクト（多重投稿防止＋GETでメッセージ表示）
    header('Location: read.php?id=' . urlencode($post_id) . '&message=' . urlencode($message) . '&open=1');//id,メッセージ、openパラメータをURLに追加
    exit;
}

// コメント削除処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'], $_POST['del_comment'])) {
    $post_id = $_POST['post_id'];
    $del_index = $_POST['del_comment'];
    foreach ($posts as &$post) {
        if ($post['id'] == $post_id) {
            if (isset($post['comments'][$del_index])) {
                unset($post['comments'][$del_index]);
                // インデックスを再振分
                $post['comments'] = array_values($post['comments']);
            }
            break;
        }
    }
    unset($post);
    file_put_contents($dataFile, json_encode($posts, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    // 成功提示
    $message = 'コメントを削除しました！';
    // POST後リダイレクト
    header('Location: read.php?id=' . urlencode($post_id) . '&message=' . urlencode($message) . '&open=1');
    exit;
}

// GETでメッセージ取得
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($target['title'] ?? ''); ?> - BBS</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/blog.css">
    <script src="js/main.js"></script>
</head>

<body>
    <!-- ヘッダーバー -->
    <div class="header-bar"></div>
    <div class="decor-bar green"></div>
    <div class="decor-bar blue"></div>
    <!-- メインコンテンツ -->
    <div class="container">
        <div class="content">
            <h1 class="bbs-passage-title">
                <?php echo htmlspecialchars($target['title'] ?? ''); ?><!-- タイトル -->
            </h1>
            <!-- 投稿者情報 -->
            <div class="bbs-passage-authorMsg">
                <p>作者: <span class="author">
                        <?php echo htmlspecialchars($target['author'] ?? ''); ?></span></p>
                </span></p>
                <p class="bbs-passage-date">作成日: <?php echo htmlspecialchars($target['date'] ?? ''); ?></p>
            </div>
            <!-- 副タイトルと内容 -->
            <p class="bbs-passage-subtitle">
                <?php echo htmlspecialchars($target['subtitle'] ?? ''); ?><!-- 副タイトル -->
            </p>
            <!-- 内容 -->
            <div class="bbs-passage-text">
                <?php echo $target['content'] ?? ''; ?>
            </div>
            <!-- 操作ボタン -->
            <a href="index.php" class="btn">戻る</a>
            <a class="btn" id="viewBtn">コメント一覧</a>
        </div>
        <!-- コメント一覧 -->
        <div class="documentation" id="bbsTable">
            コメント一覧：
            <table>
                <thead>
                    <tr>
                        <th>コメント日時</th>
                        <th>コメント内容</th>
                        <th>投稿者</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- コメントがない場合の処理 -->
                    <?php if (empty($target['comments'])): ?>
                        <tr>
                            <td colspan="4" style="text-align:center; color:#888;">コメントはありません。</td>
                        </tr>
                    <?php else:
                        foreach ($target['comments'] as $idx => $comment): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($comment['commentDate']); ?></td><!-- コメント日時 -->
                                <td><?php echo nl2br(htmlspecialchars($comment['comment'])); ?></td><!-- コメント内容 -->
                                <td><?php echo htmlspecialchars($comment['user']); ?></td><!-- 投稿者 -->
                                <td>
                                    <form action="read.php?id=<?php echo htmlspecialchars($target['id']); ?>" method="post"
                                        style="display:inline;">
                                        <input type="hidden" name="post_id"
                                            value="<?php echo htmlspecialchars($target['id']); ?>">
                                        <input type="hidden" name="del_comment" value="<?php echo $idx; ?>">
                                        <button type="submit" class="btn" id="deleteBtn">削除</button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                    endif;
                    ?>
                </tbody>
            </table>
            <!-- フォームでコメントを追加 -->
            <form action="read.php?id=<?php echo htmlspecialchars($target['id']); ?>" method="post">
                <input type="hidden" name="post_id" value="<?php echo htmlspecialchars($target['id']); ?>">
                <input type="text" name="comment" placeholder="コメントを入力してください" class="comment-input" required>
                <input type="text" name="user" placeholder="名前を入力してください" class="comment-name" required>
                <input type="submit" class="comment-btn" value="コメントする">
            </form>
        </div>
    </div>

    <!-- イースターエッグ -->
    <div id="rizen-easter-egg"
        style="display:none;position:fixed;left:50%;bottom:32px;transform:translateX(-50%) scale(1);background:#318af7;color:#fff;border-radius:24px;padding:16px 32px;font-size:1.1em;box-shadow:0 4px 16px rgba(49,138,247,0.15);z-index:9999;text-align:center;transition:opacity 0.3s,transform 0.3s;opacity:0;pointer-events:none;">
        <span style="font-family:'Segoe Script','Comic Sans MS',cursive;font-size:1.1em;">✨ made by <b
                style='color:#ffd966;'>Rizen（黄）</b> ✨</span>
    </div>
    <!-- メッセージ表示 -->
    <?php if ($message): ?>
        <script>
            alert("<?php echo addslashes($message); ?>");
        </script>
    <?php endif; ?>
    <!-- デコレーションバー -->
    <div class="decor-bar green right-bottom"></div>
    <div class="decor-bar blue right-bottom"></div>
</body>

</html>