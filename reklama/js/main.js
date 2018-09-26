(function($) {

	$(function() {
    	$(document).ready(function() { 
			$('.question').removeClass('hidden');
			$('.question').css({top: ($( window ).height() - 205)/2 });
			
			$(window).on('resize',function(){
				
				$window_height = $(window).height();
				
				$('.question').css({top: ($( window ).height() - 205)/2 });
				
			});
			
			$('.question').on('click', function(e){
				$('.question').addClass('hidden');
				$('#overlay').fadeIn(400, 
				 	function(){ 
						$('#modal_form') 
							.css('display', 'block') 
							.animate({opacity: 1, top: '50%'}, 200); 
				});
			});
		
			$('a#go').click( function(event){ 
				event.preventDefault(); 
				$('#overlay').fadeIn(400, 
				 	function(){ 
						$('#modal_form') 
							.css('display', 'block') 
							.animate({opacity: 1, top: '50%'}, 200); 
				});
			});
			$('#modal_close, #overlay').click( function(){ 
				closeModalForm();
			});

			$('#send-form').submit(function(){
				var data = {
					name:      $(this).find('*[name="name"]').val(),
					salon:     $(this).find('*[name="salon"]').val(),
					email:     $(this).find('*[name="email"]').val(),
					telephone: $(this).find('*[name="telephone"]').val(),
					comment:   $(this).find('*[name="comment"]').val()
				}
				$.ajax({
				    url: './ajax/sendMail.php',
				    type: 'POST',
				    data: {data: JSON.stringify(data)},
				    dataType: 'json',
				    success: function(res) {
				    	if ( res.error ) {
			    			alert(res.errorMsg);
				    	} else {
		    				alert('Отправлено!');
								closeModalForm();
				    	}
				    },
				    error: function(res){
				    	alert(res.errorMsg);
				    }
				});

				return false;
				
			});

		});
	})

})(jQuery);

function closeModalForm() {
	$('#modal_form').animate({opacity: 0, top: '45%'}, 200,  
		function(){ 
			$(this).css('display', 'none'); 
			$('#overlay').fadeOut(400); 
			$('.question').removeClass('hidden');			
		}
	);
}
// //запрет на перетаскивание
// document.ondragstart = test;
// //запрет на выделение элементов страницы
// document.onselectstart = test;
// //запрет на выведение контекстного меню
// document.oncontextmenu = test;

// function test() {
// 	return false
// };

// window.onkeydown = function(evt) {
//     if(evt.keyCode == 123 || evt.ctrlKey) return false;
// };

// window.onkeypress = function(evt) {
//     if(evt.keyCode == 123 || evt.ctrlKey) return false;
// };