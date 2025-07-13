<!DOCTYPE html>
<html>
<head>
	<title>MochTree</title>
	<?php 
		if(!isset($_POST['title'])){
			$_POST['title'] = "";
		}
		$pdo = new PDO('mysql:dbname=mochtree;host=localhost;' , 'user', 'password');
		$pdo->query('SET NAMES utf8;');

		if($_POST['title'] != "" && $_GET['mode']== "reg"){
			//setdata
			$stmt1 = $pdo->prepare('INSERT INTO yotei(title,date,memo,color,id) VALUE(:title,:date,:memo,:color,:id)');
			
			$stmt1->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
			$stmt1->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
			$stmt1->bindValue(':memo', $_POST['memo'], PDO::PARAM_STR);
			$stmt1->bindValue(':color', $_POST['color'], PDO::PARAM_STR);
			$stmt1->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
			$stmt1->execute();
		}

		if($_GET['mode']=="del"){
			$stmt1 = $pdo->prepare('DELETE FROM yotei WHERE id=:id');
			$stmt1->bindValue(':id', $_GET['id'], PDO::PARAM_STR);
			$stmt1->execute();
		}
		if($_GET['mode']=="upd"){
			$stmt1 = $pdo->prepare('UPDATE yotei SET title=:title,date=:date,memo=:memo,color=:color WHERE id=:id');
			$stmt1->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
			$stmt1->bindValue(':date', $_POST['date'], PDO::PARAM_STR);
			$stmt1->bindValue(':memo', $_POST['memo'], PDO::PARAM_STR);
			$stmt1->bindValue(':color', $_POST['color'], PDO::PARAM_STR);
			$stmt1->bindValue(':id', $_POST['id'], PDO::PARAM_STR);
			$stmt1->execute();
		}
	?>

</head>
<body>
	<script>
		document.addEventListener("DOMContentLoaded",function(e){
			window.location.href="index.php";
		});
	</script>
</body>
</html>