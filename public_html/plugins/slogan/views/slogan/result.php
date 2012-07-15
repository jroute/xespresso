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
	background-color: #fafafa;
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
p {
	padding:10px;
	text-align: center;
}

</style>
<h2>포스터&amp;슬로건 공모전</h2>
<table border='1'>
<tr>
<th>삭제</th>
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
<td><?=$html->link('삭제',array('action'=>'delete',$row['Slogan']['id']),null,'삭제하시겠습니까?');?></td>
<td><?=$row['Slogan']['id']?></td>
<td><?=$row['Slogan']['name']?></td>
<td><?=$row['Slogan']['email']?></td>
<td><?=$row['Slogan']['organization']?></td>
<td><?=$row['Slogan']['phone']?></td>
<td style="padding:5px 20px 5px 20px;font-weight:bold"><?=$row['Slogan']['slogan']?></td>
<td style="text-align:left;"><?=nl2br(htmlspecialchars($row['Slogan']['description']))?></td>
</tr>

<?php endforeach;?>
</table>

<p>
<a href="/slogan/xlsdown">엑셀파일 다운로드</a>
</p>