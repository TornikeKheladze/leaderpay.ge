$('.open').click(function(e) {
    e.preventDefault();
    var id = $(this).attr('rel');
    $('#'+id).toggle();
  });
$('.closeIcon').click(function(e) {
  e.preventDefault();
  $(this).parent().hide();
});