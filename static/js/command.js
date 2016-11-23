$(document).ready(function() {
    /* Открываение подпунктов фильтра*/ 
    initMenuFilter();
});
  
function initMenuFilter() {
  $('.filter_options').hide();
  
  $('.filtr_ul_button').click(
    function() {
        $(this).next().slideToggle('normal');	
      }
    );
  }
