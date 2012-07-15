
<style type="text/css">
.tbl th {

}

.tbl td {
	padding:10px;
	height: 100px;
}

.sat {
	color:blue
}
.sun {
	color:red;
}
.nholiday {
	color:red !important;
}
</style>  

<h2><?=$html->link('<',array($prev_date));?> <?=$year?>/<?=$month?> <?=$html->link('>',array($next_date));?></h2>  
<table border="1" cellpadding="10" cellspacing="0" width="800" class="tbl">
<caption><?=$html->link('<',array($prev_date));?> <?=$year?>/<?=$month?> <?=$html->link('>',array($next_date));?></caption>
<col width="14%" />
<col width="14%" />
<col width="14%" />
<col width="14%" />
<col width="14%" />
<col width="14%" />
<col width="14%" />
<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>
<tr>
<?php
for( $i = 0 ; $i < $start_week ; $i++ )  
{
    echo "<td>&nbsp;</td>";  
}  

for( $days = 1 ; $days <= $last_day ; $days++)  
{  
    $i++;  
    $_days = sprintf("%02d",$days);  
   	$_date = sprintf('%04d-%02d-%02d',$year,$month,$days);
   	
    $className = "";  
    if( $i%7 == 1 ) $className="sun";  
    if( $i%7 == 0 ) $className="sat";  
    if( $sol2lun[$_date]['nholiday'] ) $className = 'nholiday';
  

  	
    echo "<td class=\"$className\" valign=\"top\">";
    echo "<div>$_days</div>";
    
    //음력 표시
		if( $i%7 == 1 || $_days == '01' || $_days == '15' ){
			echo ' <div style="font-size:8pt">(음) '.str_replace('-','.',substr($sol2lun[$_date]['lunar'],5)).'</div>';
		}    
    echo '<div>'.$sol2lun[$_date]['sol_plan'].'</div>';
    echo '<div>'.$sol2lun[$_date]['lun_plan'].'</div>';    
    echo "</td>";  
    if( $i%7 == 0 ) echo "</tr><tr>\n";  
}  
  
while(1)  
{  
    if( $i%7 == 0 ) break;  
    $i++;  
    echo "<td>&nbsp;</td>";  
    if( $i%7 == 0 ){ echo "</tr>"; break;}  
  
}  
  
?> 
</table> 