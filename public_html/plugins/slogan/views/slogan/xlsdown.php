
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />	<title>
		연구개발특구 포스터&amp;슬로건 공모전	</title>
</head>

<body>


<style type="text/css">
table {
	border-collapse: collapse;
	border:1px solid #f5f5f5;
	text-align: center;
	margin:0 auto;
}

table th {
	border:1px solid #f5f5f5;
	text-align: center;
	padding:5px;
}
table td{
	border-collapse: collapse;
	border:1px solid #f5f5f5;
	padding:5px;	
}

h2 {
	line-height: 20pt;
	margin: 20px auto;
	width:200px;
	text-align: center;
}

</style>
<h2>포스터&amp;슬로건 공모전</h2>
<table border='1'>
<tr>
<th>번호</th>
<th>이름</th>
<th>이메일</th>
<th>소속기관</th>
<th>연락처</th>
<th>슬로건 명</th>
<th>슬로건 설명</th>
</tr>
<?php foreach($rows as $row):?>

<tr>
<td><?=$row['Slogan']['id']?></td>
<td><?=$row['Slogan']['name']?></td>
<td><?=$row['Slogan']['email']?></td>
<td><?=$row['Slogan']['organization']?></td>
<td><?=$row['Slogan']['phone']?></td>
<td><?=$row['Slogan']['slogan']?></td>
<td><?=$row['Slogan']['description']?></td>
</tr>

<?php endforeach;?>
</table>

</body>
</html>