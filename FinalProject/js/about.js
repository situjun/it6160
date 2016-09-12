$(document).ready(function(){

	//show the add function
	$('.placeholder').click(function(){
		var c = $(this).attr( "class" );
		if(c!='col-xs-6 col-sm-3 placeholder itemSelected'){
			$('.placeholder').removeClass('itemSelected');
			$(this).addClass('itemSelected');
			$('.itemAdd').hide();
			$('.itemSelected').find('.itemAdd').show();
		}
	});

	
});