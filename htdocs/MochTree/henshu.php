<!DOCTYPE html>
<html>
<head>
	<title>MochTree</title>
	<?php
		$pdo = new PDO('mysql:dbname=mochtree;host=localhost;' , 'user', 'password');
		$pdo->query('SET NAMES utf8;');
		$stmt = $pdo->prepare('
			SELECT title,date,color,memo 
			FROM yotei 
			WHERE id=:id 
		');
		$stmt->bindValue(":id",$_GET['id'],PDO::PARAM_STR);
		$stmt->execute();
		$data = $stmt->fetch();
		$title=$data[0];
		$ymd = $data[1];
		$color=$data[2];
		$memo =$data[3];

	?>
</head>
<body>
	<h1>予定を編集</h1>
	<form action="register.php?mode=upd" method="post">
		<input name="color" id="color" type="color"  value="<?=$color?>">
		<input name="title" id="title" type="text" 	 value="<?=$title?>" placeholder="タイトル">
		<input name="date"  id="date"  type="date" 	 value="<?=$ymd?>">
		<input name="memo"  id="memo"  type="text" 	 value="<?=$memo?>" placeholder="メモ">
		<input name="id"    id="id"    type="hidden" value="<?=$_GET['id']?>">
		<input type="submit">
	</form>
</body>
</html>