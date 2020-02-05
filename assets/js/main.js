//closes and opens mobile navigation
$('.navLinks, #navCheckBox').click(function() {
    if (window.innerWidth < 992) {
        var elementBody = $('#navLinks');
        if (elementBody.css('left') != '0px'){
            elementBody.animate({ left : '+=300px'}, 450 );
        } else {
            $("#menuToggle input:checked").prop("checked", false);
            elementBody.animate({ left : '-=300px'}, 450 );
        }
    }
}) 

//Resets the Navigation and Menu Icon on resize
window.onresize = function() {
    var elementBody = $('#navLinks');
    // if (window.innerHeight >= 820) { /* ... */ }
    if (window.innerWidth >= 992) {  
        elementBody.css('left', 'auto');
    } else {
        if (elementBody.css('left') != '0px'){
            $("#menuToggle input:checked").prop("checked", false);
            elementBody.css('left', '-300px');
        }
    }
}
  
//Slow scroll down for anchor tags
const speed = 1000;
$('a[href^="#"]')
    .not('.lp-pom-form .lp-pom-button')
    .unbind('click.smoothScroll')
    .bind('click.smoothScroll', function(event) {
    event.preventDefault();
    const href = $(this).attr('href').split('#');
    $('html, body').animate({ scrollTop: $(`#${href[1]}`).offset().top-100 }, speed);

    //Removes the #anchor in from the URL
    window.location.replace("#");
    if (typeof window.history.replaceState == 'function') {
    history.replaceState({}, '', window.location.href.slice(0, -1));
    }
});

