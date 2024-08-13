function startTime()
{ 	var today=new Date();
	var weekday=new Array(7);
	var weekday=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	var monthname=new Array(12);
	var monthname=["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
	var dayname=weekday[today.getDay()];
	var day=today.getDate();
	var month=monthname[today.getMonth()]; 
	var year=today.getFullYear();
	var h=today.getHours();
	var m=today.getMinutes();
	var s=today.getSeconds();
	h=checkTime(h);
	m=checkTime(m);
	s=checkTime(s);
	document.getElementById('clocktime').innerHTML=dayname+", "+day+"-"+month+"-"+year+", "+h+":"+m+":"+s;
	t=setTimeout(function(){startTime()},500);
}
// function checkTime to add a zero in front of numbers&lt;10
function checkTime(i)
{	if(i<10){i="0"+i;}
	return i;
}