   <!-- content -->
           	  <div class="s_content">
            		  
               
          <div class="section_table"> 
            <h3 class="bu_h3">My Q&A</h3>
   
  
            <table width="100%" summary="New&amp;Notice" class="clear_b" >
              <caption>
              New&amp;Notice
              </caption>
              <colgroup>
              <col width="20%" />
              <col width="30%" />
              <col width="20%" />
              <col width="30%" />
              </colgroup>
              <thead>
				<tr>
                <th colspan="4"><b><?=$this->data['Board']['subject'];?></b></th>
              </tr>
           	 </thead>              
  
              <tbody>
              
			  <tr>
                <th>Name</th>
				<td><?=$this->data['Board']['name'];?></td>
				<th>IP</th>
				<td><?=$this->data['Board']['ip'];?></td>
              </tr>
			  <tr>
                <th>Date</th>
				<td><?=$this->data['Board']['created'];?></td>
				<th>Hit</th>
				<td><?=$this->data['Board']['hit'];?></td>
              </tr>
			   <tr>
                <th>File</th>
				<td colspan=3>
				<?php foreach($this->data['BoardFile'] as $files ):?>
					<a href="/board/download/<?=$this->data['Board']['bid']?>/<?=$this->data['Board']['no']?>/<?=$files['id']?>"><img src='/board/img/exts/01/<?=$files['ext']?>.gif' border='0' alt="<?=$files['name']?>" /> <?=$files['name']?></a>
				<?php endforeach;?>	
				</td>
              </tr>
			  <tr>
				<td colspan='4' valign='top'>
	
					<div style='min-height:200px;' id='board-content-view'>
						<?=$this->data['Board']['content'];?>
					</div>
				
				</td>
			 </tr>

              </tbody>
            </table>

			<?if(count($reply)>0){//답변글이 있으면?>
			<b>reply</b><br>
			<?php foreach($reply as $i=>$row):$data = array_shift($row);?>
			<table width="100%" summary="New&amp;Notice" class="clear_b" >
              <caption>
              New&amp;Notice
              </caption>
              <colgroup>
              <col width="20%" />
              <col width="30%" />
              <col width="20%" />
              <col width="30%" />
              </colgroup>
              <thead>
				<tr>
                <th colspan="4"><b><?=$data['subject'];?></b></th>
              </tr>
           	 </thead>              
  
              <tbody>
              
			  <tr>
                <th>Name</th>
				<td><?=$data['name'];?></td>
				<th>IP</th>
				<td><?=$data['ip'];?></td>
              </tr>
			  <tr>
                <th>Date</th>
				<td><?=$data['created'];?></td>
				<th>Hit</th>
				<td><?=$data['hit'];?></td>
              </tr>
			   <tr>
                <th>File</th>
				<td colspan=3>
		
				<?php foreach($reply[$i]['BoardFile'] as $files ):?>
					<a href="/board/download/<?=$data['bid']?>/<?=$data['no']?>/<?=$files['id']?>"><img src='/board/img/exts/01/<?=$files['ext']?>.gif' border='0' alt="<?=$files['name']?>" /> <?=$files['name']?></a>
				<?php endforeach;?>
				
				
				</td>
              </tr>
			  <tr>
				<td colspan='4' valign='top'>
	
					<div style='min-height:200px;' id='board-content-view'>
						<?=$data['content'];?>
					</div>
				
				</td>
			 </tr>

              </tbody>
            </table>

			<?php endforeach;?>





			<?}?>
		




				<div align="right"><a href="/mypage/faq_list"><img src="/board/img/buttons/01-en/btn_list.jpg"></a></div>
            </div>
            
            
            
            
           
            
            
            
                </div>
            
            
            
            
            
            
            
            
            
            
            
            
            <!-- content end -->