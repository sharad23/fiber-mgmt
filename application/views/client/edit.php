<style>
.switch th,td{ padding:5px;  }
</style>
<?php if($data[0]->service_type == 1){
           
            $service = "Normal";
      }
      elseif($data[0]->service_type == 0){
          
           $service = "Dark core";
      }
      elseif($data[0]->service_type == 2){

           $service = "FTTH";
      }

      if($data[0]->core_type == 1){

           $core = "Single";
      }
      else{

           $core = "Double";
      }
?>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-10">
                                    <form role="form" method="post" action="<?php echo base_url()?>client/update" >
                                        <input type="hidden" name="id" value="<?php echo $data[0]->id; ?>" />
                                        <div class="form-group">
                                            <label>Client Name</label>
                                            <input id="name" class="form-control" name="name" value="<?php echo $data[0]->name; ?>">
                                        </div>
                                       
                                        <div class="form-group">
                                            <label>Client Location</label>
                                            <input id="name" class="form-control" name="location" value="<?php echo $data[0]->location; ?>">
                                        </div>

                                          <div class="form-group">
                                            <label>Gps(long/lat)</label>
                                            <table><tr>
                                            <td><input type="text" id="start_long" name="longitude" class="form-control" value="<?php echo $data[0]->longitude; ?>"/></td>
                                            <td> <input type="text" id="start_lat" name="lattitude" class="form-control" value="<?php echo $data[0]->latittude; ?>" /></td></tr></table>
                                          </div>
                                        
                                        <div class="form-group">
                                            
                                            <select id="type" name="type"  required>
                                                <option value="<?php echo $data[0]->type; ?>"><?php if($data[0]->type) { echo "Master"; }else{ echo "client"; }?></option>
                                                <option value="">-------------</option>
                                                <option value="0">Client</option>
                                                <option value="1">Master</option>
                                            </select>
                                        
                                        </div>
                                        
                                        <div class="form-group">
                                            
                                            <select id="service_type" name="service_type"  required>
                                                <option value="<?php echo $data[0]->service_type; ?>"><?php echo $service; ?></option>
                                                <option value="<?php echo $data[0]->service_type; ?>">-------------</option>
                                                <option value="1">Normal</option>
                                                <option value="0">Dark</option>
                                                <option value="2">FTTH</option>
                                            </select>
                                        
                                        </div>


                                        <div class="form-group">
                                            
                                            <select id="core_type" name="core_type"  required>
                                                <option value="<?php echo $data[0]->core_type; ?>"><?php echo $core; ?></option>
                                                <option value="<?php echo $data[0]->core_type; ?>">-------------</option>
                                                <option value="1">Single Core</option>
                                                <option value="0">Dual Core</option>
                                            </select>
                                        
                                        </div>
                                        
                                        <div class="form-group" id="pod_info" <?php if($data[0]->service_type == 2) { echo 'hidden'; }?>>
                                             
                                            <label>Pod Info</label>
                                            <table><tr>
                                            <input type="hidden" name="pod_id" value="<?php echo $data[0]->pod_id?>" /> 
                                            <td><input type="text"  name="device_location" class="form-control" value="<?php echo $data[0]->device_location; ?>"/></td>
                                            <td><input type="text"  name="device" class="form-control" value="<?php echo $data[0]->device_name; ?>" /></td>
                                            <td><input type="text"  name="port" class="form-control" value="<?php echo $data[0]->device_port; ?>" /></td></tr></table>
                                        </div>

                                        <div class="form-group" id="splitter_info" <?php if($data[0]->service_type != 2){ echo 'hidden'; }?> >
                                             
                                            <label>Splitter Info</label>
                                            <table>
                                             
                                                <td>
                                                    <select id="splitter_id">
                                                          <?php if($data[0]->service_type == 2) { ?>
                                                                  
                                                                  <option value="<?php echo $data[0]->splitter_info[0]->splitter_id; ?>"><?php echo $data[0]->splitter_info[0]->org_name; ?></option>

                                                          <?php }else{?>
                                                                
                                                                  <option>Select Splitter</option>
                                                          <?php } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select id="splitter_output_id" >
                                                          
                                                           <?php if($data[0]->service_type == 2) { ?>
                                                                  
                                                                  <option value="<?php echo $data[0]->splitter_info[0]->id; ?>"><?php echo $data[0]->splitter_info[0]->output_no; ?></option>

                                                          <?php }else{?>
                                                                
                                                                  <option>Select Splitter</option>
                                                          <?php } ?>
                                                          
                                                    </select>
                                                </td>
                                              </tr>
                                            </table>
                                          
                                        </div> 

                                         <div class="panel panel-default">
                                                <div class="panel-heading">Switch To Client</div>
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
                                                             <input id="client_conn_id" type="hidden" name="client_conn_id[]" value="<?php echo $data[0]->connection_info[0]->id; ?>" />
                                                             <input id="conn_id" type="hidden" name="conn_id[]" value="<?php echo $data[0]->connection_info[0]->connection_id; ?>"  />
                                                             <input id="keyword" type="text" name="start_address" value="<?php echo $data[0]->connection_info[0]->client_start_point_location; ?>" />
                                                              <div id="list">
                                                                  <ul id="start_enc" class="list-unstyle">

                                                                  </ul>
                                                              </div>
                                                          </td>
                                                          <td>
                                                          <select class="form-control dyn_start_enclosure" name="start_enclosure[]">
                                                            <option value="<?php echo $data[0]->connection_info[0]->start_point_id; ?>"><?php echo $data[0]->connection_info[0]->client_start_point; ?></option>
                                                              <option value=""></option>
                                                          </select>
                                                          </td>
                                                          <td>
                                                          <select class="form-control dyn_end_enclosure" name="end_enclosure[]">
                                                              <option value="<?php echo $data[0]->connection_info[0]->end_point_id; ?>"><?php echo $data[0]->connection_info[0]->client_end_point.":".$data[0]->connection_info[0]->client_end_point_location; ?></option>
                                                              <option value="<?php echo $data[0]->connection_info[0]->end_point_id; ?>">-----------</option>
                                                              <?php foreach($data[0]->connection_info[0]->end_enclosure_list as $row) { ?>
                                                                    <?php if($row->start_enclosure == $data[0]->connection_info[0]->start_point_id ) {?>
                                                                        
                                                                        <option value="<?php echo $row->end_enclosure; ?>/<?php echo $row->id; ?>"><?php echo $row->end_name.':'.$row->end_location; ?></option>
                                                              
                                                                    <?php } else{  ?>

                                                                        <option value="<?php echo $row->start_enclosure; ?>/<?php echo $row->id; ?>"><?php echo $row->start_name.':'.$row->start_location; ?></option>
                                                                    
                                                                    <?php } ?>
                                                              <?php } ?>
                                                          </select>
                                                          </td>
                                                          <td>
                                                          <select class="form-control core_color1" name="core_color1[]">
                                                              <option value="<?php echo $data[0]->connection_info[0]->connection1_core_id ;?>"><?php echo $data[0]->connection_info[0]->color1; ?></option>
                                                              <option value="<?php echo $data[0]->connection_info[0]->connection1_core_id ;?>">-------------</option>
                                                              <?php foreach($data[0]->connection_info[0]->avl_colors as $row) { ?> 
                                                                  
                                                                  <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                              
                                                              <?php } ?>
                                                          </select>
                                                          </td>
                                                          <td>
                                                          
                                                          <select class="form-control core_color2" name="core_color2[]">
                                                            <option value="<?php echo $data[0]->connection_info[0]->connection2_core_id ;?>"><?php echo $data[0]->connection_info[0]->color2; ?></option>
                                                            <option value="<?php echo $data[0]->connection_info[0]->connection2_core_id ;?>">---------</option>   
                                                                 <?php foreach($data[0]->connection_info[0]->avl_colors as $row) { ?> 
                                                                    
                                                                       <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>

                                                                 <?php } ?>   
                                                          

                                                          </select>
                                                          
                                                          </td>
                                                          <td><button id="add_more" class="btn btn-primary">Add More</button></td>
                                                   </tr>
                                              <?php for($i = 1; $i < count($data[0]->connection_info); $i++) { ?>
                                                  <tr class="dynamic">
                                                          <td>

                                                             <input type="hidden" name="client_conn_id[]" value="<?php echo $data[0]->connection_info[$i]->id; ?>" />
                                                             <input id="conn_id" type="hidden" name="conn_id[]" value="<?php echo $data[0]->connection_info[$i]->connection_id; ?>"/>
                                                            
                                                          </td>
                                                          <td>
                                                          <select class="form-control dyn_start_enclosure" name="start_enclosure[]">
                                                            <option value="<?php echo $data[0]->connection_info[$i]->start_point_id; ?>"><?php echo $data[0]->connection_info[$i]->client_start_point; ?></option>
                                                              <option value=""></option>
                                                          </select>
                                                          </td>
                                                          <td>
                                                          <select class="form-control dyn_end_enclosure" name="end_enclosure[]">
                                                             <option value="<?php echo $data[0]->connection_info[$i]->end_point_id; ?>"><?php echo $data[0]->connection_info[$i]->client_end_point.':'.$data[0]->connection_info[$i]->client_end_point_location; ?></option>
                                                             <option value="<?php echo $data[0]->connection_info[$i]->end_point_id; ?>">-----------</option>
                                                             <?php foreach($data[0]->connection_info[$i]->end_enclosure_list as $row) { ?>
                                                                    <?php if($row->start_enclosure == $data[0]->connection_info[$i]->start_point_id ) {?>
                                                                        
                                                                        <option value="<?php echo $row->end_enclosure; ?>/<?php echo $row->id; ?>"><?php echo $row->end_name.':'.$row->end_location; ?></option>
                                                              
                                                                    <?php } else{  ?>

                                                                        <option value="<?php echo $row->start_enclosure; ?>/<?php echo $row->id; ?>"><?php echo $row->start_name.':'.$row->start_location; ?></option>
                                                                    
                                                                    <?php } ?>
                                                              <?php } ?>
                                                          </select>
                                                          </td>
                                                          <td>

                                                          <select class="form-control core_color1" name="core_color1[]">
                                                            <option value="<?php echo $data[0]->connection_info[$i]->connection1_core_id ;?>"><?php echo $data[0]->connection_info[$i]->color1; ?></option>
                                                            <option value="<?php echo $data[0]->connection_info[$i]->connection1_core_id ;?>">-----------</option>
                                                             <?php foreach($data[0]->connection_info[$i]->avl_colors as $row) { ?> 
                                                                  
                                                                  <option value="<?php echo  $row->id; ?>"><?php echo $row->name; ?></option>
                                                              
                                                              <?php } ?>
                                                          </select>
                                                          </td>
                                                          <td>
                                                          
                                                          <select class="form-control core_color2" name="core_color2[]">
                                                            <option value="<?php echo $data[0]->connection_info[$i]->connection2_core_id ;?>"><?php echo $data[0]->connection_info[$i]->color2; ?></option>
                                                            <option value="<?php echo $data[0]->connection_info[$i]->connection2_core_id ;?>">---------</option>
                                                            <?php foreach($data[0]->connection_info[$i]->avl_colors as $row) { ?> 
                                                                  
                                                                  <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                                                              
                                                              <?php } ?>
                                                          </select>
                                                          
                                                          </td>
                                                          <td><button id="remove" class="btn btn-primary">Remove</button></td>
                                                   </tr>
                                              <?php  } ?>
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
                              $.get(base_url+'client/ajax_get_location/'+keyword,function(data){

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
                                   $.get(base_url+'client/ajax_get_enclosure/'+id, function(data){
                                        
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
                              $.get(base_url+'client/ajax_get_connected_enclosure/'+start,function(data){
                                             
                                      //alert(data);
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
                                $.get(base_url+'client/ajax_get_connction_core/'+conn_id,function(data){
                                          
                                          //alert(conn_id);
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
                              $('.dynamic:last').find('#client_conn_id').val('');
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

                         $('#core_type').change(function(){

                              var type = $(this).val();
                              if(type == 1){

                                $('.core_color2').hide();
                              }
                              else{

                                $('.core_color2').show();
                              }
                         });

                         
                         $('#service_type').change(function(){

                              var type = $(this).val();
                              if(type == 1){

                                $('#pod_info').show();
                                $('#splitter_info').hide()
                              }
                              else if(type == 0){

                                $('#pod_info').hide();
                                $('#splitter_info').hide();
                              }
                              else if(type == 2){
                                
                                $('#pod_info').hide();
                                $('#splitter_info').show();

                              }
                         });

                         $('#splitter_type').change(function(){

                                 var val = $('#splitter_type').val();
                                 if(val == 'L1'){
                                       
                                       var type = 1;
                                 }
                                 else{
                                        
                                       var type = 0; 
                                 }

                                 $.get(base_url+'splitter/ajax_get_splitter/'+ type,function(data){
                                        $('#splitter_id').html('');
                                        $('#splitter_id').html('<option>Select Splitter</option>');
                                        var json = $.parseJSON(data);
                                        for(var i =0; i < json.length; i++){
                                          
                                            $('#splitter_id').append('<option value='+ json[i].id +'>'+ json[i].name +'</option>')
                                        
                                        }
                                 });

                         });

                         $('#splitter_id').change(function(){

                                 var val = $('#splitter_id').val();
                                 $('#splitter_output_id').html('');
                                 $('#splitter_output_id').html('<option>Select Splitter</option>');
                                 $.get(base_url+'splitter/ajax_get_splitter_output/'+ val,function(data){
                                        
                                        var json = $.parseJSON(data);
                                        for(var i =0; i < json.length; i++){
                                          
                                            $('#splitter_output_id').append('<option value='+ json[i].id +'>'+ json[i].output_no +'</option>')
                                        
                                        }
                                 });

                                 $.get(base_url+'splitter/ajax_get_splitter_connection/'+val,function(data){
                                              
                                              //alert(data);
                                              var json = $.parseJSON(data);
                                              var count =  json.length;
                                              $('.dynamic:first').find('.dyn_start_enclosure').html('<option>Select</option><option value='+ json[count-1].end_enclosure_id +'>'+ json[count-1].end_enclosure +'</option>')
                                        
                                 });

                                 

                         });
                        
            });
           </script>