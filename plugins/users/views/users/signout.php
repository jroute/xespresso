<table width="645" border="0" cellpadding="0" cellspacing="0" background="/img/include/ti_bg.jpg">
        <tr>
          <td width="355" height="50" valign="top"><img src="/img/member/title_out.jpg" alt="회원탈퇴" /></td>
          <td width="290" class="location">Home &gt; Membership &gt; 회원탈퇴</td>
        </tr>
      </table><!--타이틀영역 end-->
      <!-- 컨텐츠 영역-->      <div class="contents">
        <table width="572" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td><img src="/img/member/img_out.jpg" alt="회원탈퇴" width="572" height="71" /></td>
          </tr>
          <tr>
            <td><table width="100%" border="0" cellpadding="3" cellspacing="2" bgcolor="d8d8d8">
                <tr>
                  <td height="83" bgcolor="#FFFFFF">

<?=$session->flash('user')?>

<?=$form->create('User',array('action'=>'signout'))?>
<?=$form->hidden('uno')?>
<?=$form->hidden('userid')?>

                      <table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td height='100'>
						  정말 탈퇴하시겠습니까?<br />
						  회원 탈퇴시 회원가입시 입력하시 모든 정보가 삭제 되며,<br>
						  재가입시 같은 아이디로 회원가입 하실 수 없습니다.
						  
						  </td>
                        </tr>
                        <tr>
                          <td height="50">비밀번호 : <?=$form->password('passwd',array('class'=>'txt w100px','div'=>false))?></td>
                        </tr>
                        <tr>
                          <td height="22">
						  
						  <?=$form->submit('/img/member/btn_out.jpg',array('alt'=>"탈퇴하기",'width'=>"65",'height'=>"21",'div'=>false))?>&nbsp;&nbsp;&nbsp;
						  <?=$html->link('<img src="/img/member/btn_cancel.jpg" alt="취소" width="66" height="22" />','/',null,null,false)?>
						  
						  </td>
                        </tr>
                      </table>
					
<?=$form->end()?>
                   
				   
				   </td>
                </tr>
            </table></td>
          </tr>
        </table>
      </div>