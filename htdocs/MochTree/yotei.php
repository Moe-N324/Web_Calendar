<!DOCTYPE html>
<html>
<head>
	<title>MochTree</title>
	<?php
		if(!isset($_GET['y'])||!isset($_GET['m'])){
			$ymd=sprintf("%04d-%02d-%02d",0,0,0);
		}else{
			$ymd=sprintf("%04d-%02d-%02d",(int)$_GET['y'],(int)$_GET['m'],1);
		}
		$pdo = new PDO('mysql:dbname=mochtree;host=localhost;' , 'user', 'password');
		$pdo->query('SET NAMES utf8;');
		$stmt = $pdo->prepare('SELECT id FROM yotei ORDER BY id DESC LIMIT 1');
		$stmt->execute();
		$num = $stmt->fetch();
		$num = $num[0]+1;

	?>
</head>
<body>
	<h1>予定を作成</h1>
	<form action="register.php?mode=reg" method="post">
		<input name="color" id="color" type="color">
		<input name="title" id="title" type="text" 	 placeholder="タイトル">
		<input name="date"  id="date"  type="date" 	 value="<?=$ymd?>">
		<input name="memo"  id="memo"  type="text" 	 placeholder="メモ">
		<input name="id"    id="id"    type="hidden" value="<?=$num?>">
		<input type="submit">
	</form>
</body>
</html>