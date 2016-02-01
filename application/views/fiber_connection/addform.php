
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="<?php echo base_url()?>fiberconnection/insert" >
                                       
                                        <div class="form-group">
                                            <select name="fiber_id" id="form_fiber_id" required>
                                                <option value="">Select a Fiber</option>
                                                <?php foreach($fiber as $row) { ?>

                                                     <option value="<?php echo $row->id; ?>"><?php echo $row->brand_name.':'.$row->drum_no.":".$row->no_of_cores; ?></option>

                                                <?php } ?>
                                            </select>
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>Connection Objective</label>
                                            <input type="text" name="objective" class="form-control" id="conn_obj" required/>

                                        </div>
                                         
                                        <div class="panel panel-default">
                                                <div class="panel-heading">Start Position</div>
                                                <div class="panel-body">
                                                      <div class="form-group">
                                                        <label>Enclosure</label>
                                                        <input type="text" id="start_enclosure" name="enclosure[]" class="form-control " required/>
                                                        <div id="list">
                                                        	<ul id="start_enc" class="list-unstyle">
                                                            	
                                                            </ul>
                                                        </div>

                                                      </div>
                                                      <div class="form-group">
                                                        <label>Location</label>
                                                        <input type="text" id="start_location" name="location[]" class="form-control" required/>

                                                      </div>
                                                      
                                                      <div class="form-group">
                                                        
                                                        <label>Gps(long/lat)</label>
                                                        <table><tr>
                                                        <td><input type="text" id="start_long" name="longitude[]" class="form-control" placeholder="longitude" required /></td>
                                                        <td> <input type="text" id="start_lat" name="lattitude[]" class="form-control" placeholder="lattitude" required /></td></tr></table>
                                                      </div>
                                                      
                                                      
                                                      <div class="form-group">
                                                        <label>Start Point. </label>
                                                        <input type="text" id="start_point" name="point[]" class="form-control" />

                                                      </div>
                                                      
                                                </div>
                                        </div>
                                        <div class="panel panel-default">
                                                <div class="panel-heading">End Position</div>
                                                <div class="panel-body">
                                                      <div class="form-group">
                                                        <label>Enclosure</label>
                                                        <input type="text" id="end_enclosure" name="enclosure[]" class="form-control" required/>						
                                                        <div id="list">
                                                        	<ul id="end_enc" class="list-unstyle">
                                                            	
                                                            </ul>
                                                        </div>

                                                      </div>
                                                       <div class="form-group">
                                                        <label>Location</label>
                                                        <input type="text" id="end_location" name="location[]" class="form-control"  required/>

                                                      </div>
													
                                                    <div class="form-group">
                                                        <label>Gps(long/lat)</label>
                                                        <table><tr>
                                                        <td><input type="text" id="end_long" name="longitude[]" class="form-control" required /></td>
                                                       <td> <input type="text" id="end_lat" name="lattitude[]" class="form-control" required /></td></tr></table>
                                                      </div>
                                                      
                                                      <div class="form-group">
                                                        <label>End Point. </label>
                                                        <input type="text" id="end_point" name="point[]" class="form-control" />

                                                      </div>
                                                     
                                                      
                                                </div>
                                        </div>
                                        
                                        <button id="submit" type="submit" class="btn btn-default">Submit Button</button>
                                        <button id="reset" type="reset" class="btn btn-default">Reset Button</button>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                              
                             
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
           <script>
               $(document).ready(function(){
        
                        var base_url = $('body').attr('data-url');
                        
                       

                         $('#submit').click(function(){
                                            

                                /*var error = 0;
                                
                                if($('#conn_obj').val() == ""){

                                    error++;
                                }
                               
                                if($('#form_fiber_id').val() == ""){

                                    error++;
                                }
                                if(error!= 0){
                                   
                                    alert("Empty feilds");
                                    return false;
                                }
                                */

                               $('#start_point').val();
                               $('#end_point').val();
                               var length = parseInt($('#end_point').val()) - parseInt($('#start_point').val());
                               var fiber_id = $('#form_fiber_id').val();
                               //alert(fiber_id);

                               $.get(base_url+'fiberconnection/ajax_check_fiber_length/'+fiber_id+'/'+length,function(data){

                                     if(data == 0){

                                        return false;
                                     }

                               })
                                
                         });
                                    
                        $('#reset').click(function(){

                             window.location = base_url+"fiberconnection/add";

                        });
          						

                      // get relevent data using enclosure
          						$('#start_enclosure').keyup( function(){
          							var enclosure = $(this).val();
          							$('#start_enc').html('');
          							$.get(base_url+'fiberconnection/ajax_keyword_enclosure/'+enclosure, function(data){
          								//alert(data);
          								var json = $.parseJSON(data);
          								for(var i=0; i < json.length; i++ ){
          									
          									$('#start_enc').append('<li><a class=dyn_s val="'+ json[i].id +'" href=#>'+ json[i].name+' '+json[i].location +'</a></li>')
          								}
          								
          								});
          							
          							
          						});
						
						$(document).on('click','.dyn_s',function(e){
							
						           e.preventDefault();
								   var id = $(this).attr('val');
								   $.get(base_url+'fiberconnection/ajax_enclosure/'+id, function(data){
									   //alert(data);
									    var json = $.parseJSON(data);
									    $('#start_location').val(json[0].location);
									    $('#start_lat').val(json[0].lattitude);
										$('#start_long').val(json[0].longitude);
										$('#start_enclosure').val(json[0].name);
										$('#start_enc').html('');
									});
						});
						
						
						
						$('#end_enclosure').keyup( function(){
							var end_enclosure = $(this).val();
							$('#end_enc').html('');
							$.get(base_url+'fiberconnection/ajax_keyword_enclosure/'+end_enclosure, function(data){
								//alert(data);
								var json = $.parseJSON(data);
								for(var i=0; i < json.length; i++ ){
									
									$('#end_enc').append('<li><a class=dyn_e val="'+ json[i].id +'" href=#>'+ json[i].name +'</a></li>')
								}
								
								});
							
							
						});
						
						$(document).on('click','.dyn_e',function(e){
							
						           e.preventDefault();
								   var id = $(this).attr('val');
								   $.get(base_url+'fiberconnection/ajax_enclosure/'+id, function(data){
									   //alert(data);
									    var json = $.parseJSON(data);
									    $('#end_location').val(json[0].location);
									    $('#end_lat').val(json[0].lattitude);
										$('#end_long').val(json[0].longitude);
										$('#end_enclosure').val(json[0].name);
										$('#end_enc').html('');
									});
						});

            /*$('#start_location').blur(function(){

                 var location = $('#start_location').val();
                 $.get('https://maps.googleapis.com/maps/api/geocode/json?address='+location,function(data){
                      
                          
                          $('#start_long').val(data.results[0].geometry.location.lng);
                          $('#start_lat').val(data.results[0].geometry.location.lat);
 
                 });
            
            });
*/

            /*$('#end_location').blur(function(){

                 var location = $('#end_location').val();
                 $.get('https://maps.googleapis.com/maps/api/geocode/json?address='+location,function(data){
                      
                          
                          $('#end_long').val(data.results[0].geometry.location.lng);
                          $('#end_lat').val(data.results[0].geometry.location.lat);
 
                 });
            
            });
*/
                     
            });
           </script>