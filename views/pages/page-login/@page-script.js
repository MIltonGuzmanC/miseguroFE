jQuery(function($) {

    $('#id-col-intro').remove() // remove the .col that contains carousel/intro
    $('#id-col-main').removeClass('col-lg-7') // remove the col-* class name for the login area

    $('#row-1')
        .addClass('justify-content-center')// so .col is centered

        .find('> .col-12') // change .col-12.col-xl-10, etc to .col-12.col-lg-6.col-xl-5 (so our login area is 50% of document width in `lg` mode , etc)
        .removeClass('col-12 col-xl-10 offset-xl-1').addClass(!isFullsize ? 'col-12 col-lg-6 col-xl-5' : '')

    $('.col-md-8.offset-md-2.col-lg-6.offset-lg-3')// the input elements that are inside "col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3" columns
        // ... remove '.col-lg-6 offset-lg-3' (will become .col-md-8)
        .removeClass('col-lg-6 offset-lg-3')

    // remove "Welcome Back" etc titles that were meant for desktop, and show the other titles that were meant for mobile (lg-) view
    // because this compact login page is similar to mobile view
    $('h4').each(function() {
        var mobileTitle = $(this).parent().next()
        if (mobileTitle.hasClass('d-lg-none')) mobileTitle.removeClass('d-lg-none').prev().remove()
    })
    $('a[data-toggle="tab"]')
    .on('click', function() {
        $('a[data-toggle="tab"]').removeClass('active')
    })
    var isFullsize = false

})