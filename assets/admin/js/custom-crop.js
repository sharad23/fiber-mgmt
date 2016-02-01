$(document).ready(function(){
		
		var base_url = $('body').attr('data-url');
		
		var croppicContainerModalOptions = {
						
						uploadUrl:base_url+'index.php/admin/NewsAndEvents/ajaxUpload',
						cropUrl: base_url+'index.php/admin/NewsAndEvents/crop',
						modal:true,
						outputUrlId:'myOutputId',
						imgEyecandyOpacity:0.4,
						loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div>',
						onAfterImgCrop:function(){ 
                          
                           $('#image1').hide();
                           var name = $('#myOutputId').val();
                           
                            //create a a div and that shows the cropped image 
                           $('#potrait').html('');
                           $('#potrait').append('<img height="300" width="400" src='+base_url+name+'>')
                           
					   }
						
				}
		var cropContainerModal = new Croppic('image1',croppicContainerModalOptions);

		 $('#submit').click(function(){

                            var error = 0;
                            if($('#title').val() == ""){

                                error++;
                            }
                            if($('#myOutputId').val() == ""){

                                error++;
                            }
                            if(error!= 0){
                               
                                alert("Empty feilds");
                                return false;
                            }
                    });
                    
        $('#reset').click(function(){

             window.location = base_url+"index.php/admin/NewsAndEvents/add";

        });

});