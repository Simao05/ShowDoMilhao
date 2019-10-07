$(function(){

    $('.SdM_Alternativa div').click(function(){

		$('.SdM_Alternativas div div').css({'background-color':'rgb(200, 200, 200)'});

		$(this).css({'background-color':'rgb(100, 230, 100)'});

    });
	
	$('.SdM_Alternativa input').click(function(){

		$('#button_escolha').removeAttr('disabled');;

    });
	
});