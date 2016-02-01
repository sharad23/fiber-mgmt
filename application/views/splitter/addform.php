<style>
.switch th,td{ padding:5px;  }
</style>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <form role="form" method="post" action="<?php echo base_url()?>splitter/insert" >
                                       
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input id="name" class="form-control" name="name" required>
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input id="location" class="form-control" name="location" required>
                                        </div>

                                          <div class="form-group">
                                            <label>Gps(long/lat)</label>
                                            <table><tr>
                                            <td><input type="text" id="start_long" name="longitude" class="form-control" required /></td>
                                            <td> <input type="text" id="start_lat" name="lattitude" class="form-control" required /></td></tr></table>
                                          </div>

                                        <div class="form-group">
                                            
                                            <select id="type" name="type"  required>
                                                <option value="">Select Splitter Type</option>
                                                <option value="">-------------</option>
                                                <option value="1">L1</option>
                                                <option value="0">L2</option>
                                            </select>
                                        
                                        </div>

                                        <div class="form-group">
                                            
                                            <select id="splitter_output" name="output_ratio"  required>
                                                <option value="">Select Splitter Output</option>
                                                <option value="">-------------</option>
                                                <option value="4">4</option>
                                                <option value="8">8</option>
                                            </select>
                                        
                                        </div>
                                       
                                        <div class="form-group" id="olt_info" >
                                             
                                            <label>Olt Info</label>
                                            <table><tr>
                                            <td><input type="text"  name="olt_name" class="form-control" placeholder='Olt Name' /></td>
                                            <td><input type="text"  name="olt_port" class="form-control" placeholder='Olt Port'  /></td></tr></table>
                                       
                                       </div>

                                        <div class="form-group" id="splitter" >
                                             
                                            <label> Splitter </label>
                                            <table>
                                                <tr>
                                                    <td>
                                                         <select name="l1_splitter_id" id="l1_splitter_id">
                                                               <option>Select a splitter</option>

                                                         </select>
                                                    </td>
                                                    <td>
                                                         <select name="splitter_output_id" id="l1_splitter_output">
                                                               <option>L1 Splitter Output</option>
                                                         </select>
                                                    </td>
                                                </tr>
                                            </table>
                                          
                                        </div>

                                         <div class="panel panel-default">
                                                <div class="panel-heading">Olt To splitter</div>
                                                <div class="panel-body">
                                                      <div class="form-group">
                                            <table width="100%" class="switch">
                                            <tr>
                                                <th>Start Address</th>
                                            	  <th>Start Enclosure</th>
                                                <th>End Enclosure</th>
                                                <th>Core color</th>
                                                <th></th>
                                            </tr>
                                            <tbody id="cont">
                                                  <tr class="dynamic">
                                                          <td>
                                                             <input id="conn_id" type="hidden" name="conn_id[]" />
                                                             <input id="keyword" type="text" name="start_address" />
                                                              <div id="list">
                                                                  <ul id="start_enc" class="list-unstyle">

                                                                  </ul>
                                                              </div>
                                                          </td>
                                                          <td>
                                                          <select class="form-control dyn_start_enclosure" name="start_enclosure[]">
                                                          	<option value="">Select</option>
                                                              <option value=""></option>
                                                          </select>
                                                          </td>
                                                          <td>
                                                          <select class="form-control dyn_end_enclosure" name="end_enclosure[]">
                                                          	<option value="">Select</option>
                                                              <option value=""></option>
                                                          </select>
                                                          </td>
                                                          <td>
                                                          <select class="form-control core_color1" name="core_color1[]">
                                                          	<option value="">Select</option>
                                                              <option value=""></option>
                                                          </select>
                                                          </td>
                                                          
                                                          <td><button id="add_more" class="btn btn-primary">Add More</button></td>
                                                   </tr>
                                           </tbody>
                                                        
                                            </table>          
                                                        
                                                        
                                                       
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
                                            

                                        
                        });
                                    
                        $('#reset').click(function(){

                             window.location = base_url+"client/add";

                        });

                        $('#keyword').keyup(function(){
                              
                              $('#start_enc').html('');
                              var keyword = $('#keyword').val();
                              $.get(base_url+'splitter/ajax_get_location/'+keyword,function(data){

                                   var json = $.parseJSON(data);
                                    for(var i=0; i < json.length; i++ ){
                                        
                                        $('#start_enc').append('<li><a class=dyn_s val="'+ json[i].location +'" href=#>'+ json[i].location +'</a></li>')
                                    }
                              });
                        });

                        $(document).on('click','.dyn_s',function(e){
                            
                                   e.preventDefault();
                                   var id = $(this).attr('val');
                                   $('#start_enc').html('');
                                   $('#keyword').val(id);
                                   $.get(base_url+'splitter/ajax_get_enclosure/'+id, function(data){
                                        
                                        $('.dynamic:first').find('.dyn_start_enclosure').html('<option value="">Select</option>');
                                        $('.dynamic:first').find('.dyn_start_enclosure').append('<option value="">----------</option>');
                                        var json = $.parseJSON(data);
                                        for(var i =0; i < json.length; i++){
                                            
                                               $('.dynamic:first').find('.dyn_start_enclosure').append('<option value='+ json[i].id +'>'+ json[i].name+':'+json[i].location +'</option>')

                                        }
                                        
                                       
                                    });
                                    
                        });
                        $(document).on('change','.dyn_start_enclosure',function(){ 
                        //$('.dyn_start_enclosure').change(function(){

                              var start = $(this).val()
                              var clickwhich = $(this)
                              $.get(base_url+'splitter/ajax_get_connected_enclosure/'+start,function(data){
                                             
                                     // alert(data);
                                      clickwhich.closest('.dynamic').find('.dyn_end_enclosure').html('<option value="">Select</option>');
                                      clickwhich.closest('.dynamic').find('.dyn_end_enclosure').append('<option value="">----------</option>');
                                      var json = $.parseJSON(data);
                                      for(var i =0; i < json.length; i++){
                                               
                                              if(json[i].start_enclosure == start){
                                                  
                                                   clickwhich.closest('.dynamic').find('.dyn_end_enclosure').append('<option value='+ json[i].end_enclosure+'/'+json[i].id +'>'+ json[i].end_name+':'+json[i].end_location +'</option>')
                                               }
                                               else{

                                                   clickwhich.closest('.dynamic').find('.dyn_end_enclosure').append('<option value='+ json[i].start_enclosure+'/'+json[i].id +'>'+ json[i].start_name+':'+json[i].start_location +'</option>')
                                               }
                                      }

                              });
                        })
                         
                         $(document).on('change','.dyn_end_enclosure',function(){ 
                         //$('.dyn_end_enclosure').change(function(){
                                
                                var arr = $(this).val().split('/');
                                var conn_id = arr[1];
                                var enclosure_id =arr[0];
                               
                                var clickwhich = $(this)
                                clickwhich.closest('.dynamic').find('#conn_id').val(conn_id);
                                clickwhich.closest('.dynamic').find('.core_color1').html('<option value="">Select</option>');
                                clickwhich.closest('.dynamic').find('.core_color1').append('<option value="">-------</option>');
                                clickwhich.closest('.dynamic').find('.core_color2').html('<option value="">Select</option>');
                                clickwhich.closest('.dynamic').find('.core_color2').append('<option value="">-------</option>');
                                $.get(base_url+'splitter/ajax_get_connction_core/'+conn_id,function(data){
                                      
                                          var json = $.parseJSON(data);
                                          for(var i =0; i < json.length; i++){

                                              clickwhich.closest('.dynamic').find('.core_color1').append('<option value='+ json[i].id  +'>'+ json[i].name +'</option>')
                                              clickwhich.closest('.dynamic').find('.core_color2').append('<option value='+ json[i].id  +'>'+ json[i].name +'</option>')
                                          }

                                });

                         });
                        
                         $('#add_more').click(function(e){

                              e.preventDefault();
                              $('.dynamic:first').clone().appendTo('#cont');
                              $('.dynamic:last').find('#keyword').remove();
                              $('.dynamic:last').find('#add_more').attr('id','remove');
                              $('.dynamic:last').find('#remove').html('Remove');
                              var end_closure_text_value = $('.dynamic:last').prev().find(".dyn_end_enclosure option:selected").text();
                              var end_closure_comb = $('.dynamic:last').prev().find(".dyn_end_enclosure").val();
                              var end_closure_value_array = end_closure_comb.split('/');
                              var end_closure_value = end_closure_value_array[0];
                              $('.dynamic:last').find('.dyn_start_enclosure').html('<option value="">Select</option>');
                              $('.dynamic:last').find('.dyn_start_enclosure').append('<option value="">---------</option>');
                              $('.dynamic:last').find('.dyn_start_enclosure').append('<option value='+end_closure_value +'>'+end_closure_text_value +'</option>');




                             
                         });

                         $(document).on('click','#remove',function(e){
                                
                                 e.preventDefault();
                                 $(this).closest('.dynamic').remove();
                         });

                        

                         
                         $('#type').change(function(){

                              var type = $(this).val();
                              if(type == 1){

                                  $('#olt_info').show();
                                  $('#splitter').remove();
                              }
                              else{

                                  $('#olt_info').remove();
                                  $.get(base_url+'splitter/ajax_get_L1_splitter/',function(data){
                                         
                                        var json = $.parseJSON(data);
                                        for(var i =0; i < json.length; i++){
                                            
                                               $('#l1_splitter_id').append('<option value='+ json[i].id +'>'+ json[i].location +':'+json[i].name +'</option>')

                                        }

                                       


                                  });

                              }
                         });

                         $('#l1_splitter_id').change(function(){

                               var id =  $(this).val();
                               $.get(base_url+'splitter/ajax_get_splitter_output/'+id,function(data){
                                        
                                        var json = $.parseJSON(data);
                                        for(var i =0; i < json.length; i++){
                                            
                                               $('#l1_splitter_output').append('<option value='+ json[i].id +'>'+ json[i].output_no +'</option>')

                                        }

                                        $.get(base_url+'splitter/ajax_get_splitter_connection/'+id,function(data){

                                              var json = $.parseJSON(data);
                                              var count =  json.length;
                                              $('.dynamic:first').find('.dyn_start_enclosure').html('<option>Select</option><option value='+ json[count-1].end_enclosure_id +'>'+ json[count-1].end_enclosure +'</option>')
                                        
                                        });

                                        

                               });

                         });

                         /* $('#location').blur(function(){

                               var location = $('#location').val();
                               $.get('https://maps.googleapis.com/maps/api/geocode/json?address='+location,function(data){
                                    
                                        
                                        $('#start_long').val(data.results[0].geometry.location.lng);
                                        $('#start_lat').val(data.results[0].geometry.location.lat);
               
                               });
                          
                          });

                        */
            });
           </script>