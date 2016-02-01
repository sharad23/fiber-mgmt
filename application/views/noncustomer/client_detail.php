
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
                                        /*if($data[0]->service_type=='1'){
                                                $data[0]->service_type = 'Normal';
                                        }
                                        elseif($data[0]->service_type=='0'){
                                                $data[0]->service_type = 'Dark';
                                        }*/
                                        
                                        if($data[0]->core_type=='1'){
                                                
                                                $data[0]->core_type='Single';
                                        }
                                        elseif($data[0]->core_type=='0'){
                                                
                                                $data[0]->core_type='Double';
                                        }
                                        if($data[0]->from_device_location==''){
                                                
                                                $data[0]->from_device_location='N/A';
                                        }
                                        if($data[0]->from_device_name==''){
                                                
                                                $data[0]->from_device_name='N/A';
                                        }
                                        if($data[0]->from_device_port==''){
                                                
                                                $data[0]->from_device_port='N/A';
                                        }
                                         if($data[0]->to_device_location==''){
                                                
                                                $data[0]->to_device_location='N/A';
                                        }
                                        if($data[0]->to_device_name==''){
                                                
                                                $data[0]->to_device_name='N/A';
                                        }
                                        if($data[0]->to_device_port==''){
                                                
                                                $data[0]->to_device_port='N/A';
                                        }
                                    ?>                        
                                
                                <div class="panel panel-default">
                                	<div class="panel-heading">From Pod</div>
                                    <div class="panel-body">
                                    
                                    	<table class="table table-bordered" style="width:500px;">
                                       
                                        <tr>
                                        	<td>Device Location</td>
                                             <td><?php echo $data[0]->from_device_location; ?></td>
                                        </tr>
                                         <tr>
                                        	<td>Device Name</td>
                                           <td><?php echo $data[0]->from_device_name; ?></td>
                                        </tr>
                                         <tr>
                                        	<td>Device Port</td>
                                           <td><?php echo $data[0]->from_device_port; ?></td>
                                        </tr>
                                                                             	
                                            	
                                        </table>
                                    </div>
                                </div><!--/ client information-->

                                 <div class="panel panel-default">
                                    <div class="panel-heading">To Pod</div>
                                    <div class="panel-body">
                                    
                                        <table class="table table-bordered" style="width:500px;">
                                       
                                        <tr>
                                            <td>Device Location</td>
                                             <td><?php echo $data[0]->to_device_location; ?></td>
                                        </tr>
                                         <tr>
                                            <td>Device Name</td>
                                           <td><?php echo $data[0]->to_device_name; ?></td>
                                        </tr>
                                         <tr>
                                            <td>Device Port</td>
                                           <td><?php echo $data[0]->to_device_port; ?></td>
                                        </tr>
                                                                                
                                                
                                        </table>
                                    </div>
                                </div><!--/ client information-->
                                
                        <div class="panel panel-default">
                            <div class="panel-heading">Client Connnection Information</div>
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
                 <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
                <script>
            // This example creates a 2-pixel-wide red polyline showing
            // the path of William Kingsford Smith's first trans-Pacific flight between
            // Oakland, CA, and Brisbane, Australia.

                       
            // This example creates a 2-pixel-wide red polyline showing
            // the path of William Kingsford Smith's first trans-Pacific flight between
            // Oakland, CA, and Brisbane, Australia.
                        var base_url = $('body').attr('data-url');

                        function initialize() {
                          var mapOptions = {
                            zoom: 20,
                            center: new google.maps.LatLng(<?php echo $data[0]->connection_info[0]->start_lattitude; ?>,<?php echo $data[0]->connection_info[0]->start_longitude; ?>),
                            mapTypeId: google.maps.MapTypeId.TERRAIN
                          };

                          var map = new google.maps.Map(document.getElementById('map-canvas'),
                              mapOptions);

                          

                          var enclosure = base_url+'assets/admin/icons/enclosure.png'; 
                          <?php $i=1;
                                
                                foreach($data[0]->connection_info as $row) { ?>
                                  
                                
                                  var flightPlanCoordinates<?php echo $i ;?> =[
                                            
                                              new google.maps.LatLng(<?php echo $row->start_lattitude; ?>,<?php echo $row->start_longitude; ?>),
                                              new google.maps.LatLng(<?php echo $row->end_lattitude; ?>,<?php echo $row->end_longitude; ?>),

                                  ]; 

                                 var flightPath<?php echo $i; ?> = new google.maps.Polyline({
                                    path: flightPlanCoordinates<?php echo $i;?>,
                                    geodesic: true,
                                    strokeColor: "<?php echo $row->color1_code; ?>",
                                    strokeOpacity: 0.8,
                                    strokeWeight: 5
                                   
                                 });

                                 var markerstart<?php echo $i; ?> = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $row->start_lattitude; ?>,<?php echo $row->start_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $row->start_enclosure; ?>",
                                    icon: enclosure
                                
                                 });
                                  var markerend<?php echo $i; ?> = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $row->end_lattitude; ?>,<?php echo $row->end_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $row->end_enclosure; ?>",
                                    icon: enclosure
                                
                                 });
                           
                                  flightPath<?php echo $i; ?>.setMap(map);
                                  
                                  
                                   var contentString<?php echo $i; ?> = '<div style="float: right" id="content">'+
                                                      '<div id="siteNotice">'+
                                                      '</div>'+
                                                      '<h4 id="firstHeading" class="firstHeading">'+"Connection Info"+'</h4>'+
                                                      '<hr>'+
                                                      '<div id="bodyContent">'+
                                                      '<p>'+"Start Location : <?php echo $row->start_location; ?>"+'</p>'+
                                                      '<p>'+"End Location : <?php echo $row->end_location; ?>"+'</p>'+
                                                      '<p>'+"Length: <?php echo $row->length; ?>"+'</p>'+
                                                      '<p>'+"color: <?php echo $row->color1; ?>"+'</p>'+
                                                      '</div>'+
                                                      '</div>';

                                   var infowindow<?php echo $i; ?> = new google.maps.InfoWindow({
                                      content: contentString<?php echo $i; ?>,
                                      maxWidth:800

                                      
                                  });


                                  google.maps.event.addListener(flightPath<?php echo $i; ?>, 'mouseover', function() {
                                        infowindow<?php echo $i; ?>.open(map,markerstart<?php echo $i; ?>,flightPath<?php echo $i; ?> );
                                       
                                  });
                                   google.maps.event.addListener(flightPath<?php echo $i; ?>, 'mouseout', function() {
                                        infowindow<?php echo $i; ?>.close(map,markerstart<?php echo $i; ?>,flightPath<?php echo $i; ?>);
                                       
                                  });
                                   


                                 

                          <?php $i++; } 
                         
                          ?>   

                            //for the source 
                             var markersource = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $data[0]->connection_info[0]->start_lattitude; ?>,<?php echo $data[0]->connection_info[0]->start_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $data[0]->from_device_name; ?>",
                                    icon:  "<?php echo base_url().'assets/admin/icons/switch.png'; ?>"
                                
                                 });
                             
                              var markerdest = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $row->end_lattitude; ?>,<?php echo $row->end_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $data[0]->to_device_name; ?>",
                                    icon: "<?php echo base_url().'assets/admin/icons/switch.png'; ?>"
                                
                                 });
                         

                                
                          
                        } 

                        google.maps.event.addDomListener(window, 'load', initialize);

               
                </script>
                  <div class="row">
                    <ul class="list-inline" style="margin-left:5px;">
                     
                      <li ><img src="<?php echo base_url(); ?>assets/admin/icons/client.png" class="img-responsive"><br> Client</li>
                      <li ><img src="<?php echo base_url(); ?>assets/admin/icons/enclosure.png" class="img-responsive"><br>Enclosure</li>
                      <li ><img src="<?php echo base_url(); ?>assets/admin/icons/l1splitter.png" class="img-responsive"><br>L1-Splitter</li>
                      <li ><img src="<?php echo base_url(); ?>assets/admin/icons/splitter.png" class="img-responsive"><br>L2-Splitter</li>
                      <li ><img src="<?php echo base_url(); ?>assets/admin/icons/olt.png" class="img-responsive"><br>OLT</li>
                      <li ><img src="<?php echo base_url(); ?>assets/admin/icons/switch.png" class="img-responsive"><br>  Switch </li>
                    </ul>
                  </div>

                 <div class="row">
                     
                     <div id="map-canvas" style="height:500px; width:950px; margin:10px; "></div>
                 
                 </div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->



    
