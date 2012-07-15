<?=$paginator->options(array('url' =>$this->passedArgs));?>



        <p class="pb20"><img src="/images/sub/sub04_con6_1.gif" alt="설문조사입니다." /></p>

                            
 <div><?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?></div>
                             
        <table width="704" class="table_style2" summary="게시판">
                                                <caption>
                                        설문조사
                                        </caption>
                                        <thead>
                                          <tr>
                                                        
                                             <th width="28" class="blz">번호</th>

                                            <th width="344">제목</th>
                                            <th width="172" >기간</th>
                                            <th width="78" >참여</th>
                                            <th width="58">결과</th>
                                          </tr>
                                        </thead>
                                        <tbody>

                      
<?php foreach($this->data as $row):?>
<tr>
<td class="blz"><?=$row['PollSetup']['id']?></td>
<td class="tl" align="left"><b><?=$paginator->link($row['PollSetup']['title'],array('action'=>'view',$row['PollSetup']['id']))?></b></td>
<td class="tl"><?=str_replace('-','.',substr($row['PollSetup']['sdate'],2,8))?> ~ <?=str_replace('-','.',substr($row['PollSetup']['edate'],2,8))?></td>
<td><?=$row['PollSetup']['persons']?></td>
<td><?=$html->link($html->image("webadm/chart_bar_16x16.png",array('alt'=>'결과')),'result/'.$row['PollSetup']['id'],array('escape'=>false))?></td>
</tr>
<?php endforeach;?>



                                        </tbody>

                                      </table>                      
                      
                      
                      
          <div class="page">
          

		<?=$paginator->prev($html->image('/images/sub/icon_arrow_prev_1.gif'), array('style'=>'vertical-align:top','tag'=>'span','escape'=>false), 
		$html->image('/images/sub/icon_arrow_prev_1.gif'), array('style'=>'vertical-align:top','tag'=>'span','class' => 'page-disabled','escape'=>false));?>
		<?=$paginator->numbers(array('separator'=>'.')); ?>
		<?=$paginator->next($html->image('/images/sub/icon_arrow_next_1.gif'), array('style'=>'vertical-align:top','tag'=>'span','escape'=>false), 
		$html->image('/images/sub/icon_arrow_next_1.gif'), array('style'=>'vertical-align:top','tag'=>'span','class' => 'page-disabled','escape'=>false));?>
          
          </div>
