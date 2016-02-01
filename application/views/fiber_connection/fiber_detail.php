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
                            <div class="row">                                
                              <div class="col-lg-10">      
                                 <?php //echo '<pre>'; print_r($data); ?>  
                 
                                 <div class="well">
                                     <div class="col-md-12">
                                         <div class="col-md-8">
                                             <b>Objective &nbsp;:&nbsp;</b> 
                                             <code><?php echo $data[0]->objective; ?></code>
                                         </div>
                                         <div class="col-md-2">
                                         	 <p><a href="<?php echo base_url(); ?>fiberconnection/fiberbreak/<?php echo $data[0]->id; ?>" class="btn btn-primary">Break</a></p>
                                         </div>
                                         <div class="col-md-2">
                                           <p><a href="<?php echo base_url(); ?>fiberconnection/disable/<?php echo $data[0]->id; ?>" class="btn btn-warning">Disable</a></p>
                                         </div>
                                     </div>
                                 </div> 
                                
                                
                                <div class="panel panel-default">
                                	<div class="panel-heading">Fiber Information</div>
                                    <div class="panel-body">
                                    	<table class="table table-bordered">
                                        	<tr>
                                            	<th>Drum Number</th>
                                                <th>Brand Name</th>
                                                <th>Number of Cores</th>
                                                <th>Connection Date</th>
                                                <th>Length</th>
                                            </tr>
                                           
                                            <tr>

                                            	<td><?php echo $data[0]->drum_no; ?></td>
                                                <td><?php echo ucfirst($data[0]->brand_name); ?></td>
                                                <td><?php echo $data[0]->core; ?></td>
                                                <td><?php echo date('m-d-Y',$data[0]->date); ?></td>
                                                
                                                <td><?php echo $data[0]->length; ?></td>
                                            </tr>

                                           
                                        </table>
                                    </div>
                                </div><!--/ fiber information-->
                                
                                <div class="panel panel-default">
                                	<div class="panel-heading">Fiber Start Position</div>
                                    <div class="panel-body">
                                    	<table class="table table-bordered">
                                        <tr>
                                        	<th>Start Enclosure</th>
                                            <th>Start Point</th>
                                            <!--<th>Start Enclosure</th>-->
                                            <th>Start Location</th>
                                            <th>Start Lattitude</th>
                                            <th>Start Longitude</th>
                                        </tr>
                                        <tr>
                                        	<td><?php echo $data[0]->start_name; ?></td>
                                            <td><?php echo $data[0]->start_point; ?></td>
                                            <!--<td><?php echo $data[0]->start_enclosure; ?></td>-->
                                            <td><?php echo $data[0]->start_location; ?></td>
                                            <td><?php echo $data[0]->start_lattitude; ?></td>
                                            <td><?php echo $data[0]->start_longitude; ?></td>
                                        </tr>
                                        </table>
                                    </div>
                                </div><!--start posiotion-->
                                
                                <div class="panel panel-default">
                                	<div class="panel-heading">Fiber End Position</div>
                                    <div class="panel-body">
                                    	<table class="table table-bordered">
                                        <tr>
                                        	<th>End Enclosure</th>
                                            <th>End Point</th>
                                            <!--<th>End Enclosure</th>-->
                                            <th>End Location</th>
                                            <th>End Lattitude</th>
                                            <th>End Longitude</th>
                                        </tr>
                                        <tr>
                                        	<td><?php echo $data[0]->end_name; ?></td>
                                            <td><?php echo $data[0]->end_point; ?></td>
                                           <!-- <td><?php echo $data[0]->end_enclosure; ?></td>-->
                                            <td><?php echo $data[0]->end_location; ?></td>
                                            <td><?php echo $data[0]->end_lattitude; ?></td>
                                            <td><?php echo $data[0]->end_longitude; ?></td>
                                        </tr>
                                        </table>
                                    </div>
                                </div><!--end position-->
                                
                                <div class="panel panel-default">
                                	<div class="panel-heading">Core Information</div>
                                    <div class="panel-body">
                                    	
                                       <!-- <p class="bg-default">Number of Core : <?php echo $data[0]->core; ?></p>-->
                                        
                                          
                                       <table class="table table-bordered">
                                       <tr>
                                       		<th>Color</th>
                                            <th>Status</th>
                                       </tr>
                                        <?php foreach($data[0]->core_info as $info): 
                      												
                                              if(!empty($info->clientinfo)){
                                                    
                                                    //$conn.= $childrow->name." : ".$childrow->clientinfo[0]->client_name[0]->name." || ";
                                                    $vjc = $info->clientinfo[0]->client_name[0]->name;
                                              }
                                              elseif(!empty($info->podinfo)){

                                                    
                                                    //$conn.= $childrow->name." : ".$childrow->podinfo[0]->pod_name[0]->to_device_name." || ";
                                                    $vjc = $info->podinfo[0]->pod_name[0]->from_device_name." => ".$info->podinfo[0]->pod_name[0]->to_device_name;
                                              }
                                              elseif(!empty($info->splitterinfo)){
                                                    
                                                    //$conn.= $childrow->name." : ".$childrow->splitterinfo[0]->splitter_name[0]->name." || ";
                                                    $vjc = $info->splitterinfo[0]->splitter_name[0]->name;
                                              }
                                              //ad this code manoj
                                              elseif(!empty($info->masterinfo)){
                                                    
                                                    //$conn.= $childrow->name." : ".$childrow->masterinfo[0]->master_name[0]->name." || ";
                                                    $vjc = $info->masterinfo[0]->master_name[0]->name;
                                              }
                                              //till here
                                              else{

                                                    //$conn.= $childrow->name." : N/A || ";
                                                    $vjc = 'N/A';
                                              }
										?>
                                        <tr>                                        
                                        	
                                            <td><?php echo $info->name; ?></td>
                                            <td><?php echo $vjc; ?></td>
                                            
                                       </tr>
                                        <?php endforeach; ?>
                                      </table>
                                    </div>
                                </div>
                                
                                
                                <!-- /.col-lg-6 (nested) -->
                              </div><!--col-lg-10-->
                             
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
            


    
