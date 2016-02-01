
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
                              <div class="col-lg-12">      
                                  
                 	
									<?php 
                                        if($data[0]->service_type=='1'){
                                                $service = 'Normal';
                                        }
                                        elseif($data[0]->service_type=='0'){
                                                $service = 'Dark';
                                        }
                                        elseif($data[0]->service_type=='2'){

                                                $service = "FTTH";
                                        }
                                        
                                        if($data[0]->core_type=='1'){
                                                
                                                $data[0]->core_type='Single';
                                        }
                                        elseif($data[0]->core_type=='0'){
                                                
                                                $data[0]->core_type='Double';
                                        }
                                        if($data[0]->device_location==''){
                                                
                                                $data[0]->device_location='N/A';
                                        }
                                        if($data[0]->device_name==''){
                                                
                                                $data[0]->device_name='N/A';
                                        }
                                        if($data[0]->device_port==''){
                                                
                                                $data[0]->device_port='N/A';
                                        }
                                    ?>                        
                                
                                <div class="panel panel-default">
                                	<div class="panel-heading">Master Information</div>
                                    <div class="panel-body">
                                    
                                    	<table class="table table-bordered" style="width:500px;">
                                        <tr>
                                        	<td>Name</td>
                                            <td><?php echo $data[0]->name; ?></td>
                                        </tr>
                                        <tr>
                                        	<td>Location</td>
                                             <td><?php echo ucfirst($data[0]->location); ?></td>
                                        </tr>
                                        <tr>
                                        	<td>Lattitude</td>
                                             <td><?php echo $data[0]->latittude; ?></td>
                                        </tr>
                                        <tr>
                                        	<td>Longitude</td>
                                             <td><?php echo $data[0]->longitude; ?></td>
                                        </tr>
                                        <tr>
                                        	 <td>Service Type</td>
                                              <td><?php echo $service; ?></td>
                                        </tr>
                                        <tr>
                                        	<td>Core Type</td>
                                              <td><?php echo $data[0]->core_type; ?></td>
                                        </tr>
                                        <tr>
                                        	<td>Device Location</td>
                                             <td><?php echo $data[0]->device_location; ?></td>
                                        </tr>
                                         <tr>
                                        	<td>Device Name</td>
                                           <td><?php echo $data[0]->device_name; ?></td>
                                        </tr>
                                         <tr>
                                        	<td>Device Port</td>
                                           <td><?php echo $data[0]->device_port; ?></td>
                                        </tr>
                                         <tr>
                                        	<td>Date</td>
                                          <td><?php echo date('d-m-Y',$data[0]->date); ?></td>
                                        </tr>                                       	
                                            	
                                        </table>
                                    </div>
                                </div><!--/ client information-->
                                <?php if($data[0]->service_type == 2){ ?>
                                    
                                    <div class="panel panel-default">
                                      <div class="panel-heading">Splitter Information</div>
                                        <div class="panel-body">
                                        
                                          <table class="table table-bordered" style="width:500px;">
                                            <tr>
                                              <td>Name</td>
                                                <td><?php echo $data[0]->splitter_info[0]->org_name; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Location</td>
                                                 <td><?php echo $data[0]->splitter_info[0]->org_location; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Lattitude</td>
                                                 <td><?php echo $data[0]->splitter_info[0]->org_latittude; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Longitude</td>
                                                 <td><?php echo $data[0]->splitter_info[0]->org_longitude; ?></td>
                                            </tr>
                                                                              
                                                  
                                            </table>
                                        </div>
                                    </div><!--/ client information-->
                                
                                <?php } ?>
                                
                        <div class="panel panel-default">
                            <div class="panel-heading">Master Connnection Information</div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                <tr>
                                    <th>Enclosure</th>
                                    <th>Location</th>
                                    <th>Lattitude</th>
                                    <th>Longitude</th>             
                                   
                                    
                                    <th>Length (meter)</th>
                                    <th>Color</th>
                                    <th>Core</th>
                                </tr>
                                
                    <?php 
                       
                        foreach($data[0]->connection_info as $key => $value):;
                    ?>
                                <tr>
								 <!--added -->
                                    <td><?php echo $value->client_start_point.'&nbsp;=>&nbsp;'.$value->client_end_point; ?></td>
                                    <td><?php echo $value->client_start_point_location.'&nbsp;=>&nbsp;'.$value->client_end_point_location; ?></td>
                                    <td><?php echo $value->client_start_point_lattitude.'&nbsp;=>&nbsp;'.$value->client_end_point_lattitude; ?></td>
                                    <td><?php echo $value->client_start_point_longitude.'&nbsp;=>&nbsp;'.$value->client_end_point_longitude; ?></td>
                                    <!-- added -->    
								   <td><?php echo $value->length; ?></td>
                                   <td><?php echo $value->color1.'<br>'.$value->color2; ?></td>
                                   <td><?php echo $value->connection_core; ?></td>
                                </tr>
                                <?php endforeach; ?>
                                </table>
                            </div>
                        </div><!--->
                        
                               
                                
                                
                                
                    
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



    
