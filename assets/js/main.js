
//closes and opens mobile navigation
$('#navCheckBox').click(function() {
    var elementBody = $('body, #navLinks');
    if (elementBody.css('margin-left') == '0px'){
        elementBody.animate({ marginLeft : '+=300px'}, 450 );
    } else {
        elementBody.animate({ marginLeft : '-=300px'}, 450 );
    }
}) 