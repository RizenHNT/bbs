# PHP 简易BBS系统

这是一个用 PHP 和 JSON 文件实现的简易BBS（论坛）系统，作为求职课题作业开发。**所有代码和数据均为个人原创，无任何企业机密。**

## 功能简介

- 帖子列表浏览
- 帖子详情查看
- 新建帖子
- 编辑帖子
- 删除帖子
- 评论的添加与删除
- 数据持久化到 `data.json`
- 必填项校验与弹窗提示
- 简单的页面样式和小彩蛋

## 运行方法

1. 将本项目文件夹放到本地 PHP 环境（如 XAMPP、Laragon、phpstudy 等）的 `www` 目录下。
2. 启动本地服务器。
3. 在浏览器访问 `http://localhost/bbs/index.php` 即可使用。

## 文件结构

```
bbs/
├── index.php         # 帖子列表页
├── read.php          # 帖子详情与评论页
├── create.php        # 新建帖子页
├── edit.php          # 编辑帖子页
├── delete.php        # 删除帖子页
├── data.json         # 所有数据存储文件
├── css/              # 样式文件夹
├── js/               # JS 文件夹
```

## 注意事项

- 本项目仅用于学习和展示，未做安全加固，不建议用于生产环境。
- 如需重置数据，可直接编辑或清空 `data.json` 文件。

## 作者

- HUANG（RIZEN）
- 邮箱：lixuandk@gmail.com

---

> 本项目为个人课题作业，欢迎参考和学习！


# PHP簡易BBSシステム / Simple PHP BBS System

これはPHPとJSONファイルで作成した簡易掲示板（BBS）システムです。求職課題として個人で開発しました。**全てのコードとデータはオリジナルであり、企業機密は一切含まれていません。**

This is a simple BBS (Bulletin Board System) built with PHP and JSON file storage. It was developed as a job application assignment. **All code and data are original and contain no company confidential information.**

---

## 主な機能 / Main Features

- 投稿一覧表示 / Post list view
- 投稿詳細・コメント表示 / Post details and comments
- 新規投稿 / Create new post
- 投稿編集 / Edit post
- 投稿削除 / Delete post
- コメント追加・削除 / Add and delete comments
- データは `data.json` に保存 / Data stored in `data.json`
- 必須項目チェックとアラート表示 / Required field validation and alert
- シンプルなデザインとイースターエッグ / Simple design and easter egg

---

## 使い方 / How to Run

1. プロジェクトフォルダをローカルのPHP環境（XAMPP, Laragon, phpstudy等）の `www` ディレクトリに配置します。  
   Place the project folder in your local PHP environment's `www` directory (e.g., XAMPP, Laragon, phpstudy).
2. サーバーを起動します。  
   Start your local server.
3. ブラウザで `http://localhost/bbs/index.php` にアクセスします。  
   Access `http://localhost/bbs/index.php` in your browser.

---

## ファイル構成 / File Structure

```
bbs/
├── index.php         # 投稿一覧 / Post list
├── read.php          # 詳細・コメント / Post details & comments
├── create.php        # 新規投稿 / Create post
├── edit.php          # 編集 / Edit post
├── delete.php        # 削除 / Delete post
├── data.json         # データ保存 / Data storage
├── css/              # スタイル / CSS
├── js/               # JavaScript
```

---

## 注意事項 / Notes

- 本システムは学習・デモ用です。セキュリティ対策は十分ではありません。  
  This system is for learning/demo purposes. Security is not fully implemented.
- データをリセットしたい場合は `data.json` を編集または削除してください。  
  To reset data, edit or delete `data.json`.

---

## 作者 / Author

- HUANG (HinataTakuya)
- Email: lixuandk@gmail.com

---

> 本プロジェクトは個人課題作品です。ご自由にご参考ください。  
> This project is a personal assignment. Feel free to use or reference it.
