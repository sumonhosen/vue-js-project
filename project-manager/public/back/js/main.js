

$(document).ready(function(){
	// Disable anchor tag
	$("a[href='#']").click(function (e) { e.preventDefault(); });
	// $(".has_sub_menu a").click(function (e) {
	// 	e.preventDefault();
	// });
	// $(".main-sidebar li a").click(function (e) {
	// 	// $(this).addClass('temp_class');
	// 	// // $('.main-sidebar ul li').removeClass('active');
	// 	// $('.temp_class').addClass('active');
	// 	// $(this).removeClass('temp_class');

	// 	// if($(this).hasClass("active")){
	// 	// 	$(this).removeClass('temp_class');
	// 	// }else{
	// 	// 	$(this).addClass('temp_class');
	// 	// }
	// 	$('.main-sidebar ul li a').removeClass('active');
	// 	$('.main-sidebar ul li').removeClass('active');
	// 	// $('.temp_class').addClass('active');
	// 	// $('.temp_class').removeClass('temp_class');
	// 	$(this).addClass('active');
	// 	$(this).parents('li').addClass('active');
	// });

	// $(".has_sub_menu.active").click(function (e) {
	// 	alert(123);
	// 	$(this).removeClass('active');
	// });

	// $('.main-sidebar ul li a.active').parents('li').addClass('active');
});

// Mobile menu trigger
function menuTrigger(){
	if($('.main-sidebar').hasClass('mobile_active')){
		$('.main-sidebar').removeClass('mobile_active');
	}else{
		$('.main-sidebar').addClass('mobile_active');
	}
}

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

// Uploaded image get url
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('.uploaded_img').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(document).on('change', ".image_upload", function(){
    readURL(this);
});

// $(".image_upload").click(function(){
//     // readURL(this);
//     alert(245);
// });

// Custom loader
function cLoader(type = 'show'){
    if(type == 'show'){
        $('.loader').show();
    }else{
        $('.loader').hide();
    }
}

// Tooltips
$('.c_tooltip').tooltip();
