
               
          <div class="section_table"> 
            <h3 class="bu_h3">Persnal Infomation</h3>
            <h4 class="bu_h4">prerequisite</h4>

            <table width="100%" summary="Persnal Infomation" >
              <caption>

             prerequisite
              </caption>
              <colgroup>
              
              </colgroup>
              
              <tbody>
              <tr>
              <th colspan="5">I. Personal Information</th>
                </tr>
              <tr>

                <td width="18%" class="table_blue02">ID</td>
                <td width="13%" class="table_gray">Desired</td>
                <td colspan="3"><?=$this->data['Persnal']['userid']?></td>
                </tr>                <tr>
                <td width="18%" class="table_blue02">Name</td>
                <td width="13%" class="table_gray">Firstname</td>

                <td width="24%"><?=$this->data['Persnal']['firstname'];?></td>
                <td width="17%" class="table_gray">Lastname</td>
                <td width="28%"><?=$this->data['Persnal']['lastname'];?></td>
                </tr>
                
                <tr>
                <td rowspan="3" class="table_blue02">Contact  Information</td>
                <td colspan="4">C.P: <?=$this->data['Persnal']['mobile'];?></td>

                
              </tr>
              <tr>
                <td colspan="4">Fax: <?=$this->data['Persnal']['fax'];?></td>
              </tr>
              <tr>
                <td colspan="4">E-mail: <?=$this->data['Persnal']['email'];?></td>
              </tr>
              
              <tr>

                <td width="18%" class="table_blue02">Office Phone No.</td>
                <td colspan="2"><?=$this->data['Persnal']['office_phone'];?></td>
                <td width="17%" class="table_blue02">Gender</td>
                <td width="28%"><?=$this->data['Persnal']['gender'];?></td>
                </tr>
                
                <tr>
                <td width="18%" class="table_blue02">Date of Birth</td>

                <td colspan="2"><?=$this->data['Persnal']['date_of_birth'];?></td>
                <td width="17%" class="table_blue02">Nationality</td>
                <td width="28%"><?=$this->data['Persnal']['nationality'];?></td>
                </tr>
                
                <tr>
                <td width="18%" class="table_blue02">Marital Status</td>
                <td colspan="2"><?=$this->data['Persnal']['marital_status']?></td>

                <td width="17%" class="table_blue02">The disabled</td>
                <td width="28%"><?=$this->data['Persnal']['the_disabled'];?></td>
                </tr>
              </tbody>
                
            </table>
                </div>
                
                <div class="section_table"> 
            <h4 class="bu_h4">Option</h4>

            <table width="100%" summary="Persnal Infomation" >
              <caption>
             prerequisite
              </caption>
              <colgroup>
              
              </colgroup>
              
              <tbody>
              <tr>
              <th colspan="5">II. Academic Information</th>

                </tr>
              <tr>
                <td width="18%" class="table_blue02">Degree/ Year</td>
                <td colspan="4"><p class="fl"><?=$this->data['Persnal']['degree'];?></p>
              <p class="fl"><?=$this->data['Persnal']['major'];?></p>
              <p class="fl"><?=$this->data['Persnal']['year'];?></p>
              
              </td>

                </tr>
                
                <tr>
                <th colspan="5"><p>III.  Affiliation Information</p></th>
                </tr>
                 <tr>
                <td width="18%" class="table_blue02">Affiliation</td>
                <td colspan="2"><?=$this->data['Persnal']['affiliation'];?></td>
                <td width="23%" class="table_blue02">Position</td>

                <td width="21%"><?=$this->data['Persnal']['position'];?></td>
                </tr>
                
                <tr>
                <td width="18%" class="table_blue02">Address</td>
                <td colspan="4"><?=$this->data['Persnal']['address'];?></td>
                </tr>
                
                <tr>
                <th colspan="5"><p>IV. Options</p></th>

                </tr>
                 <tr>
                <td colspan="3" class="table_blue02">Do you require dormitory housing?
<br />(Provided by KIGAM free of charge)</td>
                <td colspan="2"><?=$this->data['Persnal']['housing'];?></td>
                </tr>
                
                <tr>
                <td colspan="3" class="table_blue02">Please indicate a  possible check-in date</td>

                <td colspan="2"><?=$this->data['Persnal']['checkin_date'];?></td>
                </tr>
                
                <tr>
                <td width="18%" class="table_blue02">Religion</td>
                <td colspan="4"><?=$this->data['Persnal']['religion'];?></td>
                </tr>
                
                <tr>
                <td width="18%" class="table_blue02">Food option</td>

                <td colspan="4">
                <?=$this->data['Persnal']['food_option'];?></td>
                </tr>
                
                <tr>
                <td colspan="5" class="table_blue">Previous visit to Korea (if any)</td>
                </tr>
                
                <tr class="table_gray">
                <td width="18%">Year</td>

                <td width="20%">Desired</td>
                <td width="18%">Institution/Location</td>
                <td width="23%">Funded by</td>
                <td width="21%">&nbsp;</td>
                </tr>
                
                <tr>
                <td width="18%"><?=$this->data['Persnal']['pvk_year'];?></td>

                <td width="20%"><?=$this->data['Persnal']['pvk_desired'];?></td>
                <td width="18%"><?=$this->data['Persnal']['pvk_institution'];?></td>
                <td width="23%"><?=$this->data['Persnal']['pvk_fundedby'];?></td>
                <td width="21%">&nbsp;</td>
                </tr>
                
                <tr>
                <th colspan="5">Ⅴ. Emergency Contact Information</th>
                </tr>

                 <tr>
                <td width="18%" class="table_blue02">Name</td>
                <td colspan="2"><?=$this->data['Persnal']['emergency_name'];?></td>
                <td width="23%" class="table_blue02">Phone No.</td>
                <td width="21%"><?=$this->data['Persnal']['emergency_phone'];?></td>
                </tr>
              </tbody>
                
            </table>

                </div>
                
                
                   			    <div class="section_table"> 

            <table width="100%" summary="Persnal Infomation" >
              <caption>
             prerequisite
              </caption>
              <colgroup>
              
              </colgroup>
              
              <tbody>
              <tr>

              <th colspan="5">Information for visa support</th>
                </tr>
              <tr>
                <td width="21%" class="table_blue02">Firstname</td>
                <td colspan="4"><?=$this->data['PersnalVisasupport']['firstname'];?></td>
                </tr>
                
                <tr>
                <td width="21%" class="table_blue02">Lastname</td>

                <td colspan="4"><?=$this->data['PersnalVisasupport']['lastname'];?></td>
                </tr>
                
                <tr>
                <td width="21%" class="table_blue02">Date of Birth</td>
                <td colspan="4"><?=$this->data['PersnalVisasupport']['date_of_birth'];?></td>
                </tr>
                
                <tr>
                <td width="21%" class="table_blue02">Nationality</td>

                <td colspan="4"><?=$this->data['PersnalVisasupport']['nationality'];?></td>
                </tr>
                <tr>
                <td width="21%" rowspan="3" class="table_blue02">Passport</td>
                <td width="17%" class="table_gray">Number</td>
                <td colspan="3"><?=$this->data['PersnalVisasupport']['passport_number'];?></td>
                </tr>
                
                <tr>

                <td class="table_gray">Date of Issue</td>
                <td width="21%"><?=$this->data['PersnalVisasupport']['passport_dateofissue'];?></td>
                <td width="19%" class="table_gray">Place of Issue</td>
                <td width="22%"><?=$this->data['PersnalVisasupport']['passport_placeofissue'];?></td>
                </tr>
                
                <tr>
                <td class="table_gray">Date of Expiry</td>

                <td><?=$this->data['PersnalVisasupport']['passport_dateofexpiry'];?></td>
                <td width="19%" class="table_gray">Issuing Country</td>
                <td width="22%"><?=$this->data['PersnalVisasupport']['passport_issuingcountry'];?></td>
                </tr>
                
                
                <tr>
                <td class="table_blue02">Address</td>
                <td colspan="4"><?=$this->data['PersnalVisasupport']['address'];?></td>

                
              </tr>
              <tr>
                <td class="table_blue02">Phone &amp; Fax no.</td>
                <td colspan="4">
                C.P: <?=$this->data['PersnalVisasupport']['mobile'];?><br />
                Fax: <?=$this->data['PersnalVisasupport']['fax'];?></td>
              </tr>
              <tr>
                <td class="table_blue02">Air-ticket<br />

Purchase</td>
                <td colspan="4"><p>

                By KIGAM (<?=$form->checkbox('PersnalVisasupport.atp_kigam');?>)  /  By yourself  (<?=$form->checkbox('PersnalVisasupport.atp_yourself');?>)  </p>
                <p>Departure City&amp;Country  <?=$form->checkbox('PersnalVisasupport.atp_departure');?>  /  Arrival City&amp;Country  <?=$form->checkbox('PersnalVisasupport.atp_arrival');?>  </p></td>
              </tr>
              
              
              </tbody>
                
            </table>
</div>