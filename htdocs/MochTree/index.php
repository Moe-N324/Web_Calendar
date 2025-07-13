<!DOCTYPE html>
<html lang="ja">
<head>
	<title>MochTree</title>
	<meta charset="utf-8" />
	<link rel="">
	<link rel = "stylesheet" href = "css/pc.css" />
	<script src="scr/holiday_jp.js"></script>
	<!-- script src="scr/script.js"></script-->
	<?php
		date_default_timezone_set('Asia/Tokyo'); 
		if(!isset($_GET['y'])||!isset($_GET['m'])){
			$_GET['y']=date("Y");
			$_GET['m']=date("m");
		}
		$_GET['y'] = $_GET['y']+floor(($_GET['m']-1)/12);
		$_GET['m'] = ($_GET['m']-1)%12+1;
		if($_GET['m']<=0){
			$_GET['m'] = $_GET['m']+12;
		}
		$pdo = new PDO('mysql:dbname=mochtree;host=localhost;' , 'user', 'password');
		$pdo->query('SET NAMES utf8;');

		for($i=1;$i<=31;$i++){
			$stmt=$pdo->prepare("
				SELECT title,color,id 
				FROM yotei 
				WHERE DATE_FORMAT(date, '%Y-%m-%d') = :ymd 
				LIMIT 4
			");
			$stmt->bindValue(':ymd', sprintf('%04d-%02d-%02d',(int)$_GET['y'],(int)$_GET['m'],$i), PDO::PARAM_STR);
			
			$stmt->execute();
			$yotei[$i]=$stmt->fetchAll();
			for($j=count($yotei[$i]); $j<4; $j++){
				$yotei[$i][] = ['0' => '','1'=>'#ffffff','2'=>-1];
			}
		}
	?>
</head> 
<body onload="LoadFunc(<?= $_GET['y'] ?>,<?= $_GET['m'] ?>);">
	<div id = "banner_lef">
		<button id = "today" onclick="setToday()">Today</button>
		<button onclick="reLoad(<?= $_GET['y']?>,<?= $_GET['m']-1 ?>)" title="前月"><</button>
		<button onclick="reLoad(<?= $_GET['y']?>,<?= $_GET['m']+1 ?>)" title="翌月">></button>
		<date id="viewMonth" datetime="2005-03">
			2005年3月
		</date>
	</div>
	<div id = "banner_rig">
		<button onclick="window.location.href='yotei.php?y=<?= $_GET['y']?>&m=<?= $_GET['m'] ?>'" title="予定を作成">＋</button>
	</div>
	<div id = "main">
		<table class = "calendar">
			<thead>
				<tr>
					<th scope = "col" class="r">日</th>
					<th scope = "col">月</th>
					<th scope = "col">火</th>
					<th scope = "col">水</th>
					<th scope = "col">木</th>
					<th scope = "col">金</th>
					<th scope = "col" class="b">土</th>
				</tr>
			</thead>
			<tbody id = "dateBox">

			</tbody>
		</table>
	</div>
	<script>
		let f_date;
		function setToday(){
			var date = new Date();
			var y = date.getFullYear();
			var m = date.getMonth()+1;
			window.location.href=`index.php?y=${y}&m=${m}`;
		}
		function reLoad(y,m){
			var date = new Date(y,m-1,1);
			
			if(y!=date.getFullYear()){
				y = y + Math.floor((m-1)/12);
				m = (m-1)%12+1;
				if(m<=0){
					m+=12;
				}
			}
			window.location.href=`index.php?y=${y}&m=${m}`;
		}
		function LoadFunc(y,m){
			var date = new Date(y,m-1,1);
			
			var btn = document.getElementById("today");
			btn.title = 
				new Intl.DateTimeFormat("ja", {
		    		dateStyle: "full",
		  		}).format(date);

			setCalender(date);
		}
		function setCalender(date){
			let yotei = <?php echo json_encode($yotei, JSON_UNESCAPED_UNICODE); ?>;
			//console.log(yotei);

			var y = date.getFullYear();
			var m = date.getMonth()+1;
			var el = document.getElementById("viewMonth");
			el.datetime = y+"-"+m;
			el.innerHTML = y+"年"+m+"月";
			//alert(y+"/"+m);
			f_date = date;f_date.setDate(1);
			var f_day = f_date.getDay();
			var l_date = date;l_date.setMonth(m,0);
			var tbody = document.getElementById("dateBox");
			
			var t="";
			var x = 1-f_day;
			//alert(x);
			var week=Math.ceil((l_date.getDate()-x+1)/7);
			while(x <= l_date.getDate()){

				t+="<tr class='row"+week+"'>";
				for(let i=1; i<=7; i++){
					t+="<td class='rowbox'><table class='daybox'><tr class='suji_row'>"
					if(x > 0 && x <= l_date.getDate()){
						if(holiday_jp.isHoliday(new Date(y,m-1,x))){
							//alert(y+"/"+(m-1)+"/"+x+" is holiday.");
							t+="<td class='r' id='suji"+x+"'>"+x+"</td>";
						}else{
							switch(i){
								case 1:
									t+="<td class='r' id='suji"+x+"'>"+x+"</td>";
									break;
								case 7:
									t+="<td class='b' id='suji"+x+"'>"+x+"</td>";
									break;
								default:
									t+="<td id='suji"+x+"'>"+x+"</td>";
							}
						}
					}else{
						t+="<td></td>";
					}
					
					t+="</tr>";
					for(let j=0;j<4;j++){
						t+="<tr class='yotei_row' >";
						if(x > 0 && x <= l_date.getDate()){
							if(yotei[x][j][2]!=-1){
								t+=`<td class='yotei' style='background-color:${yotei[x][j][1]};' onclick='window.location.href="shosai.php?id=${yotei[x][j][2]}"'>${yotei[x][j][0]}</td>`;
							}else{
								t+="<td class='yotei'></td>";
							}
						}else{
							t+="<td></td>";
						}
						t+="</tr>";
					}
					t+="</table></td>";
					x++;

				}
				t+="</tr>";
			}

			tbody.innerHTML=t;
		}
	</script>
</body>
</html>