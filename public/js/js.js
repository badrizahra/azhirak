url_app = window.location.href;
$(function() {

    $('.slider-top').owlCarousel({
        rtl:true,
        loop:true,
        margin:10,
        nav:true,
        navText:['<i class="icon-chevron-thin-left"></i>','<i class="icon-chevron-thin-right"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });



    $('.slider-footer').owlCarousel({
        rtl:true,
        loop:false,
        margin:10,
        nav:false,
        navText:['<i class="icon-chevron-thin-right"></i>','<i class="icon-chevron-thin-left"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:8
            }
        }
    });

    $('.related-products-wrapper').owlCarousel({
        rtl:true,
        loop:false,
        margin:10,
        nav:false,
        navText:['<i class="icon-chevron-thin-right"></i>','<i class="icon-chevron-thin-left"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:6
            }
        }
    });


    $('.slider-company-page').owlCarousel({
        rtl:true,
        loop:false,
        margin:10,
        nav:false,
        navText:['<i class="icon-chevron-thin-right"></i>','<i class="icon-chevron-thin-left"></i>'],
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:3
            }
        }
    });

    $('.container-carousel').owlCarousel({
        rtl:true,
        loop:true,
        margin:10,
        nav:true,
        navText:['<i class="icon-chevron-thin-right"></i>','<i class="icon-chevron-thin-left"></i>'],
        responsive:{
            0:{
                items:6
            },
            600:{
                items:6
            },
            1000:{
                items:6
            }
        }
    });


    $('#menu-top-link').click(function(){
        if($('#menu-top').hasClass('open')) {
            $('#menu-top').removeClass('open');
        } else {
            $('#menu-top').addClass('open');
        }
        //$('#menu-top').fadeToggle('fast');

        return false;
    });


    //console.log(submenu_brand);

    // printing menu & Submenu



    // $('.ul-subcategory li a').hover(
    //     function() {
    //
    //         var cat_id = 0;
    //         var datas = [];
    //         console.log($(this).attr('data-id'));
    //         $.get("https://saze118.com/api/category/get_childs_menu/12", function(data, status){
    //
    //         });
    //
    //
    //
    //         // $.each(submenu_brand['child'], function( index, value ) {
    //         //
    //         //     $('.sub-menu-wrapper').append('<div class="grid-dp-4" id="sub-menu-'+index+'">');
    //         //         $('#sub-menu-'+index).append('<h1>'+value.title+'</h1>');
    //         //         $('#sub-menu-'+index).append('<ul>');
    //         //             console.log(submenu_brand['child'][index]['child']);
    //         //             $('#sub-menu-'+index+' ul').append('<li>Ali</li>');
    //         //     $('#sub-menu-'+index).append('</ul>');
    //         //
    //         //     $('.sub-menu-wrapper').append('</div>');
    //         //
    //         //
    //         // });
    //
    //
    //     }, function() {
    //
    //         console.log('out');
    //
    //     }
    // );

    $('.ul-subcategory li a').on('mouserover',function(event) {
        console.log('a');
    });

    $('.categorey-item-company-profile__container').owlCarousel({
        rtl:true,
        loop:false,
        margin:10,
        nav:false,
        navText:['<i class="icon-chevron-thin-right"></i>','<i class="icon-chevron-thin-left"></i>'],
        responsive:{
            0:{
                items:3
            },
            600:{
                items:3
            },
            1000:{
                items:3
            }
        }
    });

    $('.container-viewed-products').owlCarousel({
        rtl:true,
        loop:false,
        margin:10,
        nav:false,
        navText:['<i class="icon-chevron-thin-right"></i>','<i class="icon-chevron-thin-left"></i>'],
        responsive:{
            0:{
                items:3
            },
            600:{
                items:3
            },
            1000:{
                items:6
            }
        }
    });

    $('.invoice-request-btn-supplier').click(function() {

        $(this).toggleClass('active');
        var parent = $(this).parents('li');
        $('.content-supplier-item').hide();
        parent.find('section').toggleClass('show');
        return false;

    });

});

var right_menu = function() {
    var tmp = null

    $.ajax({
        'async': false,
        'type': "GET",
        'global': false,
        'dataType': 'json',
        'url': "https://saze118.com/api/category/get_list/30/0",
        // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
        'success': function (data) {
            tmp = data;
        }
    });
    return tmp;

}();


function subMenuBrands(cat_id) {
    var tmp = null
    $.ajax({
        'async': false,
        'type': "GET",
        'global': false,
        'dataType': 'json',
        'url': "https://saze118.com/api/category/get_childs_menu/" + cat_id,
        // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
        'success': function (data) {
            tmp = data;
        }
    });
    return tmp;
};

function subCategoryBargain(cat_id) {
    // var tmp = null
    $.ajax({
        'async': false,
        'type': "GET",
        'global': false,
        'dataType': 'json',
        'url': "/bargain/getCat/" + cat_id,
        // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
        'success': function (data) {
            tmp = data;
        }
    });
    return tmp;
}

function scrollDown(id) {
    var id = $(this).attr('data-id');
    $('.ul-subcategory-right'+'#scroll-link-'+id).animate({
        scrollTop: '+=200'
    }, 600);
    return false
}

$(document).ready(function () {

    $.each(right_menu, function( index, value ) {

        if(index == 0) {
            $('.subcategory-wrapper').append('<ul class="ul-subcategory show" id="'+value.id+'">');
            //$('.wrapper-ul-sub-category-top-right').append('<ul class="ul-menu-toplist show" id="'+value.id+'">');
        } else {
            $('.subcategory-wrapper').append('<ul class="ul-subcategory" id="'+value.id+'">');
            //$('.wrapper-ul-sub-category-top-right').append('<ul class="ul-menu-toplist" id="'+value.id+'">');
        }
        $.each(right_menu[index]['child'], function( index_sub, value_sub ) {
            $('.ul-subcategory#'+value.id).append('<li><a data-id="'+value_sub.id+'" href="'+'#'/*value_sub.link*/+'">'+value_sub.title+'</a></li>');
            //$('.ul-menu-toplist#'+value.id).append('<li><a data-id="'+value_sub.id+'" href="'+value_sub.link+'">'+value_sub.title+'</a></li>');
        });
        $('.subcategory-wrapper').append('</ul>');
        //$('.wrapper-ul-sub-category-top-right').append('</ul>');

    });

    $.each(right_menu, function( index, value ) {

        if(index == 0) {
            //$('.subcategory-wrapper').append('<ul class="ul-subcategory show" id="'+value.id+'">');
            $('.wrapper-ul-sub-category-top-right').append('<ul class="ul-menu-toplist show" id="'+value.id+'">');
        } else {
            //$('.subcategory-wrapper').append('<ul class="ul-subcategory" id="'+value.id+'">');
            $('.wrapper-ul-sub-category-top-right').append('<ul class="ul-menu-toplist" id="'+value.id+'">');
        }
        $.each(right_menu[index]['child'], function( index_sub, value_sub ) {
            // $('.ul-subcategory#'+value.id).append('<li><a data-id="'+value_sub.id+'" href="'+value_sub.link+'">'+value_sub.title+'</a></li>');
            $('.ul-menu-toplist#'+value.id).append('<li><a class="ul-menu-toplist-item" data-id="'+value_sub.id+'" href="'+'#'/*value_sub.link*/+'">'+value_sub.title+'</a></li>');
        });
        // $('.subcategory-wrapper').append('</ul>');
        $('.wrapper-ul-sub-category-top-right').append('</ul>');

    });
    // $('.ul-subcategory li a').hover(
    //    function() {
    //
    //         var cat_id = $(this).attr('data-id');
    //         var datas = subMenuBrands(cat_id);
    //
    //         $('.sub-menu-brand div .contents .sub-menu-wrapper.grid-dp-14 a').remove();
    //         $('.ads_seller_item_box_top').remove();
    //         //$('.sub-menu-brand div').append('<div class="contents"></div>');
    //         //$('.sub-menu-brand .contents').append('<div class="sub-menu-wrapper grid-dp-14"></div>');
    //         //$('.sub-menu-brand .contents').append('<div class="brand-wrapper grid-dp-4"><div class="row"></div></div>');
    //
    //         $.each(datas['child'], function( index, value ) {
    //             if(value['child'].length <= 0) {
    //                 $('.sub-menu-wrapper.grid-dp-14').append('<a href="'+value.link+'">'+value.title+'</a>');
    //             } else {
    //                 $('.sub-menu-wrapper.grid-dp-14').append('<strong><a href="'+value.link+'">'+value.title+'</a></strong>');
    //                 $.each(value.child,function (index_c,value_c) {
    //                     $('.sub-menu-wrapper.grid-dp-14').append('<a href="'+value_c.link+'">'+value_c.title+'</a>');
    //                 })
    //             }
    //         });
    //
    //        $.each(datas['ads_seller'], function( index, value ) {
    //            $('.brand-wrapper.grid-dp-4 .row').append('<div class="grid-dp-9 ads_seller_item_box_top"><a href="'+value.link+'"><img src="'+value.logo+'"></a></div>');
    //        });
    //
    //
    //
    //
    //         // $('.subcategory-wrapper .sub-menu-brand').append(
    //         //    '<div class="contents">'+cat_id+'</div>'
    //         // );
    //         $(".sub-menu-brand").show();
    //
    //     }, function() {
    //
    //
    //
    //     }
    // );



    // $('.sub-menu-brand').mousemove(function() {
    //     $('.sub-menu-brand').show();
    // }).mouseout(function() {
    //     $('.sub-menu-brand').hide();
    // });


    $('.sub-menu-brand').on('mousemove',function(event) {
        $('.sub-menu-brand').show();
        //console.log('asd');
    }).on('mouseout',function(event) {
        $('.sub-menu-brand').hide();
        //console.log('dsa');
    });

    $('.sub-category-menu-top').on('mousemove',function(event) {
        $('.sub-category-menu-top').show();
    }).on('mouseout',function(event) {
        // $('.sub-category-menu-top').hide();
    });


    $('.category-box-top li a').click(function () {
        var href = $(this).attr('href');
        $('.ul-subcategory').removeClass('show');
        $(href+'.ul-subcategory').addClass('show');

        $('.category-box-top li a').removeClass('active');
        $(this).addClass('active');

        return false;
    });

    $('.types-menu-top a').click(function () {
        var href = $(this).attr('href');
        $(href).addClass('show');
        $('.ul-menu-toplist').removeClass('show');
        $(href).addClass('show');

        $('.types-menu-top a').removeClass('active');
        $(this).addClass('active');

        return false;
    });


    // LAZY LOAD
    var limit = 0;

    var win = $(window);

    var offset = 4;
    var data_json = [];
    var data_fetched = [];
    win.scroll(function() {
        var box = null;
        if ($(document).height() - win.height() >= /*win.scrollTop()*/ 500) {
            $('#loading').show();
            if(jQuery.inArray(offset, data_fetched) == -1) {
                //console.log('isNotInArray',data_fetched);

                data_fetched.push(offset);
                $.ajax({
                    url: 'https://saze118.com/api/category/get_childs_data_without_id/1/'+offset,
                    dataType: 'json',
                    beforeSend: function() {
                        //console.log('beforeSend');
                        //console.log($(document).scrollTop($(document).scrollTop()-50));
                        $('.loading-lazyload').show();
                    },
                    complete: function() {
                        $('.loading-lazyload').hide();
                    },
                    success: function(data) {
                        data_json = data;
                        var Items = '';
                        //console.log(data_json['categories'].length);
                        if(data_json['categories'].length != 0) {


                            $.each(data_json['categories'][0]['childs'],function(index,value){
                                var subChilds = '';
                                if(value['sub_childs'].length > 0) {
                                    subChilds = subChilds + '<ul id="subchild-'+value['id']+'" class="sub-childs">';
                                    $.each(value['sub_childs'],function(sub_childs_index,sub_childs_value){
                                        var newSubChild = '<li><a href="/search/'+sub_childs_value['id']+'">'+sub_childs_value['title']+'</a></li>';
                                        subChilds = subChilds + newSubChild;
                                    });
                                    subChilds = subChilds + '</ul>';
                                    var newItem = '<li class="has-sub-child"><a href="#" data-sub-child="'+value['id']+'">'+value['title']+'</a>';
                                    Items = Items + newItem+subChilds+'</li>';
                                } else {
                                    var newItem = '<li><a href="/search/' +value['id']+'">' +value['title']+'</a></li>';
                                    Items = Items + newItem;
                                }

                            });
                            var Logos = ''
                            $.each(data_json['categories'][0]['logo'],function(index,value){
                                var url = value.url;
                                var logo = 'https://saze118.com/upload/fa_big_logo_category/'+data_json['categories'][0]['id']+'/'+value['image'];
                                var hover_logo = 'https://saze118.com/upload/fa_big_logo_category/'+data_json['categories'][0]['id']+'/'+value['image_hover'];
                                var newlogo = '<div class="subcategory-brand-item">' +
                                    '<a href="'+url+'">' +
                                    '<img class="brand-logo-color" src="' +hover_logo+'">' +
                                    '<img class="brand-logo-bw" src="' +logo+'">' +
                                    '</a>' +
                                    '</div>';
                                Logos = Logos + newlogo;
                            });

                            var footerLinks = '';
                            $.each(data_json['category_box'],function(index,value){
                                var newfooterLink = '<a href="'+value.link+'" style="color:'+data_json['categories'][0]['color']+'">'+value.title+'</a>';
                                footerLinks = footerLinks + newfooterLink;
                            });
                            box = '<div class="row-category-boxes" id="'+data_json['categories'][0]['id']+'">\n' +
                                '          <div class="container">\n' +
                                '            <h1 class="title-category-box" style="color:'+data_json['categories'][0]['color']+'"><span>' +
                                '<a href="category/'+data_json['categories'][0]['id']+'">' +
                                data_json['categories'][0]['title'] +
                                '</a>' +
                                '</span></h1>\n' +
                                '            <div class="container-category">\n' +
                                '              <div class="row">\n' +
                                '                <div class="grid-dp-4">\n' +
                                '                  <div class="ul-subcategory-right-wrapper" style="border-color:'+data_json['categories'][0]['color']+'">' +
                                // '<a href="#" data-id="' +data_json['categories']['0']['id']+'" class="scroll-down"><span>Ø§Ø¯Ø§Ù…Ù‡ Ø¯Ø³ØªÙ‡ Ø¨Ù†Ø¯ÛŒ Ù‡Ø§</span><img src="assets/images/up-arrow.svg"></a>' +
                                // '<a href="#" data-id="'+data_json['categories']['0']['id']+'" class="scroll-top"><img src="assets/images/up-arrow.svg"></a>\n' +
                                '                    <ul class="ul-subcategory-right" id="scroll-link-' +data_json['categories']['0']['id']+'">\n'
                                +Items+
                                '                    </ul>\n' +
                                '                  </div>\n' +
                                '                </div>\n' +
                                '                <div class="grid-dp-14">\n' +
                                '                  <div class="row">\n' +
                                Logos+
                                '                  </div>\n' +
                                '                </div>\n' +
                                '              </div>\n' +
                                '            </div>\n' +
                                '<div class="footer-link-company-brand">'+footerLinks+'</div>'+
                                '          </div>\n' +
                                '        </div>';
                            $('#category-boxes-wrapper').append(box);
                            box = null;
                            offset++;


                        } else {
                            $('.loading-lazyload').hide();
                        }

                    }


                });


            }
            //$('body').scrollTop($('body').scrollTop()-150);

            // if(jQuery.inArray(offset, data_fetched) !== -1) {
            //     console.log('not in array');
            //     data_fetched.push(offset);
            // } else {
            //     console.log('is array')
            //     console.log(data_fetched);
            // }
            // console.log(data_fetched);

        }
        // $(".ul-subcategory-right").mCustomScrollbar({
        //
        // });

        $(".ul-subcategory-right").mCustomScrollbar({
            scrollButtons:{enable:true},
            // theme:"light-thick",
            mouseWheelPixels: 60,
            scrollbarPosition:"inside"
        });





        // $('.scroll-down').click(function () {
        //     var id = $(this).attr('data-id');
        //     $('.ul-subcategory-right'+'#scroll-link-'+id).animate({
        //         scrollTop: '+=200'
        //     }, 600);
        //     $(this).unbind("scroll");
        //     return false
        // });
        //
        // $('.scroll-top').click(function () {
        //     var id = $(this).attr('data-id');
        //     $('.ul-subcategory-right'+'#scroll-link-'+id).animate({
        //         scrollTop: '-=200'
        //     }, 600);
        //     return false
        // });

    });



    // menu-login-register
    $('.login-register-ul').click(function() {
        $('.menu-login-register').toggle();
    });

    $('.checkbox-item-tender').click(function() {

        if($(this).hasClass('selected')) {
            $(this).children('input[type="checkbox"]').prop( "checked", false );
            $(this).removeClass('selected')
        } else {
            $(this).children('input[type="checkbox"]').prop( "checked", true );
            $(this).addClass('selected')
        }
    });


    $('.ul-subcategory li a').mouseover(function() {

        var cat_id = $(this).attr('data-id');
        $('.sub-menu-brand').show();
        $('.sub-menu-brand div .contents .sub-menu-wrapper.grid-dp-14 a').remove();
        $('.ads_seller_item_box_top').remove();

        $.ajax({
            'type': "GET",
            'url': "https://saze118.com/api/category/get_childs_menu/" + cat_id,
            // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },

            beforeSend: function() {
                $('.loading-sub-brand').show();
            },
            success: function (data) {

                $('.sub-menu-brand div .contents .sub-menu-wrapper.grid-dp-14 a').remove();
                $('.ads_seller_item_box_top').remove();
                $.each(data['child'], function( index, value ) {
                    if(value['child'].length <= 0) {
                        $('.sub-menu-wrapper.grid-dp-14').append('<a href="'+value.link+'">'+value.title+'</a>');
                    } else {
                        $('.sub-menu-wrapper.grid-dp-14').append('<strong><a href="'+value.link+'">'+value.title+'</a></strong>');
                        $.each(value.child,function (index_c,value_c) {
                            $('.sub-menu-wrapper.grid-dp-14').append('<a href="'+value_c.link+'">'+value_c.title+'</a>');
                        })
                    }
                });

                $.each(data['ads_seller'], function( index, value ) {
                    $('.brand-wrapper.grid-dp-4 .row').append('<div class="grid-dp-9 ads_seller_item_box_top"><a href="'+value.link+'"><img src="'+value.logo+'"></a></div>');
                });

            },
            error: function(xhr) {

            },
            complete: function(data) {
                $('.loading-sub-brand').hide();
            }
        });

    });


    $('.ul-menu-toplist li a').click(function() {

        var cat_id = $(this).attr('data-id');
        $('.sub-category-menu-top .grid-dp-14.link-subcategory a').remove();
        $('.ads_seller_item_box_top').remove();

        $('.ul-menu-toplist li').removeClass('active');
        $(this).parents('li').toggleClass('active');

        $.ajax({
            'type': "GET",
            'url': "https://saze118.com/api/category/get_childs_menu/" + cat_id,
            // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },

            beforeSend: function() {
                $('.sub-category-menu-top .grid-dp-14.link-subcategory a').remove();
                $('.ads_seller_item_box_top').remove();
                $('.loading-menu-top').show();
                $('.sub-category-menu-top').show();
            },
            success: function (data) {
                $('.sub-category-menu-top .grid-dp-14.link-subcategory a').remove();
                $('.ads_seller_item_box_top').remove();
                $.each(data['child'], function( index, value ) {
                    if(value['child'].length <= 0) {
                        $('.sub-category-menu-top .grid-dp-14.link-subcategory').append('<a href="'+value.link+'">'+value.title+'</a>');
                    } else {
                        $('.sub-category-menu-top .grid-dp-14.link-subcategory').append('<strong><a href="'+value.link+'">'+value.title+'</a></strong>');
                        $.each(value.child,function (index_c,value_c) {
                            $('.sub-category-menu-top .grid-dp-14.link-subcategory').append('<a href="'+value_c.link+'">'+value_c.title+'</a>');
                        })
                    }
                });
                //
                $('.sub-category-menu-top .grid-dp-14.link-subcategory').append('<a class="more-subcategory-link" href="/category/'+cat_id+'">نمایش صفحه اختصاصی و کلیه زیر شاخه ها</a>');
                $.each(data['ads_seller'], function( index, value ) {
                    $('.sub-category-menu-top .grid-dp-4 .row').append('<div class="grid-dp-9 ads_seller_item_box_top"><a href="'+value.link+'"><img src="'+value.logo+'"></a></div>');
                });

            },
            error: function(xhr) {

            },
            complete: function(data) {
                $('.loading-menu-top').hide();
            }
        });

        return false;

    });


    // Search Page
    $('.checkbox-filter-search-item').click(function() {
        if(!$(this).hasClass('selected')) {
            $(this).children('input[type="checkbox"]').prop( "checked", true );
            $(this).addClass('selected')
            console.log($(this).children('input[type="checkbox"]').prop('checked'))
        } else {
            $(this).children('input[type="checkbox"]').prop( "checked", false );
            $(this).removeClass('selected')
        }
    });

  /*  $('.filter-category-search li').click(function() {
        $('.filter-category-search li').removeClass();
        $(this).addClass('selected');
        $(this).children('input').prop("checked", true);
    });*/



    $('.grids-view').click(function() {
        $('.view-type-search').removeClass('selected');
        $(this).addClass('selected');
        $('.search-item').addClass('grid-half');
    });

    $('.list-view').click(function() {
        $('.view-type-search').removeClass('selected');
        $(this).addClass('selected');
        $('.search-item').removeClass('grid-half');
    });

    // Buy & Sell View
    $('.grids-view.buy-sell').click(function() {
        $('.view-type-search').removeClass('selected');
        $(this).addClass('selected');
        $('.buy-sell-item').addClass('grid-half');
    });

    $('.list-view.buy-sell').click(function() {
        $('.view-type-search').removeClass('selected');
        $(this).addClass('selected');
        $('.buy-sell-item').removeClass('grid-half');
    });

    // Configuration Pages
    $('.select-category-setting-ul li').click(function() {
        if($(this).hasClass('selected')) {
            $(this).children('input[type="checkbox"]').prop( "checked", false );
            $(this).removeClass('selected')
        } else {
            $(this).children('input[type="checkbox"]').prop( "checked", true );
            $(this).addClass('selected')
        }
    });

    //filter buy-sell
    $('.filter-category-buy-sell > li a').click(function() {
        //console.log($(this).parent('li').find('ul').slideToggle());
        //return false;
    })


    // Show Number
    $('.show-number').click(function() {
        var section =  $(this).attr('href');
        $(section).show();
        return false;
    });

    // Gallery Buy & Sell Item
    $('.gallery-buy-sell-item-thumbnail a').click(function() {
        $('.gallery-buy-sell-item-thumbnail a').removeClass();
        $(this).addClass('active');

        var href = $(this).attr('href');
        $('.gallery-buy-sell-item-imgs').fadeOut('fast');
        $('.gallery-buy-sell-item-imgs'+href).fadeIn('fast');
        $('.gallery-buy-sell-item-imgs'+href).addClass('active');

        return false;
    });

    // cpl scroll box
    $(".content-box-cpl-list").mCustomScrollbar({
        scrollButtons:{enable:true},
        // theme:"light-thick",
        scrollbarPosition:"inside"
    });

    $('input[type="radio"][name="message_type"]').change(function() {
        if($(this).val() == 1) {
            $('.check-box-cpl-result').show();
        } else {
            $('.check-box-cpl-result').hide();
        }
    });

    $('.ul-tab li a').click(function() {

        var $href = $(this).attr('href');
        $(this).parents('.tab-wrapper').find('.ul-tab li').removeClass('active');
        $(this).parents('li').addClass('active');
        $(this).parents('.tab-wrapper').find('.tab-content .tab-item').hide();
        $(this).parents('.tab-wrapper').find('.tab-content'+' '+$href).show();
        return false;
    });


    // More Tender Sidebar
    $('.more-sidebar-tender').click(function() {
        $(this).parent('.row-tender-aside').find('.tender-aside-wrapper').css('max-height','1200px');
        return false;
    });


    $(".ul-subcategory").mCustomScrollbar({
        scrollButtons:{enable:true},
        // theme:"light-thick",
        scrollbarPosition:"inside"
    });

    $(".ul-menu-toplist").mCustomScrollbar({
        scrollButtons:{enable:true},
        // theme:"light-thick",
        scrollbarPosition:"inside"
    });

    $(document).mouseup(function(e)
    {
        console.log('mouseup',e.target.className);
        if(
            // e.target.parentElement.className == 'select-depth' ||
            // e.target.parentElement.className == 'title-item' ||
            // e.target.parentElement.className == 'select-depth-wrapper' ||
            //e.target.parentElement.className == 'back-toparent' ||
            // e.target.parentElement.className == 'title-select-depth' ||
            // e.target.parentElement.className == 'has-child' ||
            // e.target.parentElement.className == 'title-select-depth' ||
            e.target.parentElement.id == 'menu-top-link' ||
            e.target.parentElement.className == 'types-menu-top' ||
            e.target.className == 'ul-menu-toplist-item'
        ) {
        } else {
            $('.sub-menu-brand').hide();
            //$('.link-subcategory').hide();
            $('.menu-login-register').hide();
            $('#menu-top').removeClass('open');
            $('.sub-category-menu-top').hide();
            //$('.select-depth-wrapper').removeClass('open');
        }

        if(
            e.target.className == 'back-toparent' ||
            e.target.parentElement.className == 'has-child' ||
            e.target.parentElement.className == 'loading-select-depth'
            && $('.select-depth-wrapper').hasClass('open')
        )
        {} else if(e.target.parentElement.className == 'title-select-depth' && $('.select-depth-wrapper').hasClass('open')) {
            $('.select-depth-wrapper').removeClass('open');
        } else {
            $('.select-depth-wrapper').removeClass('open');
        }

    });

    $('.close-modal').click(function() {
        $('.modal-full').fadeOut();
    });

    $('.open-modal-search-item').click(function() {
        $('.modal-search-item').fadeIn();
    });

    $('.modal-search-item').click(function() {
        $(this).fadeOut();
    });

    // FAQ PAGE
    $('.faq-item .faq-item--question').click(function() {

        $('.faq-item--question').removeClass('active');
        $('.faq-item--answer').slideUp();
        $(this).addClass('active');
        $(this).parent('.faq-item').find('.faq-item--answer').slideDown();
    });

    // $('.ul-subcategory-right li a').on('click',function(event) {
    //
    // });



    // Select Depth

    $('.title-select-depth').click(function() {
        if($('.select-depth-wrapper').hasClass('open')) {
            $('.select-depth-wrapper').removeClass('open');
        } else {
            $('.select-depth-wrapper').addClass('open');
        }
        return false;
    });

    $( "body" ).delegate( ".ul-subcategory-right li.has-sub-child a", "click", function() {
        var sub_child_id = $(this).attr('data-sub-child');
        //$('.sub-childs').slideUp();
        $('#subchild-'+sub_child_id).slideToggle("slow");;
        return false;
    });

    var $parent_zero = subCategoryBargain($('.select-depth').attr('data-parent'));


    console.log($parent_zero);
    // if($('.select-depth').attr('data-parent') != 0) {
    //     $('.select-depth-wrapper').append('<a class="back-toparent" data-id="'+2+'" href="#">'+3+'</a>')
    //     $('.select-depth-wrapper').append('<div class="title-item">'+21+'</div>');
    // }
    // $.each($parent_zero['child'],function(index,value) {
    //     $('ul.select-depth-list').append('<li class="has-child"><a  data-id="'+value['id']+'" href="#">'+value['title']+'</a></li>');
    // });

    if($('.select-depth').attr('data-parent') != 0) {
        $('.select-depth-wrapper').append('<a class="back-toparent" data-id="'+$parent_zero['parent']['id']+'" href="#">'+$parent_zero['parent']['title']+'</a>')
        $('.select-depth-wrapper').append('<div class="title-item">'+$parent_zero['item']['title']+'</div>');
    }

    var body = '<ul class="select-depth-list">';
    $.each($parent_zero['child'],function(index,value) {
        if(value['hasChild'] == 1) {
            var hasChild = 'has-child';
        } else {
            var hasChild = '';
        }
        body = body + '<li class='+hasChild+'><a data-id="'+value['id']+'" href="#">'+value['title']+'</a></li>';
    });

    body = body + '</ul>';
    $('.select-depth-wrapper').append(body);

    $( "body" ).delegate( ".select-depth-list li a", "click", function() {

        var cat_id = $(this).attr('data-id');

        if($(this).parents('li').hasClass('has-child')) {


            $.ajax({
                'async': false,
                'type': "GET",
                'global': false,
                'dataType': 'json',
                'url': "/bargain/getCat/" + cat_id,
                // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
                'beforeSend':function() {
                    $('.loading-select-depth').show();
                },

                'success': function (data) {
                    $('ul.select-depth-list').remove();
                    $('.back-toparent').remove();
                    $('.title-item').remove();

                    if(cat_id != 0) {
                        $('.select-depth-wrapper').append('<a class="back-toparent" data-id="'+data['parent']['id']+'" href="#">'+data['parent']['title']+'</a>')
                        $('.select-depth-wrapper').append('<div class="title-item">'+data['item']['title']+'</div>');
                    }

                    var body = '<ul class="select-depth-list">';
                    $.each(data['child'],function(index,value) {
                        if(value['hasChild'] == 1) {
                            var hasChild = 'has-child';
                        } else {
                            var hasChild = '';
                        }
                        body = body + '<li class='+hasChild+'><a data-id="'+value['id']+'" href="#">'+value['title']+'</a></li>';
                    });

                    body = body + '</ul>';
                    $('.select-depth-wrapper').append(body);


                },
                'complete': function() {
                    $('.loading-select-depth').hide();
                    $(".select-depth-list").mCustomScrollbar({
                        scrollButtons:{enable:true},
                        scrollButtons:false,
                        // theme:"light-thick",
                        //mouseWheelPixels: 60,
                        scrollbarPosition:"inside"
                    });

                }
            });

        } else {

        }
        $('.input-select-depth').val(cat_id);
        $('.title-select-depth').text($(this).text());
        return false;
    });


    $( "body" ).delegate( ".back-toparent", "click", function() {

        var cat_id = $(this).attr('data-id');
        console.log(cat_id);

        $.ajax({
            'async': false,
            'type': "GET",
            'global': false,
            'dataType': 'json',
            'url': "/bargain/getCat/" + cat_id,
            // 'data': { 'request': "", 'target': 'arrange_url', 'method': 'method_target' },
            'success': function (data) {
                $('ul.select-depth-list').remove();
                $('.back-toparent').remove();
                $('.title-item').remove();
                if(cat_id != 0) {
                    $('.select-depth-wrapper').append('<a class="back-toparent" data-id="'+data['parent']['id']+'" href="#">'+data['parent']['title']+'</a>');
                    $('.select-depth-wrapper').append('<div class="title-item">'+data['item']['title']+'</div>');
                }

                var body = '<ul class="select-depth-list">';
                $.each(data['child'],function(index,value) {
                    if(value['hasChild'] == 1) {
                        var hasChild = 'has-child';
                    } else {
                        var hasChild = '';
                    }
                    body = body + '<li class='+hasChild+'><a data-id="'+value['id']+'" href="#">'+value['title']+'</a></li>';
                });

                body = body + '</ul>';
                $('.select-depth-wrapper').append(body);


            },
            'complete': function() {
                $(".select-depth-list").mCustomScrollbar({
                    scrollButtons:{enable:true},
                    scrollButtons:false,
                    // theme:"light-thick",
                    //mouseWheelPixels: 60,
                    scrollbarPosition:"inside"
                });
            }
        });
        return false;
    });


    //$('.select-depth-list li a').on('click',function(event) {

    //});

});

