$(document).ready(function(){

	//gallery hover effect
	$('.gallery .media img').hover(function(){
		$('.gallery .media img').addClass('inactive');
		$(this).removeClass('inactive').addClass('active');
	}, function(){
		$('.gallery .media img').removeClass('inactive');
	});

	//menu show more items btn
	function update_btn(old_btn_id, new_btn_id, btn_content){
		$(old_btn_id).removeAttr('id');
			$('.load-more a').attr({
				id : new_btn_id
			});
			$('#' + new_btn_id).html(btn_content);
	}

	$(document).on('click', 'a#more_items', function(event) {	    
		event.preventDefault();
		$('.menu .hidden_items').slideDown({duration:800,  easing: "easeInOutQuart", complete : function(){
			update_btn('#more_items', 'hide_items', 'приховати<hr/><span class="top_arrow"></span>');
		}});
	});
	

	$(document).on('click', 'a#hide_items', function(event) {	    
		event.preventDefault();		
		$('.menu .hidden_items').slideUp({duration:800,  easing: "easeInOutQuart", complete : function(){
			update_btn('#hide_items', 'more_items', 'показати більше<hr/><span class="bottom_arrow"></span>');
		}});	    
	});

	$(".radio .address").bind("change click", function () {
		if ($(this).hasClass('new_addr_radio')){
			if ($(this).prop('checked')) {
				$('.new_addr').val('').slideDown("fast");
			}
		} else {
				$('.new_addr').slideUp("fast");
		}
	});
	$(".radio .last_address").click(
		function(){
			var addr = $(this).data("address");
			$(".new_addr").val(addr);
		}
	);

	$(".radio .time").bind("change click", function () {
		if ($(this).hasClass('new_time_radio')) {
			if ($(this).prop('checked')) {
				$('.new_time').slideDown("fast");
			}
		} else {
			$('.new_time').slideUp("fast");
		}
	});


});

