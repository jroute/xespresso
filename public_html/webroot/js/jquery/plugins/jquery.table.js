(function($){
  $.fn.extend({
    addCount: function() {
      return $(this).each(function(){
        if($(this).is('table')){
          $('thead th:first, thead td:first', this).each(function(){
            if($(this).is('td'))
              $(this).before('<td rowspan="'+$('thead tr').length+'">#</td>');
        else if($(this).is('th'))
              $(this).before('<th rowspan="'+$('thead tr').length+'">#</th>');
          });
          $('tbody td:first-child', this).each(function(i){
        $(this).before('<td>'+(i+1)+'</td>');
          });
      }
      });
    }
  });
})(jQuery);