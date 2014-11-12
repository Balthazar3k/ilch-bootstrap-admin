$(document).ready(function () {
  $('[data-toggle=offcanvas]').click(function () {
    $('.row-offcanvas').toggleClass('active');
       if($(this).text() == 'Quick Menu >')
       {
           $(this).text('< Quick Menu');
       }
       else
       {
           $(this).text('Quick Menu >');
       }
  });
});
