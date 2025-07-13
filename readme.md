## Mochtree Calender の 使い方
##### 注意事項
- 作成者の 環境である Windows の XAMPP を つかう場合について 書いています．
- その他の 環境については ご自身で 調べたうえで 実行してください．

#### XAMPPでの 構築の 仕方
1. XAMPP の `C://xampp/htdocs/` と `C://xampp/mysql/` に `htdocs` と `mysql` 内の フォルダーを 移動する．

1. 以下の SQL文を `localhost/phpmyadmin` から実行する．
```
CREATE USER 'user'@'localhost' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE, DELETE ON mochtree.* TO 'user'@'localhost';
```
3. `localhost/mochtree/index.php`から 開く．