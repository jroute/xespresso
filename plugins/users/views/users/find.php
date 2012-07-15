<?=$skin_header?>

<?=$javascript->link('user.finder',true)?>


<h3>아이디 찾기</h3>
<?=$form->create('User',array('url'=>array('controller'=>$this->params['controller'],'action'=>$this->action)))?>                          
                          <table width="100%" border="1">

                            <tr>
                              <td>이름</td>
                              <td><?=$form->text('name',array('id'=>'name','size'=>"20",'tabindex'=>'1'))?></td>
                              <td rowspan="2"><input type="submit" tabindex="4" value="아이디찾기" /> </td>
                            </tr>
                            <tr>
                              <td>주민등록번호</td>
                              <td ><?=$form->text('signnum1',array('id'=>'signnum1','size'=>"8",'tabindex'=>'2'))?> - <?=$form->password('signnum2',array('id'=>'signnum2','size'=>"8",'tabindex'=>'3'))?> </td>
                            </tr>
                          </table>
<?=$session->flash('findId')?>                          
<?=$form->end();?>                          
                          </td>
                        </tr>

                    </table>
                
                
                
                
<h3>비밀번호 찾기</h3>
<?=$form->create('User',array('url'=>array('controller'=>$this->params['controller'],'action'=>$this->action)))?>                          
                          <table width="100%" border="1">
                            <tr>
                              <td>이름</td>
                              <td><?=$form->text('name',array('id'=>'name','size'=>"20",'tabindex'=>'5'))?></td>
                              <td>&nbsp;</td>

                            </tr>
                            <tr>
                              <td>아이디</td>
                              <td><?=$form->text('userid',array('id'=>'userid','size'=>"20",'tabindex'=>'6'))?></td>
                              <td rowspan="2"><input type="submit" tabindex="9"  value="비밀번호찾기"  /></td>
                            </tr>
                            <tr>
                              <td>주민등록번호</td> 
                              <td ><?=$form->text('signnum1',array('id'=>'signnum1','size'=>"8",'tabindex'=>'7'))?> - <?=$form->password('signnum2',array('id'=>'signnum2','size'=>"8",'tabindex'=>'8'))?> </td>
                            </tr>
                          </table>
<?=$session->flash('findPassword')?>
<?=$form->end()?>          


<?=$skin_footer;?>