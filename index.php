<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELCOME TO BBS HOMEPAGE</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/hpstyle.css">
    <script src="js/main.js"></script>
</head>

<body>
    <div class="container">
        <div class="content">
            <h1 class="title">BBSホームページへようこそ！
            </h1>
            <p class="info">
                この掲示板は、簡易的な掲示板システムです。<br>
                新規投稿や編集、削除などの操作が可能です。<br>
                詳細な使い方については<a href="read.php?id=1">こちら</a>をご覧ください。
            </p>
            <div class="opt">
                <a href="create.php" class="btn">新規作成</a>
                <a href="#" class="btn" id="viewBtn">閲覧</a>
            </div>
        </div>

        <div class="documentation" id="bbsTable">
            <h2>掲示板一覧</h2>
            <p>以下は現在の掲示板の一覧です。</p>
            <table>
                <thead>
                    <tr>
                        <th>投稿日付</th>
                        <th>タイトル</th>
                        <th>副タイトル</th>
                        <th>投稿者</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $dataFile = 'data.json';// データファイルのパス
                    $posts = [];// 初期化
                    if (file_exists($dataFile)) {// ファイルが存在する場合
                        $json = file_get_contents($dataFile);// ファイルの内容を取得
                        $posts = json_decode($json, true) ?: [];// JSONを配列に変換
                    }
                    if (!empty($posts)) {// 投稿がある場合
                        foreach ($posts as $post): //ループして各投稿を表示
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($post['date']) ?></td>
                                <td><?= htmlspecialchars($post['title']) ?></td>
                                <td><?= htmlspecialchars($post['subtitle']) ?></td>
                                <td><?= htmlspecialchars($post['author']) ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $post['id'] ?>" class="btn">編集</a>
                                    <a href="delete.php?id=<?= $post['id'] ?>" class="btn" id="deleteBtn">削除</a>
                                    <a href="read.php?id=<?= $post['id'] ?>" class="btn">詳細</a>
                                </td>
                            </tr>
                        <?php endforeach;
                    } else { ?>
                        <tr>
                            <td colspan="5" style="text-align:center;">投稿はありません。</td>
                        </tr>
                    <?php } ?>
                </tbody>　
            </table>
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