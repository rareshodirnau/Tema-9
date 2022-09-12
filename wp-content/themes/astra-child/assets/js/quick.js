(function($){

// Get the <span> element that closes the modal
var span = $('.modal .close');

$('.woocommerce-LoopProduct-link button').click(function(e){
  e.preventDefault();
  $('.modal').hide();
// Get the button that opens the modal
  $('.modal[data-modal_id="' + $(this).data("id") + '"]').show();
});

span.on('click', function(){
  $(this).parent().parent().hide();
}); 

$(".modal").click(function(event) {
  if (event.target.className == "modal") {
    $(event.target).hide();
  }
});

})( jQuery);