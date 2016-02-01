
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
                                                $data[0]->service_type = 'Normal';
                                        }
                                        elseif($data[0]->service_type=='0'){
                                                $data[0]->service_type = 'Dark';
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
                                	<div class="panel-heading">Client Information</div>
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
                                              <td><?php echo $data[0]->service_type; ?></td>
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
                                    <td><?php echo $value->start_enclosure.'&nbsp;=>&nbsp;'.$value->end_enclosure; ?></td>
                                    <td><?php echo $value->start_location.'&nbsp;=>&nbsp;'.$value->end_location; ?></td>
                                    <td><?php echo $value->start_lattitude.'&nbsp;=>&nbsp;'.$value->end_lattitude; ?></td>
                                    <td><?php echo $value->start_longitude.'&nbsp;=>&nbsp;'.$value->end_longitude; ?></td>                  					<td><?php echo $value->length; ?></td>
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
                        var base_url = $('body').attr('data-url');

                        function initialize() {
                          var mapOptions = {
                            zoom: 15,
                            center: new google.maps.LatLng(<?php echo $data[0]->latittude; ?>,<?php echo $data[0]->longitude; ?>),
                            mapTypeId: google.maps.MapTypeId.SATELLITE
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

                                 var marker<?php echo $i; ?> = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $row->start_lattitude; ?>,<?php echo $row->start_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $row->start_enclosure; ?>",
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
                                                      '<p>'+"No of cores: <?php echo $data[0]->core_type; ?>"+'</p>'+
                                                      '<p>'+"color 1: <?php echo $row->color1; ?>"+'</p>'+
                                                      '<p>'+"color 2: <?php echo $row->color2; ?>"+'</p>'+
                                                      '</div>'+
                                                      '</div>';

                                   var infowindow<?php echo $i; ?> = new google.maps.InfoWindow({
                                      content: contentString<?php echo $i; ?>,
                                      maxWidth: 150,

                                      
                                  });


                                  google.maps.event.addListener(flightPath<?php echo $i; ?>, 'mouseover', function() {
                                        infowindow<?php echo $i; ?>.open(map,flightPath<?php echo $i; ?>);
                                       
                                  });
                                   google.maps.event.addListener(flightPath<?php echo $i; ?>, 'mouseout', function() {
                                        infowindow<?php echo $i; ?>.close(map,flightPath<?php echo $i; ?>);
                                       
                                  });

                          <?php $i++; } 
                         
                          ?>      
                         
                                  var image = base_url+'assets/admin/icons/client.png';
                                 

                                 

                                 var markerclient = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $row->end_lattitude; ?>,<?php echo $row->end_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $data[0]->name; ?>",
                                    icon: image
                                 });

                                
                          
                        } 

                        google.maps.event.addDomListener(window, 'load', initialize);

                </script>

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



    
