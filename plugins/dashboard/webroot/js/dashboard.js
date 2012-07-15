
	$(function(){
	
		$('.column').each(function(index){
			var _this = $(this);
			var section_id = _this.attr('id');
			var data = $.cookie(section_id);
			if( data == null ) return true;//continue;
			section = data.split(',');

			$(section).each(function(index,target){
				if( target == 'null' || target == '' ) return true;//continue;
				var _target = $('#'+target);
				$('#'+target).remove();
				$('#'+section_id).append(_target);
			});

		});	
		$('.dashboard-box').show();
	
	
    var options = { path: '/', expires: 60 };	
    
		$(".column").sortable({
			connectWith: '.column',
//			placeholder: 'ui-state-highlight',
			activate:function(event,ui){
				db = null;
				for( i = 0; i < $(ui.item).parent().find('.dashboard-box').length ; i++ ){
					var box = $(ui.item).parent().find('.dashboard-box:eq('+i+')');
					if( $(ui.item).attr('id') != box.attr('id') ){
						db+=','+box.attr('id');
					}
				}
				$.cookie($(ui.item).parent().attr('id'),db,options);					
			},			
			stop:function(event,ui){
				db = null;
				for( i = 0; i < $(ui.item).parent().find('.dashboard-box').length ; i++ ){
					var box = $(ui.item).parent().find('.dashboard-box:eq('+i+')');
					db+=','+box.attr('id');
				}
				$.cookie($(ui.item).parent().attr('id'),db,options);				
			}
		});

		$(".dashboard-box").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
				.find(".dashboard-title")
				.addClass("ui-widget-header ui-corner-all")
				.prepend('<span class="ui-icon ui-icon-minusthick"></span>')
				.end()
			.find(".dashboard-content");

		$(".dashboard-title .ui-icon").click(function(){
		
			$(this).toggleClass("ui-icon-minusthick").toggleClass("ui-icon-plusthick");
			$(this).parents(".dashboard-box:first").find(".dashboard-content").toggle();
			
		});

		$(".column").disableSelection();
		
		
		});