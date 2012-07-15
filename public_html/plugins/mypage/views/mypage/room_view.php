
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
                <td width="21%"><?=$this->data['Facilitie']['name1'];?></td>
                <td width="14%" class="table_gray">Given name</td>
                <td width="25%"><?=$this->data['Facilitie']['name2'];?></td>
                </tr>

              <tr>
                <td rowspan="5" class="table_blue02">Contact  Information</td>
                <td colspan="4">Affiliation:<?=$this->data['Facilitie']['affiliation'];?></td>
                
              </tr>
              <tr>
                <td colspan="4">Address:<?=$this->data['Facilitie']['address'];?></td>
              </tr>

              <tr>
                <td colspan="4">C.P:<?=$this->data['Facilitie']['cp'];?></td>
              </tr>
              <tr>
                <td colspan="4">Fax:<?=$this->data['Facilitie']['fax'];?></td>
              </tr>
              <tr>
                <td colspan="4">E-mail:<?=$this->data['Facilitie']['email'];?></td>

              </tr>
              
              <tr>
                <td class="table_blue02" width="20%"><p>Passport No.</p></td>
                <td colspan="2" width="30%"><?=$this->data['Facilitie']['no'];?></td>
                <td class="table_blue02">Gender</td>
                <td><?=$this->data['Facilitie']['gender'];?></td>

                
              </tr>
              <tr>
                <td class="table_blue02">Food option</td>
                <td colspan="2"><?=$this->data['Facilitie']['food_option'];?></td>
                <td class="table_blue02">The disabled</td>
                <td><?=$this->data['Facilitie']['disabled'];?></td>
                
              </tr>

              <tr>
                <td class="table_blue02">Date of Birth</td>
                <td colspan="2"><?=$this->data['Facilitie']['birth'];?></td>
                <td class="table_blue02">Nationality</td>
                <td><?=$nationality[$this->data['Facilitie']['nationality']]?></td>
              </tr>
			  <tr>
				<td class="table_blue02">Section</td>
                <td colspan="4"><p class="fl">
					<?=$this->data['Facilitie']['section'];?>
					</p>
				</td>
                </tr>
              <tr>
                <th colspan="5">II. Room Type</th>

                </tr>
                
                <tr>
                <td class="table_blue02">Room Type</td>
                <td colspan="4"><p class="fl">
					<?=$this->data['Facilitie']['type'];?>
					</p></td>
                </tr>
                
                <tr>
                <td class="table_blue02">Image</td>

                <td colspan="4">
				<?php
					if($this->data['Facilitie']['type']=="Single"){
						echo "<img src='/images/sub/img_applications01.gif' />";
					}else{
						echo "<img src='/images/sub/img_applications02.gif'/>";
				    }
				?>
				</td>
                </tr>
				
                

              
              <tr>
                <th colspan="5">III. Schedule</th>
                </tr>
                
                <tr>
                <td class="table_blue02">Check In</td>
                <td colspan="2"><?=$this->data['Facilitie']['checkin'];?></td>

                <td class="table_blue02">Check out</td>
                <td><?=$this->data['Facilitie']['checkout'];?></td>
                </tr>
                
                <tr>
                <td class="table_blue02">Nights</td>
                <td colspan="4"><?=$this->data['Facilitie']['nights'];?></td>
                </tr>
                
             <tr>

                <th colspan="5">IV. Payment</th>
                </tr>
                
                <tr>
                <td colspan="2" class="table_blue02">About  Payment</td>
                <td colspan="4"><?=$this->data['Facilitie']['payment'];?></td>
                </tr>
             
              </tbody>
            </table>

            <p class="fr">
				<a href="/mypage/room_list"><?=$html->image('/images/sub/btn_list01.gif',array('id'=>'btn-cancel','width'=>58,'height'=>24,'alt'=>'list'));?></a>
			</p>
        </div>
      </div>




