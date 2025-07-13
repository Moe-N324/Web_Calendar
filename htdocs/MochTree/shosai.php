<!DOCTYPE html>
<html lang="ja">
<head>
	<title>MochTree</title>
	<script>
	<?php
		if(!isset($_GET['id'])){
			echo "alert('idが無効です。ページを開くことができません。');";
			$_GET['id']=0;
		}
	?>
	</script>
	<?php 
		$pdo = new PDO('mysql:dbname=mochtree;host=localhost;' , 'user', 'password');
		$pdo->query('SET NAMES utf8;');
		$stmt=$pdo->prepare("
			SELECT title,date,memo,color
			FROM yotei 
			WHERE id=:id 
		");
		$stmt->bindValue(":id",$_GET['id'],PDO::PARAM_STR);
		$stmt->execute();
		$yotei=$stmt->fetch();
	?>
</head>
<body>
	<div id="banner">
		<button onclick="window.location.href='henshu.php?id=<?=$_GET['id']?>'">編集</button>
		<button onclick="window.location.href='register.php?mode=del&id=<?=$_GET['id']?>'">削除</button>
	</div>
	<div id="title">
		<h1><?=$yotei[0]?></h1>
	</div>
	<div id="date">
		日付：<?=$yotei[1]?>
	</div>
	<div id="memo">
		メモ：<?=$yotei[2]?>
	</div>
</body>
</html>