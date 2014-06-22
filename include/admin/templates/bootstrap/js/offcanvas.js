$(document).ready(function () {
  $('[data-toggle=offcanvas]').click(function () {
    $('.row-offcanvas').toggleClass('active');
       if($(this).text() == 'Quick Menü >')
       {
           $(this).text('< Quick Menü');
       }
       else
       {
           $(this).text('Quick Menü >');
       }
  });
});
