/*
 *  jquery.rotator
 *  Version: 0.1
 */

var rotator_i = 0;
var rotator_tid = null;
var rotator_direction = 'next';



(function($){ $.fn.rotator = function(options){

    var defaults = {
		total:1,
		ms: 3000,
		i:0,
		clone:false,
		change:false
	};
  
    var options = $.extend(defaults, options);


		if( rotator_i != 0 ){
			options.i = rotator_i;
			rotator_i = 0;
		}

		if( options.change == false ){
			options.ms = 3000;
		}else{

			if( rotator_tid ){ 
				clearInterval(rotator_tid);
			}

			options.ms = 0;
			options.change = false;

		}
	
	return this.each(function(index) {
		
		var $this = $(this);

		rotator_tid = window.setInterval(function(){


			if( rotator_direction == 'next' ){

				$this.scrollTo('span:eq('+(++options.i)+')', 1000, {axis:'x',onAfter:function(){
					if( options.clone == false ) $this.append($this.children().filter(':eq('+(options.i-1)+')').clone());
					if( options.i >= (options.total*2) ){
						clone = true;
						rotator_direction = 'prev';
					}
				}});

			}else{
				$this.scrollTo('span:eq('+(--options.i)+')', 1000, {axis:'x',onAfter:function(){
					if( options.i <= 0 ){
						options.i = 0;
						rotator_direction = 'next';
					}
				}});

			}

			rotator_i = options.i;

	    }, options.ms);
		

	});

  
}})(jQuery);

