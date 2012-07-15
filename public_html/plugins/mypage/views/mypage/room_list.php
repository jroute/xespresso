 <div class="s_content">         
  <div class="section_table"> 
	<h3 class="bu_h3">Accommodation Reservation</h3>
	<h4 class="bu_h4">Reserve list</h4>

	<table width="100%" summary="Detailed Search" >
	  <caption>
	  Reserve list
	  </caption>
	  <colgroup>
	  </colgroup>
	  
	  <tbody>
	  <tr>
		<th width="39">No</th>
		<th width="79">Room Type</th>
		<th width="80">Section</th>
		<th width="85">Payment</th>
		<th width="345">Check In ~ Check out</th>
	  </tr>
	  <?php 
	  $vno = count($rows);
	  foreach($rows as $i=>$row):$data = array_shift($row);?>
		<tr align=center>
			<td><?=$vno--?></td>
			<td><?=$html->link(@$data['type'],array('action'=>'room_view',$data['id']))?></td>
			<td><?=@$data['section'];?></td>
			<td><?=@$data['payment'];?></td>
			<td><?=@$data['checkin'];?> ~ <?=@$data['checkout'];?></td>
		</tr>
	<?php endforeach;?>
	
	  </tbody>
	</table>
	</div>
  </div>
		