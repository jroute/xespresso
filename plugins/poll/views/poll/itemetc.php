<div class="edu_write" style="table-layout:fixed;" >


<table class='tbl-list'>
<col width='10%' />
<col width='*' />
<col width='15%' />
<tr>
<th>아이디</th>
<th>내용</th>
<th>등록일</th>
</tr>

<?php foreach($this->data as $row):?>
<tr>
<td><?=$row['PollAnswer']['userid']?></td>
<td class='left'><?=$row['PollAnswer']['item_etc']?></td>
<td><?=substr($row['PollAnswer']['created'],2,14)?></td>
</tr>
<?php endforeach;?>
</table>

</div>