//「閉じる」ボタンの切り替えファンクション
document.addEventListener("DOMContentLoaded", function () {
    var viewBtn = document.getElementById('viewBtn');// 展示ボタン
    var bbsTable = document.getElementById('bbsTable');// 隠されたテーブル
    var originalText = viewBtn ? viewBtn.textContent : '';// ボタンの元のテキストを保存
    var open = 0; // コメント一覧の表示状態を記録するフラグ

    // 状態に応じて表示・非表示とボタンテキストを切り替え
    function updateCommentsView() {
        if (!viewBtn || !bbsTable) return;// viewBtn または bbsTable が存在しない場合は何もしない
        if (open === 1) {// コメント一覧が開いている場合
            bbsTable.style.display = 'block';// コメント一覧を表示
            viewBtn.textContent = '閉じる';// ボタンのテキストを「閉じる」に変更
        } else {
            bbsTable.style.display = 'none';// コメント一覧を非表示
            viewBtn.textContent = originalText;// ボタンのテキストを元に戻す
        }
    }

    // ページロード時 open=1 なら開く
    var params = new URLSearchParams(window.location.search);// URLのクエリパラメータを取得
    if (params.get('open') === '1') {
        open = 1;
    } else {
        open = 0;
    }
    updateCommentsView();// 初期状態を更新

    // ボタンクリックでトグル
    if (viewBtn && bbsTable) {
        viewBtn.addEventListener('click', function (e) {
            e.preventDefault();
            open = open === 1 ? 0 : 1;
            updateCommentsView();
            if (open === 1) {
                bbsTable.scrollIntoView({ behavior: 'smooth' });
                // コメント一覧を開いた場合はopen=1をURLに追加
                var url = new URL(window.location);
                url.searchParams.set('open', '1');
                history.replaceState(null, '', url);
            } else {
                // 閉じた場合はopenパラメータをURLから削除
                var url = new URL(window.location);
                url.searchParams.delete('open');
                history.replaceState(null, '', url);
            }
        });
    } else {
        console.warn('viewBtn または bbsTable がDOMに見つかりませんでした。');
    }



    // イースターエッグ：空白部分を5回クリックすると一度だけ表示
    var egg = document.getElementById('rizen-easter-egg');// イースターエッグの要素を取得
    var eggClickCount = 0;// クリックカウントを初期化
    var eggShown = false;// イースターエッグが表示されたかどうかのフラグを初期化

    document.body.addEventListener('click', function (e) {
        // ボタンやリンクなどのインタラクティブ要素は除外
        if (
            e.target.closest('a') ||// リンクである場合
            e.target.closest('button') ||// ボタンである場合
            e.target.closest('input') ||// 入力フィールドである場合
            e.target.closest('textarea') ||// テキストエリアである場合
            e.target.closest('select')// セレクトボックスである場合
        ) {
            return;// クリックされた要素がインタラクティブな要素である場合は何もしない
        }
        if (eggShown) return;// 既に表示されている場合は何もしない
        eggClickCount++;// カウントを増やす
        if (eggClickCount >= 5) {
            eggShown = true;// イースターエッグが表示されたことを記録
            if (egg) {
                egg.style.display = 'block';// イースターエッグを表示
                setTimeout(function () {
                    egg.style.opacity = 1;// イースターエッグの透明度を1に設定
                    egg.style.transform = "translateX(-50%) scale(1.08)";// アニメーションの効果を適用
                }, 10);
                setTimeout(function () {
                    egg.style.opacity = 0;// イースターエッグの透明度を0に設定
                    egg.style.transform = "translateX(-50%) scale(1)";// アニメーションの効果を元に戻す
                    setTimeout(function () {
                        egg.style.display = 'none';// イースターエッグを非表示
                    }, 400);
                }, 2200); // 2.2秒間表示
            }
        }
    });
});