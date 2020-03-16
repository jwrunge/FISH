
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

function resizer() {
    $('#hero_img').css('margin-top', $('#nav').outerHeight() + 'px')
    $('.topmargin').css('margin-top', $('#nav').outerHeight() + 'px')

    if($(window).width() < 500) {
        if($('#hero_img').attr('src') !== 'images/fish_lead_min_mobile.jpg')
            $('#hero_img').attr('src', 'images/fish_lead_min_mobile.jpg')
    }

    else {
        if($('#hero_img').attr('src') !== 'images/fish_lead_min.jpg')
            $('#hero_img').attr('src', 'images/fish_lead_min.jpg')
    }

    if($('.hero_box').length === 0) {
        if($('#footer').length === 0)
            $('.content').css('minHeight', $(window).innerHeight())
        else
            $('.content').css('minHeight', $(window).innerHeight() - ($('#footer').outerHeight()))
    }

    //account for slideshow max heights
    $('.slideshow').each(function() {
        var height = 0;
        $(this).children('img.displayable').each(function() {
            if($(this).height() > height) height = $(this).height()
        });

        $(this).children('img.displayable').each(function() {
            $(this).css('marginTop', (height - $(this).height())/2)
        });

        $(this).height(height)
    });
}

resizer();
$(window).resize(resizer)

$(window).on('load', function(){

    resizer();

    $('#logoutlink').on('click', function(e) {
        e.preventDefault()
        $('#logoutform').submit()
    })

    $('.slideshow .right-ctrl').on('click', function() {
        var currentDisplayed = $(this).closest('.slideshow').find('img.active')
        var nextOne = currentDisplayed.next('img.displayable')
        if(nextOne.length === 0) nextOne = $(this).closest('.slideshow').children('img.displayable').first()

        nextOne.addClass('active');
        currentDisplayed.removeClass('active')
    })

    $('.slideshow .left-ctrl').on('click', function() {
        var currentDisplayed = $(this).closest('.slideshow').find('img.active')
        var nextOne = currentDisplayed.prev('img.displayable')
        if(nextOne.length === 0) nextOne = $(this).closest('.slideshow').children('img.displayable').last()

        nextOne.addClass('active');
        currentDisplayed.removeClass('active')
    })

    $('#hamburger').on('click', function() {
        if($(window).width() < 500) {
            $('#full_nav').toggleClass('open');
        }
    })
})