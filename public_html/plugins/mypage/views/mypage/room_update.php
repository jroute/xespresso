<?=$form->create('Facilitie',array('name'=>'FacilitieFrom','url'=>$this->here,'onsubmit'=>'return on_submit()'));?>
<?=$form->hidden('id');?>
<?=$form->hidden('gubun',array('value'=>'기숙사'));?>
<?=$form->hidden('state',array('value'=>'0'));?>
<script type="text/javascript">
//<![CDATA[

$(function(){
	$('.datepicker').datepicker({
		dateFormat:'yy-mm-dd',
		showOn: 'button',
		buttonImage: '/images/ico_calendar.gif',
		buttonImageOnly: true
	});
});

//]]>
</script>
<script type="text/javascript" src="/js/jquery/ui/smoothness/jquery-ui-1.8.2.smoothness.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/smoothness/jquery-ui-1.8.2.css" />
      <!-- content -->
      <div class="s_content">
        <h3 class="bu_h3">Applications</h3>
        <h4 class="bu_h4">Guesthouse</h4>
        <div class="section_table"> 
            <table width="100%" summary="NOMINATION FORM – 1/2" >
              <caption>
               Guesthouse
              </caption>
              <colgroup>
              <col width="25%" />
              
              </colgroup>
              
              <tbody>
              <tr>
              <th colspan="5">I. Personal Information</th>
                </tr>

              <tr>
                <td width="18%" class="table_blue02">Name</td>
                <td width="22%" class="table_gray">Surname</td>
                <td width="21%"><?=$form->text('name1');?></td>
                <td width="14%" class="table_gray">Given name</td>
                <td width="25%"><?=$form->text('name2');?></td>
                </tr>

              <tr>
                <td rowspan="5" class="table_blue02">Contact  Information</td>
                <td colspan="4">Affiliation:<?=$form->text('affiliation');?></td>
                
              </tr>
              <tr>
                <td colspan="4">Address:<?=$form->text('address');?></td>
              </tr>

              <tr>
                <td colspan="4">C.P:<?=$form->text('cp');?></td>
              </tr>
              <tr>
                <td colspan="4">Fax:<?=$form->text('fax');?></td>
              </tr>
              <tr>
                <td colspan="4">E-mail:<?=$form->text('email');?></td>

              </tr>
              
              <tr>
                <td class="table_blue02"><p>Passport No.</p></td>
                <td colspan="2"><?=$form->text('no');?></td>
                <td class="table_blue02">Gender</td>
                <td> <?=$form->input('gender',array('type'=>'radio','options'=>array('M'=>'M','F'=>'F'),'legend'=>false,'default'=>'M'));?> </td>

                
              </tr>
              <tr>
                <td class="table_blue02">Marital Status</td>
                <td colspan="2"><?=$form->input('status',array('type'=>'radio','options'=>array('Married'=>'Married','Single'=>'Single'),'legend'=>false,'default'=>'Married'));?></td>
                <td class="table_blue02">The disabled</td>
                <td><?=$form->input('disabled',array('type'=>'radio','options'=>array('Yes'=>'Yes','No'=>'No'),'legend'=>false,'default'=>'Yes'));?></td>
                
              </tr>

              <tr>
                <td class="table_blue02">Date of Birth</td>
                <td colspan="2"><?=$form->text('birth');?></td>
                <td class="table_blue02">Nationality</td>
                <td><?=$form->text('nationality');?></td>
                
              </tr>
              <tr>
                <th colspan="5">II. Choice Room Type</th>

                </tr>
                
                <tr>
                <td class="table_blue02">Room Type</td>
                <td colspan="4"><p class="fl">
					<?=$form->input('type',array('class'=>'roomtype','type'=>'radio','options'=>array('Single'=>'Single','Twin'=>'Twin'),'legend'=>false,'default'=>'Single'));?>
					</p><p class="app_moreinfo"><img src="../images/btn_moreinfo.gif" width="70" height="15" alt="moreinfo" /></p></td>
                </tr>
                
                <tr>
                <td class="table_blue02">Image</td>

                <td colspan="4">
					<img src="../images/sub/img_applications01.gif" id="img1" />
					<img src="../images/sub/img_applications02.gif" id="img2" style="display:none"/>
				</td>
                </tr>
				<td class="table_blue02">Section</td>
                <td colspan="4"><p class="fl">
					<?=$form->input('section',array('class'=>'section','type'=>'radio','options'=>array('Course Participants'=>'Course Participants','Public'=>'Public'),'legend'=>false,'default'=>'Course Participants'));?>
					</p>
				</td>
                </tr>
                
                <tr>
                <td class="table_blue02">Amenities</td>
                <td colspan="4"><?=$form->text('amenities');?></td>
                </tr>
                <tr>
                <td class="table_blue02"><p>Electricity&#13;</p></td>

                <td colspan="4"><?=$form->text('electricity');?></td>
                </tr>
              
              <tr>
                <th colspan="5">III. Schedule</th>
                </tr>
                
                <tr>
                <td class="table_blue02">Check In</td>
                <td colspan="2"><?=$form->text('checkin',array('id'=>'checkin','class'=>'datepicker','size'=>14));?></td>

                <td class="table_blue02">Check out</td>
                <td><?=$form->text('checkout',array('id'=>'checkout','class'=>'datepicker','size'=>14));?></td>
                </tr>
                
                <tr>
                <td class="table_blue02">Nights</td>
                <td colspan="4"><?=$form->text('nights');?></td>
                </tr>
                
             <tr>

                <th colspan="5">IV. Payment</th>
                </tr>
                
                <tr>
                <td colspan="2" class="table_blue02">About  Payment</td>
                <td colspan="4"><?=$form->text('payment');?></td>
                </tr>
             
              </tbody>
            </table>

            <p class="fr">
			
			<?=$form->submit('/images/sub/btn_submit01.gif',array('div'=>false,'id'=>'btn-submit','class'=>'button','width'=>68,'height'=>24,'alt'=>'submit'));?>
			<a href="/"><?=$html->image('/images/sub/btn_cancel01.gif',array('id'=>'btn-cancel','width'=>68,'height'=>24,'alt'=>'cancel'));?></a>
			<?=$form->end();?>
			</p>
        </div>
      </div>

<?=$javascript->codeBlock("

function on_submit(){
	return true;
}

$(function(){

	$('#checkout').change(function(){

		if( $(this).val() == '' ) return;

		if( $('.roomtype:eq(0)').is(':checked') == false && $('.roomtype:eq(1)').is(':checked') == false ){
			window.alert('Select RoomType!');
			$('.roomtype:eq(0)').focus();
			return;
		}

		if( $('.section:eq(0)').is(':checked') == false && $('.section:eq(1)').is(':checked') == false ){
			window.alert('Select Section!');
			$('.section:eq(0)').focus();
			return;
		}

		setNights();
	});


	$('.roomtype').click(function(){

        if( $('.roomtype:eq(0)').is(':checked')==true){

			$('#img1').show();
			$('#img2').hide();
		}

		if( $('.roomtype:eq(1)').is(':checked')==true){
			$('#img2').show();
			$('#img1').hide();
		}
		if( $('#checkout').val() == '' ) return;

		if( $('.section:eq(0)').is(':checked') == false && $('.section:eq(1)').is(':checked') == false ){
			window.alert('Select Section!');
			$('.section:eq(0)').focus();
			return;
		}

		setNights();
	});


	$('.section').click(function(){

		
		if( $('#checkout').val() == '' ) return;

		if( $('.roomtype:eq(0)').is(':checked') == false && $('.roomtype:eq(1)').is(':checked') == false ){
			window.alert('Select RoomType!');
			$('.roomtype:eq(0)').focus();
			return;
		}

		setNights();
	});

});



function setNights(){

	    var _section = null;
		$('.section').each(function(){
			if( $(this).is(':checked') == true ){
				_section = $(this).val();
				return false;
			}
		});

		var _roomtype = null;
		$('.roomtype').each(function(){
			if( $(this).is(':checked') == true ){
				_roomtype = $(this).val();
				return false;
			}
		});

		$.ajax({
			type:'POST',
			url:'/facilities/getNights',
			cache:false,
			data:{checkin:$('#checkin').val(),checkout:$('#checkout').val(),section:_section,roomtype:_roomtype},
			dataType:'json',
			error: function(XMLHttpRequest, textStatus, errorThrown){ alert(textStatus);}, 
			success: function(data){
				$('#FacilitieNights').val(data.nights);
				$('#FacilitiePayment').val(data.payment);		
			}	
		});
}

",array('inline'=>false));?>