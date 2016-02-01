<style>
.table,.table-bordered { padding:5px; }
.table th { font-weight:400; background-color:#f5f5f5; text-shadow:0px 0px 0px  #000;padding:5px;}
.panel-default>.panel-heading {color:#09F;text-shadow:0px 0px 0px 1px #000;}
</style>
<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                        <form method="post" action="<?php echo base_url(); ?>fiberconnection/fiberbreak">
                        <div class="panel panel-default">
                        	<div class="panel-heading">Fiber from starting to joining point</div>
                        	<div class="panel-body">
                            	
                                	 <table style="margin-bottom:15px;">
                                     <tr class="fiber">  
                                       <td class="objective">
                                       <label>Objective</label>
                                       <input id="conn_id" type="text" name="objective[]" value="<?php echo $data[0]->objective; ?>" />
                                       </td>
                                       <td >
                                       <label>Fiber</label>
                                       <select>
                                              <option value="<?php echo $data[0]->fiber_id; ?>"><?php echo "Drum no:".$data[0]->drum_no."/Core:".$data[0]->core.'/'.$data[0]->brand_name; ?></option>
                                              <option value="">------------</option>
                                              <?php foreach($fiber as $row) { ?>
                                              <option value="<?php echo $row->id; ?>"><?php echo "Drum no:".$row->drum_no."/ Core :".$row->no_of_cores.'/'.$row->brand_name;; ?></option>
                                              <?php } ?>
                                        </select>
                                       </td>
                                       <td><button type="button"  class="btn btn-primary col-sm-offset-4 addmore" style="padding:2px;">Add More</button></td>
                                
                               
                                
                                    
                              </table> 
                              <div class="clone_fiber">
                              
                              </div> 
                             <table width="100%" class="table switch">
                                            <tr>
                                                <th> S.N </th>
                                                <th>Address</th>
                                                <th>Enclosure</th>
                                                <th>Num.</th>
                                                <th>Long/Latt</th>
                                                <th></th>
                                            </tr>
                                            <tbody id="cont">
                                                  
                                                     
                                                      <tr class="dynamic">
                                                              <input id="conn_id" type="hidden" name="conn_id[]" value="<?php echo $data[0]->id; ?>" />
                                                              <td>
                                                                  <h6>Starting Point</h6>
                                                              </td>
                                                             
                                                              
                                                              <td>
                                                                 
                                                                  <input style="width : 100px;" type="text" name="location[]" value="<?php echo $data[0]->start_location; ?>"  />
                                                                  <div id="list">
                                                                      <ul id="start_enc" class="list-unstyle">

                                                                      </ul>
                                                                  </div>
                                                              </td>
                                                              
                                                              <td>
                                                                   <input style="width : 100px;" type="text" name="enclosure[]" value="<?php echo $data[0]->start_name; ?>" /> 
                                                              </td>
                                                              
                                                              <td>
                                                                   <input style="width : 100px;"  type="text" name="point[]" value="<?php echo $data[0]->start_point; ?>"/> 
                                                              </td>
                                                              <td>
                                                                   <input style="width : 100px;"  type="text" name="longitude[]" value="<?php echo $data[0]->start_longitude; ?>" /> 
                                                                  
                                                              </td>
                                                             <td> <input style="width : 100px;"  type="text" name="latitude[]" value="<?php echo $data[0]->start_lattitude; ?>" /> </td>
                                                              
                                                       </tr>
                                                      
                                                        <tr >
                                                              
                                                              <td>
                                                                  <h6>Joining Point</h6>
                                                              </td>
                                                            
                                                              
                                                              <td>
                                                                 
                                                                  <input id="join_location1" style="width : 100px;"  type="text" name="location[]" required="required" />
                                                                  <div id="list">
                                                                      <ul id="start_enc" class="list-unstyle">

                                                                      </ul>
                                                                  </div>
                                                              </td>
                                                              
                                                              <td>
                                                                   <input id="join_enclosure1" style="width : 100px;"  type="text" name="enclosure[]"  required="required"/> 
                                                              </td>

                                                              <td>
                                                                   <input id="join_point1" style="width : 100px;"  type="text" name="point[]" /> 
                                                              </td>

                                                              <td>
                                                                    <input id="join_longitude1" style="width : 100px;"  type="text" name="longitude[]" /> 
                                                                   
                                                              </td>
                                                              <td><input id="join_latittude1" style="width : 100px;"  type="text" name="latitude[]" /> </td>
                                                              
                                                             
                                                              
                                                       </tr>
                                                        
                                                      </tbody>
                                                      </table>
                                
                                
                            </div>
                        </div>
                        
                        
                        
                      <div class="panel panel-default">
                      	<div class="panel-heading">Fiber From joining to ending point</div>
                        <div class="panel-body">
                        	
                        	<table>                                    
                                    <tr class="fiber2">
                                        <td class="objective2">
                                           <label>Objective</label>
                                           <input id="conn_id" type="text" name="objective[]" value="<?php echo $data[0]->objective; ?>" />
                                        </td>
                                         
                                                                          
                                       <td>
                                        <label>Fiber</label>
                                         <select  name="fiber_id[]">
                                              <option value="<?php echo $data[0]->fiber_id; ?>"><?php echo "Drum no:".$data[0]->drum_no."/Core:".$data[0]->core.'/'.$data[0]->brand_name; ?></option>
                                              <option value="">------------</option>
                                              <?php foreach($fiber as $row) { ?>
                                              <option value="<?php echo $row->id; ?>"><?php echo "Drum no:".$row->drum_no."/ Core :".$row->no_of_cores.'/'.$row->brand_name;; ?></option>
                                              <?php } ?>
                                        </select>
                                       
                                       </td>
                                       <td>
                                       <button type="button"  class="btn btn-primary col-sm-offset-4 addmore2" style="padding:2px;">Add More</button>
                                       </td>
                                    </tr>
                                   
                              </table>
                              <div class="clone_fiber2">
                              </div>  
                             <table width="100%" class="table switch">
                                            <tr>
                                                <th> S.N </th>
                                                <th>Address</th>
                                                <th>Enclosure</th>
                                                <th>Num.</th>
                                                <th>Long/Latt</th>
                                                <th></th>
                                            </tr>
                                            <tbody id="cont">                                     
                                                     
                                                   
                                                      
                                                        <tr>
                                                              
                                                              <td>
                                                                  <h6>Joining Point</h6>
                                                              </td>
                                                             
                                                              
                                                              <td>
                                                                 
                                                                  <input id="join_location2" style="width : 100px;"  type="text" name="location[]" required="required" />
                                                                  <div id="list">
                                                                      <ul id="start_enc" class="list-unstyle">

                                                                      </ul>
                                                                  </div>
                                                              </td>
                                                              
                                                              <td>
                                                                   <input id="join_enclosure2" style="width : 100px;"  type="text" name="enclosure[]"  required="required" /> 
                                                              </td>

                                                              <td>
                                                                   <input id="join_point2" style="width : 100px;"  type="text" name="point[]" /> 
                                                              </td>

                                                              <td>
                                                                    <input id="join_longitude2" style="width : 100px;"  type="text" name="longitude[]" /> 
                                                                   
                                                              </td>
                                                              
                                                           <td><input id="join_latittude2" style="width : 100px;"  type="text" name="latitude[]" /> </td>   
                                                             
                                                              
                                                       </tr>
                                                        
                                                       <tr class="dynamic">
                                                              
                                                              <td>
                                                                   <h6>Ending Point</h6>
                                                              </td>
                                                             
                                                              <td>
                                                                 
                                                                  <input style="width : 100px;" type="text" name="location[]" value="<?php echo $data[0]->end_location; ?>"  />
                                                                  <div id="list">
                                                                      <ul id="start_enc" class="list-unstyle">

                                                                      </ul>
                                                                  </div>
                                                              </td>
                                                              
                                                              <td>
                                                                   <input style="width : 100px;" type="text" name="enclosure[]" value="<?php echo $data[0]->end_name; ?>" /> 
                                                              </td>
                                                              
                                                              <td>
                                                                   <input style="width : 100px;"  type="text" name="point[]" value="<?php echo $data[0]->end_point; ?>"/> 
                                                              </td>
                                                              <td>
                                                                   <input style="width : 100px;"  type="text" name="longitude[]" value="<?php echo $data[0]->end_longitude; ?>" /> 
                                                                  
                                                              </td>
                                                              <td> <input style="width : 100px;"  type="text" name="latitude[]" value="<?php echo $data[0]->end_lattitude; ?>" /> </td>
                                                              
                                                             
                                                              
                                                       </tr>
                                                   <tr>
                                                       
                                                   </tr>
                                                   
                                           </tbody>
                                                        
                                            </table>  
                        </div>
                      </div>  
                        
                        
                        <input class="forn-control btn-primary" type="submit" name="submit" value="Submit" />                   
                            <!-- /.row (nested) -->
                        
                        <!-- /.panel-body -->
                        </form>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
</div>
            <!-- /.row -->
            
<script type="application/javascript">
	$('#join_location1').keyup( function(){
		$('#join_location2').val($('#join_location1').val());
	});
	$('#join_location2').keyup( function() {
		$('#join_location1').val($('#join_location2').val());
	});
	
	$('#join_enclosure1').keyup( function(){
		$('#join_enclosure2').val($('#join_enclosure1').val());
	});
	$('#join_enclosure2').keyup( function() {
		$('#join_enclosure1').val($('#join_enclosure2').val());
	});
	
	
	//clone fiber connection//from start to join
	
	$('.addmore').click( function(){				
		$('.fiber').clone().appendTo('.clone_fiber');
		$('.clone_fiber').find('.objective').remove();
		$('.clone_fiber').find('.fiber').removeClass().addClass('new');
		$('.clone_fiber').find('button').replaceWith('<button style="padding:2px;" class="btn btn-primary col-sm-offset-4 remove"  type="button">Remove</button>');		
		
		
	});
	
	$(document).on('click','.remove', function(){
		//alert('ok');
		$(this).closest('.new').remove();
	});
	
	//clone from join to end
	$('.addmore2').click( function(){				
		$('.fiber2').clone().appendTo('.clone_fiber2');
		$('.clone_fiber2').find('.objective2').remove();
		$('.clone_fiber2').find('.fiber2').removeClass().addClass('new2');
		$('.clone_fiber2').find('button').replaceWith('<button style="padding:2px;" class="btn btn-primary col-sm-offset-4 remove2"  type="button">Remove</button>');		
		
		
	});
	
	
	$(document).on('click','.remove2', function(){
		//alert('ok');
		$(this).closest('.new2').remove();
	});
</script>

    
