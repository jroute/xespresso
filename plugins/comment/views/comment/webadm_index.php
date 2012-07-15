<?=$paginator->options(array('url' =>$this->passedArgs));?>

<div id="navigation-bar">
	<?=$this->element('webadm_navigation_bar');?>
</div>

<div id="top-tab">
	<div id="ctab">
		<ul class='ul-tab'>
		<li class='active'><?=$html->link('팝업목록','index')?></li>
		<li><?=$html->link('팝업추가','add')?></li>
		</ul>
	</div>
</div>

<div id="content">


  <?=$paginator->counter(array('format' => 'Total : %count%, Page : %page%/%pages%'));?>

<table class='tbl-list'>
<col width='50' />
<col width='*' />
<col width='130' />
<col width='130' />
<col width='150' />
<col width='50' />
<col width='60' />
<col width='60' />
<col width='100' />
<tr>
<th><?=$paginator->sort('팝업', 'id'); ?></th>
<th><?=$paginator->sort('제목', 'title'); ?></th>

<th><?=$paginator->sort('오픈일', 'sdate'); ?></th>
<th><?=$paginator->sort('종료일', 'edate'); ?></th>

<th><?=$paginator->sort('치수', 'dimensions'); ?></th>

<th><?=$paginator->sort('오픈', 'state'); ?></th>
<th>수정</th>
<th>삭제</th>
<th><?=$paginator->sort('수정일', 'modified'); ?></th>
</tr>

<?foreach($datas as $popup):?>
<tr>
<td><?=$popup['Popup']['id']?></td>
<td class='td-left'><b><a href='#' onclick='return false' class='preview' alt='<?=$popup['Popup']['id']?>' scroll='<?=$popup['Popup']['scrollbars']?>' dms='<?=$popup['Popup']['dimensions']?>'><?=$popup['Popup']['title']?></a></b></td>

<td><?=substr($popup['Popup']['sdate'],0,10)?></td>
<td><?=substr($popup['Popup']['edate'],0,10)?></td>

<td class='td-left'><?=$popup['Popup']['dimensions']?></td>
<td><?=$popup['Popup']['state']?></td>
<td><?=$html->link('수정','edit/'.$popup['Popup']['id'])?></td>
<td><?=$html->link('삭제','delete/'.$popup['Popup']['id'])?></td>
<td><?=substr($popup['Popup']['modified'],2,14)?></td>
</tr>
<?endforeach;?>
</table>

<div class='btn-area'>
	<div class='paging-area float-left'>
		<?=$paginator->prev('« Previous ', null, null, array('class' => 'page-disabled'));?>
		<?=$paginator->numbers(); ?>
		<?=$paginator->next(' Next »', null, null, array('class' => 'page-disabled'));?>
	</div>

	<div class='float-right'>
		<?=$form->button("팝업 추가",array('id'=>'btn-add','class'=>'btn','div'=>false))?>
	</div>
</div>


<!-- <div class='search-area'>
<?=$form->create("Popup",array("action"=>"index","type"=>"get"))?>
<?=$form->text("keyword")?>
<?=$form->submit("검색",array('div'=>false,'class'=>'btn'))?>
<?=$form->end();?>
</div> -->

</div>

<script type='text/javascript'>
//<![CDATA[
	$(function(){
		$('#btn-add').click(function(){
			window.location.href = "/webadm/popup/add";
		});

		$('.preview').each(function(){
			$(this).click(function(){

				var pno = $(this).attr('alt');
				var dimensions = $(this).attr('dms').split(',');
				var _x = $.trim(dimensions[0]);
				var _y = $.trim(dimensions[1]);
				var _w = $.trim(dimensions[2]);
				var _h = $.trim(dimensions[3]);
				var scrollbars = $(this).attr('scroll');

				var popup = window.open('/popup/view/'+pno,'popup','scrollbars='+scrollbars+',width=' + _w + ',height=' + _h + ',top=' + _x + ',left='+_y);
				popup.focus();
			});
		});
	});

//]]>
</script>


<!-- <div class='version'>Version : <?=$version?></div> -->