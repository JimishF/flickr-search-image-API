
STATE = {
	last : 0,
	current : 0,
	text : "",
	isLoading : false,
	isFirst : true
}

function parseSquare( str ) {
	return str.replace("_z","_q");
}

function backtoz( str ){
	return str.replace("_q","_z");
}

function modal_handler( self )
{
	var staticlazyimg = $(self).attr("src");
	var newmainimg = backtoz( $(self).attr("src") );
	var ref = $(self).attr('data-ref'); 
		$("#dwnld").attr('data-ref',ref);
	var m_htm = '<img src="'+staticlazyimg+'" style="width:100%" class="init_load_img" /><img src="'+newmainimg+'" style="display:none;width:100%" onload="mainImgLoaded(this)" class="final_load_img" />';
	$("#dwnld").attr("href",newmainimg);
	var m_txt = $(self).parent().children().text();
	
	$(".modal-content").html(m_htm);
	$(".modal-footer").find('p').text( m_txt );
	$('#modal1').openModal();
}

function mainImgLoaded ( self ){
	var i_h = $(self).height();
	var i_w = $(self).width();

	$(self).show();
	$($(self).parent().children()[0]).remove();
	
}

function imgloaded( self ){
	// console.log(self);
	$(self).show();
	$($(self).parent().children()[0]).remove();
	
	$(self).click(function(){
		modal_handler( $(this) );
	});
	// console.log(self);
}
			
	$(document).ready(function () {

		// $('body').on('click', '.card-image', function() {
		// 		alert("popup");
		// });

	var path = window.location.pathname;
	var page = path.split("/").pop();
	console.log( page );
	
		function loadxim( func ){
			if ( STATE.isLoading )
			{	
				console.log("re init");
				return;
			}
			else
			{
				STATE.isLoading = true;
		   	}				   	
		   	$("#loading").show();	
			$("#noResults").hide();
			
			$.post("./service/",{text:STATE.text,current:STATE.current,current:STATE.current}).done(function(d){
				 STATE.isLoading = false; func(d);  
				 STATE.current = d.current;
			});				
		};

		$('main').on('scroll',function() {
			// console.log($('main').scrollTop() +" -- "+ $('main').innerHeight() +" -- "+$('main')[0].scrollHeight  );
		    if( STATE.isFirst || ( $('main').scrollTop() + $('main').innerHeight() +20 >= $('main')[0].scrollHeight ) ) {
							 STATE.isFirst =false;		
		   			loadxim(function(dx)
		   			{
		   				console.log("loading..");
			   			setTimeout(function(){
			   				data = dx.data;
			   				if( data.length!= undefined && data.length > 0){

				   				for (var i = 0; i < data.length; i++)
				   				{
				   					// console.log(data[i]);
				   					var newCard = document.createElement('div');
				   					var ref = data[i].id;
				   					$(newCard).attr("class","col s6 m4 l3");
				   					var htm = '<div class="card"><div class="card-image "><img src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" class="init_load_img" />  <img src="'+parseSquare(data[i].sq_url)+'" style="display:none" onload="imgloaded(this)" class="final_load_img materialboxed" /> <div class="card-content">'+data[i].title +'</div></div></div>';
				   						$(newCard).html( htm );
									   		$("#mainData").append($(newCard));		
				   				}
			   				}else{
			   					$("#noResults").show();
			   				}
			   				$("#loading").hide();		
			   			},0);		
		   			});
		    }
		});

		$('body').on('click','.del-act',function () {
			var self = this;
			STATE.last = $(this).data('ref');

			$.post("./service/remove.php",{
					ref_id:$(this).data('ref')
				})
			.done(function( d ){
			
				$(".btn-undo").removeAttr("disabled");
				 var col = $(self).closest(".col");
				 col.fadeOut(300)
					setTimeout(function(){
						col.remove();
					},300)
				// console.log( d );
			});
		});

		$('#searchform').on('submit',function(e){
			
			$("#mainData").html("");
			$("#loading").show();
			STATE.text = $("#searchText").val();
			STATE.isFirst = true;
			STATE.last = 0;
			STATE.current = 0;

			console.log(STATE.text);
			$('main').trigger('scroll');
			return false;

		
		});
		$('body').on('click','.btn-undo',function(){

			$(this).attr("disabled","");

				$.post("./service/remove.php",{ref_id:STATE.last, "donot":"true"}).done(function( d ){
					 Materialize.toast('Last file( id :'+STATE.last+' ) has been undeleted!', 4000)
				});
		});

		$("#noResults").hide();
		$('main').trigger('scroll');
	});
		