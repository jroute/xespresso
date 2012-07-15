
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
<td colspan="3"><?=$form->select('level',$level,$levtmp,array('empty'=>false))?></td>
</tr>



<tr>
<th>그룹</th>
<td colspan="3">

<?=$form->input("grpid",array('name'=>'data[grpid]','type'=>'radio', 'legend'=>false,'options' =>$gdata,'div'=>false,'value'=>$this->data['User']['grpid']));?>

</td>
</tr>

<tr>
<th>아이디</th>
<td class='inputsignred'>
<?if( @$userid ):?>
	<?=$form->text("userid",array('readonly'=>'readonly'))?><?=$form->error("userid",'아이디를 입력하십시오')?>
<?else:?>
	<?=$form->text("userid")?><?=$form->error("userid",'아이디를 입력하십시오')?>
<?endif?>
</td>
<th>비밀번호</th>
<td class='inputsignred'><?=$form->password("passwd")?>
<?=$form->error("passwd",'비밀번호를 입력하십시오')?>
<?=$form->error("passwd2",'비밀번호를 입력하십시오')?>
<?if( $this->action == "webadm_edit"):?>
<div class="desc">비밀변경시에만 입력하십시오</div>
<?endif;?>
</td>
</tr>
<tr>
<th>이름</th>
<td class='inputsignred'><?=$form->text("name")?><?=$form->error("name",'이름을 입력하십시오')?></td>
<th>주민번호</th>
<td>
<?php if( $this->action == "webadm_edit"):?>
<?=$form->text("signnum")?>
<?php else:?>
<?=$form->text("signnum")?>
<?php endif;?>
<div class="desc">`-` 없이 입력하십시오</div>
<?=$form->error("validate_signnum",'주민번호를 확인 하십시오')?>
</td>
</tr>
<th>연락처</th>
<td class='inputsignred'><?=$form->text("phone")?><?=$form->error("phone",'연락처를 입력하십시오')?></td>
<th>휴대폰</th>
<td class='inputsignred'><?=$form->text("mobile")?><?=$form->error("mobile",'휴대폰 번호를 입력하십시오')?></td>
</tr>
<tr>
<th>이메일</th>
<td class='inputsignred'><?=$form->text("email")?><?=$form->error("email",'이메일을 입력하십시오')?></td>
<th>홈페이지</th>
<td><?=$form->text("homepage")?></td>
</tr>
<tr>
<th>주소</th>
<td colspan='3' class='inputsignred'>
<p><?=$form->text("zipcode",array('id'=>'zip1'))?> <button  class='btn zipfinder' options='zip1,addr1' >우편번호 검색</button></p>
<p><?=$form->text("addr1",array('id'=>'addr1','class'=>'w95ps'))?></p>
<p><?=$form->text("addr2",array('class'=>'w95ps'))?></p>
<?=$form->error('zipcode','우편번호를 선택하십시오')?>
<?=$form->error('addr1','우편번호를 선택하십시오')?>
<?=$form->error('addr2','나머지 주소를 입력하십시오')?>

</td>
</tr>
<tr>
<th>메모</th>
<td colspan='3'>
<?=$form->textarea("memo",array('class'=>'txt w95ps','rows'=>5))?><br />
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
<td colspan='3'><?=$form->text("Company.name")?></td>
</tr>
<tr>
<th>부서</th>
<td><?=$form->text("Company.position")?></td>
<th>직책</th>
<td><?=$form->text("Company.duty")?></td>
</tr>
<th>연락처</th>
<td><?=$form->text("Company.tel")?></td>
<th>팩스</th>
<td><?=$form->text("Company.fax")?></td>
</tr>
<tr>
<th>웹사이트</th>
<td colspan='3'><?=$form->text("Company.website")?></td>
</tr>
<tr>
<th>주소</th>
<td colspan='3'>
<?=$form->text("Company.zipcode",array('id'=>'zip2'))?> <button  class='btn zipfinder' options='zip2,addr2' >우편번호 검색</button><br />
<?=$form->text("Company.addr1",array('id'=>'addr2','class'=>'w95ps'))?><br />
<?=$form->text("Company.addr2",array('class'=>'w95ps'))?><br />
</td>
</tr>
</table>
 -->
 
<div id="btn-area" class="floatright gBtn gBtn1" >
	<a><span><?=$form->submit("저장",array('div'=>false,'id'=>'btn-submit'))?></span></a>

	<?=$html->link("<span>목록</span>",array('action'=>'index'),array('id'=>'btn-list','escape'=>false))?>

	<?php if( $this->action == 'webadm_edit' ):?>
		<?=$html->link("<span>탈퇴</span>",array('action'=>'signout',$this->data['User']['userid']),array('id'=>'btn-signout','escape'=>false),'탈퇴처리 하시겠습니까?')?>
	<?php endif;?>
</div>
<?=$form->end()?>


</div>

<script type='text/javascript'>
//<![CDATA[
$(function(){


});
//]]>
</script>