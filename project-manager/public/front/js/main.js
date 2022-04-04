$(document).ready(function(){
	// Disable anchor tag
	$("a[href='#']").click(function (e) { e.preventDefault(); });
});

$(window).scroll(function () {
    var scrollTop = $(window).scrollTop();
    if (scrollTop > 50) {
        $('.fixed_header').addClass('background');
    }
    else {
        $('.fixed_header').removeClass('background');
    }
});

// Alert Script
const Toast = Swal.mixin({
    toast: true,
    position: 'center-center',
    showConfirmButton: false,
    background: '#E5F3FE',
    timer: 4000
});
function cAlert(type, text){
    Toast.fire({
        icon: type,
        title: text
    });
}

// Custom loader
function cLoader(type = 'show'){
    if(type == 'show'){
        $('.loader').show();
    }else{
        $('.loader').hide();
    }
}

// Live Search
$("body").click(function(){
    $(".live_status").fadeOut();
});

// Disabled link
// $(document).on('click', '.disabled', function(){
//     return preventDefault();
// });
$(".disabled").click(function(e) {
  e.preventDefault();
});

// Right Side Cart Section
$('.top_cart').click(function () {
    $('.side_cart_section').addClass('show_sc');
});
$('.close_sc').click(function () {
    $('.show_sc').removeClass('show_sc');
});
$(document).click(function (e) {
	if ($(e.target).parents(".side_cart_section").length === 0 && $(e.target).parents(".top_cart").length === 0) {
		$('.show_sc').removeClass('show_sc');
	}
});
function appendRightCart(item, cart_total, item_count){
    $('.side_cart_section').addClass('show_sc');
    $('.cart_have_items').show();
    $('.sc_empty').hide();
    $('.sc_amount span').html(cart_total);
    $('.sc_count').html(item_count);
    $('.scp_list').prepend(item);
}


// View Password
$(document).on('click', '.view_password_btn', function(){
    let type = $(this).closest('.view_password_group').find('input').attr('type');

    if(type == 'password'){
        $(this).closest('.view_password_group').find('input').attr('type', 'text');
    }else{
        $(this).closest('.view_password_group').find('input').attr('type', 'password');
    }
});
