
<style type="text/css">
<!--
body {margin:0; padding:0;}
#wrap {padding:25px 20px 15px 20px; width:340px; border:6px solid #6169f7; background: url('http://ddi.or.kr/kor/images/popup/20110513/bg.gif') no-repeat 100% 0;}
.inputTypeText {margin:5px 0 6px 6px; border:1px solid #e4e4e4; background-color:#f7f7f7; height:16px;}
.inputTypeTextarea {margin:5px 0 6px 6px; width:95%; border:1px solid #e4e4e4; background-color:#f7f7f7;}
.w95 {width:95%}
table {margin-top:30px; width:100%;}
table td {background: url('http://ddi.or.kr/kor/images/popup/20110513/dotline.gif') repeat-x 0 100%;}
table td.lt {border-top:1px solid #6169f7;}
table td.lb {border-bottom:1px solid #6169f7; background-image:none;}
table td.rt {border-top:1px solid #e7e7e7;}
table td.rb {border-bottom:1px solid #e7e7e7; background-image:none;}
#wrap p {margin:0; padding:10px 0 0 0; text-align:right;}
.error-message{color:red;font-size:8pt;}
-->
</style>

<!-- size-- w:392, h:436px이상(textarea때문에 픽스하지 못함) -->
<?=$form->create('Slogan',array('url'=>$this->here,'onsubmit'=>'return on_submit()'));?>
<div id="wrap">
	<img src="http://ddi.or.kr/kor/images/popup/20110513/title.gif" alt="포스터&amp;슬로건 공모전. 미래의 먹거리를 만드는 연구개발특구의 포스터&슬로건을 찾습니다" />

	<table width="100%"  border="0" cellspacing="0" cellpadding="0" summary="■">

		<colgroup>
			<col width="76" />
			<col width="*" />
		</colgroup>
		<tbody>
		<tr>
			<td class="lt"><label for="pcon01"><img src="http://ddi.or.kr/kor/images/popup/20110513/tit01.gif" alt="이름" /></label></td>
			<td class="rt"><?=$form->text('name',array('id'=>'pcon01','class'=>"inputTypeText"));?><?=$form->error('name','이름을 입력하세요')?></td>
		</tr>

		<tr>
			<td><label for="pcon02"><img src="http://ddi.or.kr/kor/images/popup/20110513/tit02.gif" alt="이메일" /></label></td>
			<td><?=$form->text('email',array('id'=>'pcon02','class'=>"inputTypeText w95"));?><?=$form->error('email','E-mail을 입력하세요')?></td>
		</tr>
		<tr>
			<td><label for="pcon03"><img src="http://ddi.or.kr/kor/images/popup/20110513/tit03.gif" alt="소속기관" /></label></td>
			<td><?=$form->text('organization',array('id'=>'pcon03','class'=>"inputTypeText w95"));?><?=$form->error('organization','소속기관을 입력하세요')?></td>
		</tr>
		<tr>

			<td><label for="pcon04"><img src="http://ddi.or.kr/kor/images/popup/20110513/tit04.gif" alt="연락처" /></label></td>
			<td><?=$form->text('phone',array('id'=>'pcon04','class'=>"inputTypeText"));?><?=$form->error('phone','연락처를 입력하세요')?></td>
		</tr>
		<tr>
			<td><label for="pcon05"><img src="http://ddi.or.kr/kor/images/popup/20110513/tit05.gif" alt="슬로건 명" /></label></td>
			<td><?=$form->textarea('slogan',array('rows'=>3,'class'=>"inputTypeTextarea",'id'=>'pcon05'));?><?=$form->error('slogan','슬로건 명을 입력하세요')?></td>
		</tr>
		<tr>

			<td class="lb"><label for="pcon06"><img src="http://ddi.or.kr/kor/images/popup/20110513/tit06.gif" alt="슬로건 설명" /></label></td>
			<td class="rb"><?=$form->textarea('description',array('rows'=>5,'class'=>"inputTypeTextarea",'id'=>'pcon06'));?><?=$form->error('description','슬로건 설명을 입력하세요')?></td>
		</tr>
		</tbody>
	</table>

	<p>
		<a href="javascript:self.close();"><img src="http://ddi.or.kr/kor/images/popup/20110513/btn1.gif" alt="창닫기" /></a>
		<input type="image" src="http://ddi.or.kr/kor/images/popup/20110513/btn2.gif" alt="등록하기" />

	</p>
</div>
<?=$form->end();?>

<?=$javascript->codeBlock("
function on_submit(){
	try{
		if( $('#pcon01').val()== '' ){
			window.alert('이름을 입력하세요');
			$('#pcon01').focus();
			return false;
		}
		if( $('#pcon02').val()== '' ){
			window.alert('E-mail을 입력하세요');
			$('#pcon02').focus();
			return false;
		}
		if( $('#pcon03').val()== '' ){
			window.alert('소속기관을 입력하세요');
			$('#pcon03').focus();
			return false;
		}
		if( $('#pcon04').val()== '' ){
			window.alert('연락처를 입력하세요');
			$('#pcon04').focus();
			return false;
		}
		if( $('#pcon05').val()== '' ){
			window.alert('슬로건 명을 입력하세요');
			$('#pcon05').focus();
			return false;
		}
		if( $('#pcon06').val()== '' ){
			window.alert('슬로건 설명을 입력하세요');
			$('#pcon06').focus();
			return false;
		}
		
		return true;
												
	}catch(e){
		alert(e.message);
	}
	return false;
}
$(function(){
	

});
",array('inline'=>false));