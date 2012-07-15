
<?=$javascript->link('zipfinder',false)?>

<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<div id="content">

<?=$form->create("User",array("action"=>$this->action,'id'=>'user-form'))?>
<?=$form->hidden("uno")?>

<table class='tbl'>
<col width="15%" />
<col width="*" />
<col width="15%" />
<col width="*" />
<?php if($this->data['User']['level']){
	$levtmp= $this->data['User']['level'];	
}else{
	$levtmp= 1;	
}
?>
<tr>
<th>권한</th>
<td colspan="3"><?=$level[$this->data['User']['level']]?></td>
</tr>



<tr>
<th>그룹</th>
<td colspan="3">
<?=@$gdata[$this->data['User']['grpid']]?>

</td>
</tr>

<tr>
<th>아이디</th>
<td class='inputsignred'>
	<?=$this->data['User']['userid']?>
</td>
<th>비밀번호</th>
<td class='inputsignred'>******</td>
</tr>
<tr>
<th>이름</th>
<td class='inputsignred'><?=$this->data['User']['name']?></td>
<th>주민번호</th>
<td><?php $this->data['User']['signnum']?></td>
</tr>
<th>연락처</th>
<td class='inputsignred'><?=$this->data['User']['phone']?></td>
<th>휴대폰</th>
<td class='inputsignred'><?=$this->data['User']['mobile']?></td>
</tr>
<tr>
<th>이메일</th>
<td class='inputsignred'><?=$this->data['User']['email']?></td>
<th>홈페이지</th>
<td><?=$this->data['User']['homepage']?></td>
</tr>
<tr>
<th>주소</th>
<td colspan='3' class='inputsignred'>
<p><?=$this->data['User']['zipcode']?></p>
<p><?=$this->data['User']['addr1']?></p>
<p><?=$this->data['User']['addr2']?></p>
</td>
</tr>
<tr>
<th>메모</th>
<td colspan='3'>
<?=nl2br($this->data['User']['memo'])?><br />
</td>
</tr>

</table>


<!-- 
<hr />


<table class='tbl'>
<col width="15%" />
<col width="*" />
<col width="15%" />
<col width="*" />
<tr>
<th>회사명</th>
<td colspan='3'><?=$this->data['User']['Company.name']?></td>
</tr>
<tr>
<th>부서</th>
<td><?=$this->data['User']['Company.position']?></td>
<th>직책</th>
<td><?=$this->data['User']['Company.duty']?></td>
</tr>
<th>연락처</th>
<td><?=$this->data['User']['Company.tel']?></td>
<th>팩스</th>
<td><?=$this->data['User']['Company.fax']?></td>
</tr>
<tr>
<th>웹사이트</th>
<td colspan='3'><?=$this->data['User']['Company.website']?></td>
</tr>
<tr>
<th>주소</th>
<td colspan='3'>
<?=$this->data['User']['Company.zipcode']?><br />
<?=$this->data['User']['Company.addr1']?><br />
<?=$this->data['User']['Company.addr2']?><br />
</td>
</tr>
</table>
 -->
<div id="btn-area" class="floatright gBtn gBtn1">
	<?php if( $this->data['User']['level'] != 0 ):?>
	<?=$html->link("<span>수정</span>",array('action'=>'edit',$this->data['User']['userid']),array('escape'=>false))?>
	<?php endif;?>

	<?=$html->link("<span>목록</span>",array('action'=>'index'),array('id'=>'btn-list','escape'=>false))?>
</div>
<?=$form->end()?>


</div>
