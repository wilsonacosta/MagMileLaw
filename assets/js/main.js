
//closes and opens mobile navigation
$('#navCheckBox').click(function() {
    var elementBody = $('body, #navLinks');
    if (elementBody.css('margin-left') == '0px'){
        elementBody.animate({ marginLeft : '+=300px'}, 450 );
    } else {
        elementBody.animate({ marginLeft : '-=300px'}, 450 );
    }
}) 
  

const speed = 1000;
$('a[href^="#"]')
    .not('.lp-pom-form .lp-pom-button')
    .unbind('click.smoothScroll')
    .bind('click.smoothScroll', function(event) {
    event.preventDefault();
    const href = $(this).attr('href').split('#');
    $('html, body').animate({ scrollTop: $(`#${href[1]}`).offset().top-100 }, speed);
});