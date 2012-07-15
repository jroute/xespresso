            	
                
                <!-- content -->
           	  <div class="s_content">
            		  
               
          <div class="section_table"> 
            <h3 class="bu_h3">Course Registration</h3>
            <h4 class="bu_h4">Courses In Progress</h4>

            <table width="100%" summary="Detailed Search" >
              <caption>
              Detailed Search
              </caption>

              <colgroup>
              </colgroup>
              
              <tbody>              
              <tr>
                <th width="39">No</th>
                <th width="159">Courses</th>
                <th width="345">module</th>

                <th width="85">Period</th>
                </tr>
<?php $vno = count($rows_in);?>                
<?php foreach($rows_in as $row):?>                
              <tr>
                <td><?=$vno--?></td>
                <td><?=$row['CertificateCourse']['title']?></td>
                <td><?=$html->link($row['Certificate']['title'],'/mypage/course_view/'.$row['CertificateEnroll']['id'])?></td>
                <td><?=str_replace('-','.',substr($row['Certificate']['edu_sdate'],2,5))?>~<?=str_replace('-','.',substr($row['Certificate']['edu_edate'],2,5))?></td>

				

                </tr>
<?php endforeach;?>                
              </tbody>
            </table>
            </div>
            
            <div class="section_table"> 
            <h4 class="bu_h4">Closed Courses</h4>

            <table width="100%" summary="Detailed Search" >

              <caption>
              Detailed Search
              </caption>
              <colgroup>
              </colgroup>
              
              <tbody>
              <tr>
                <th width="39">No</th>
                <th width="159">Courses</th>

                <th width="345">module</th>
                <th width="85">Period</th>
                </tr>
              
<?php $vno = count($rows_closed);?>                
<?php foreach($rows_closed as $row):?>                
              <tr>
                <td><?=$vno--?></td>
                <td><?=$row['CertificateCourse']['title']?></td>
                <td><?=$html->link($row['Certificate']['title'],'/mypage/course_view/'.$row['CertificateEnroll']['id'])?></td>
                <td><?=str_replace('-','.',substr($row['Certificate']['edu_sdate'],2,5))?>~<?=str_replace('-','.',substr($row['Certificate']['edu_edate'],2,5))?></td>

                </tr>
<?php endforeach;?>  
              
                              
              </tbody>
            </table>
            </div>
            
