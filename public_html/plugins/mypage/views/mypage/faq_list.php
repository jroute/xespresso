<?=$paginator->options(array('url' =>$this->passedArgs));?>
<?php $vno = $paginator->counter('%count%')-($paginator->counter('%page%')-1)*$paginate['Board']['limit'];?>
    <div class="s_content"> 
        <div class="section_table"> 
			<h3 class="bu_h3">My Q&A</h3>
        
              <div class="inf_sel02">
              	<ul>
					<li class="fl"><?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?> </li>
                </ul>
				</div>
            <table width="100%" summary="New&amp;Notice" class="clear_b" >
              <caption>
              New&amp;Notice
              </caption>
              <colgroup>
              <col width="" />
              <col width="" />
              <col width="" />
              <col width="" />
              </colgroup>
              <thead>
              <tr>
                <th width="47">No</th>
                <th width="300">Title</th>
                <th width="82">Date</th>
                <th width="39" class="section_table_right">Hit</th>
				<th width="76">reply</th>
                </tr>
           	 </thead>              
              <tbody>
<!--
              <tr>
                <td class="table_blue section_table_left">9965</td>
                <td>2010 Chuseok  Holiday: Holiday Schedules of Major</td>
                <td class="table_cen">2010-08-17</td>
                <td class="table_cen">53</td>
				<td>Certificate</td>
              </tr>
-->
			  <?php foreach($rows as $i=>$row):$data = array_shift($row);?>

				<tr>
					<td align="center"><?=$vno--?></td>
					<td><?=$paginator->link($data['subject'],array('plugin'=>false,'action'=>'faq_view',$data['no']))?></td>
					<td align="center"><?=str_replace('-','.',substr($data['created'],0,10))?></td>
					<td align="center"><?=$data['hit'];?></td>
					<td align="center"><?if($reply[$i]>0) echo "reply";?></td>
				</tr>
			<?php endforeach;?>
              </tbody>
            </table>



			<div class="inf_footlist">
                <p class="table_number01">
				<!--<img src="../images/sub/btn_back01.gif" />&nbsp;<strong>1</strong>/2/3/4/5&nbsp;<img src="../images/sub/btn_next01.gif" />-->

				 <?=$paginator->prev('prev', null, null, array('class' => 'page-disabled'));?>
				<?=$paginator->numbers(); ?>
				<?=$paginator->next('next', null, null, array('class' => 'page-disabled'));?>
				</p>

				
         
              </div>
         </div>
     </div>
            
