let f_date;
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
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	var el = document.getElementById("viewMonth");
	el.datetime = y+"-"+m;
	el.innerHTML = y+"年"+m+"月";
	//alert(y+"/"+m);
	f_date = date;f_date.setDate(1);
	var f_day = f_date.getDay();
	var l_date = date;l_date.setMonth(m+1,0);
	var tbody = document.getElementById("dateBox");
	
	var t="";
	var x = 1-f_day;
	//alert(x);

	while(x <= l_date.getDate()){

		t+="<tr class='row'>";
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
			t+="<tr class='yotei_row' >";
			if(x > 0 && x <= l_date.getDate()){
				t+="<td class='yotei' id='yotei"+x+"'></td>";
			}else{
				t+="<td></td>";
			}
			t+="</tr>";
			t+="</table></td>";
			x++;

		}
		t+="</tr>";
	}

	tbody.innerHTML=t;
}

function setPrevMonth(){
	var date = f_date;
	date.setMonth(date.getMonth()-1,1);
	setCalender(date);
}

function setNextMonth(){
	var date = f_date;
	date.setMonth(date.getMonth()+1,1);
	setCalender(date);
}