          <div class="section_table"> 
         <h3 class="bu_h3">Reserve Courses</h3>
            <h4 class="bu_h4">Detailed  Content</h4>


            <table width="100%" summary="Detailed Search" >
              <caption>
              Reserve content
              </caption>

              <colgroup>
              <col width="12%" />
              <col width="13%" />
              </colgroup>
              
              <tbody>
              <tr>
                <td class="section_table_left table_blue">Division</td>
                <td colspan="2" class="section_table_right"><?=$this->data['CertificateCategory']['name']?></td>

                </tr>
              <tr>
                <td class="section_table_left table_blue">Courses</td>
                <td colspan="2" class="section_table_right"><?=$this->data['CertificateCourse']['title']?></td>
                
              </tr>
              
              <tr>
                <td class="section_table_left table_blue"><p>module&#13;</p></td>
                <td colspan="2" class="section_table_right"><?=$this->data['Certificate']['title']?></td>

                
              </tr>
              <tr>
                <td class="section_table_left table_blue">Period</td>
                <td colspan="2" class="section_table_right"><?=$this->data['Certificate']['edu_sdate']?>~<?=$this->data['Certificate']['edu_edate']?></td>
                
              </tr>
              <tr>
                <td class="section_table_left table_blue">Language</td>
                <td colspan="2" class="section_table_right"><?=$this->data['Certificate']['language']?></td>
              </tr>
              <tr>
                <td class="section_table_left table_blue">State</td>
                <td colspan="2" class="section_table_right">
                <?php if( $this->data['Certificate']['state'] == 2 ):?>
								<img width="42" height="15" class="mr13" alt="pass" src="/images/btn_pass.gif">                
                <?php else:?>
								<img width="51" height="15" class="mr13" alt="pass" src="/images/btn_nopass.gif">                                
                <?php endif;?>
                </td>
              </tr>        
			  
              <tr>
                <td colspan="3" class="section_table_left table_blue">Leading Instructor</td>
                </tr>
             
			  <tr>
                <td class="section_table_left"><img src="/images/img_korea.gif" alt="korea" /></td>
                <td><?php $file = @unserialize($this->data['Lecturer']['photo']);?>
                <?=$html->image('/files/lecturers/'.$file['sname']);?>
                </td>
                <td class="section_table_right"><strong><?=$this->data['Lecturer']['name']?></strong>
					<br />
					<br />
						<?=$this->data['Lecturer']['position']?>
					<br />
					<?=$this->data['Lecturer']['address']?>
					<br />
					<?=$this->data['Lecturer']['nationality']?> / Tel: <?=$this->data['Lecturer']['phone']?>
				</td>
               </tr>
<?if($this->data['Lecturer2']['id']){?>
			   <tr>
                <td class="section_table_left"><img src="/images/img_korea.gif" alt="korea" /></td>
                <td><?php $file = @unserialize($this->data['Lecturer2']['photo']);?>
                <?=$html->image('/files/lecturers/'.$file['sname']);?>
                </td>
                <td class="section_table_right"><strong><?=$this->data['Lecturer2']['name']?></strong>
					<br />
					<br />
						<?=$this->data['Lecturer2']['position']?>
					<br />
					<?=$this->data['Lecturer2']['address']?>
					<br />
					<?=$this->data['Lecturer2']['nationality']?> / Tel: <?=$this->data['Lecturer2']['phone']?>
				</td>
               </tr>
<?}?>
<?if($this->data['Lecturer3']['id']){?>
			   <tr>
                <td class="section_table_left"><img src="/images/img_korea.gif" alt="korea" /></td>
                <td><?php $file = @unserialize($this->data['Lecturer3']['photo']);?>
                <?=$html->image('/files/lecturers/'.$file['sname']);?>
                </td>
                <td class="section_table_right"><strong><?=$this->data['Lecturer3']['name']?></strong>
					<br />
					<br />
						<?=$this->data['Lecturer3']['position']?>
					<br />
					<?=$this->data['Lecturer3']['address']?>
					<br />
					<?=$this->data['Lecturer3']['nationality']?> / Tel: <?=$this->data['Lecturer3']['phone']?>
				</td>
               </tr>
<?}?>


              </tbody>
            </table>
            <p class="fr">

            <a href="javascript:window.history.back();"><img src="/images/sub/btn_back03.gif" width="58" height="24" alt="back" /></a></p>

            </div>
            
            
     