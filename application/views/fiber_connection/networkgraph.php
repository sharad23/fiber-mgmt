
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
                            center: new google.maps.LatLng(27.7000000,85.3333330),
                            mapTypeId: google.maps.MapTypeId.TERRAIN
                          };

                          var map = new google.maps.Map(document.getElementById('map-canvas'),
                              mapOptions);

                          var lineSymbol = {
                              path: 'M 0,-1 0,1',
                              strokeOpacity: 1,
                              scale: 4
                            };

                          var enclosure = base_url+'assets/admin/icons/enclosure.png'; 
                          <?php $i=1;
                                
                                foreach($data as $row) { ?>
                                  
                                
                                  var flightPlanCoordinates<?php echo $i ;?> =[
                                            
                                              new google.maps.LatLng(<?php echo $row->start_lattitude; ?>,<?php echo $row->start_longitude; ?>),
                                              new google.maps.LatLng(<?php echo $row->end_lattitude; ?>,<?php echo $row->end_longitude; ?>),

                                  ]; 

                                 var flightPath<?php echo $i; ?> = new google.maps.Polyline({
                                    path: flightPlanCoordinates<?php echo $i;?>,
                                    icons: [{
                                              icon: lineSymbol,
                                              offset: '0',
                                              repeat: '5px'
                                           }],
                                   strokeOpacity: 0,
                                    
                                    
                                  });

                                 var markerstart<?php echo $i; ?> = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $row->start_lattitude; ?>,<?php echo $row->start_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $row->start_name; ?>",
                                    icon: enclosure
                                
                                 });
                                  var markerend<?php echo $i; ?> = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $row->end_lattitude; ?>,<?php echo $row->end_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $row->end_name; ?>",
                                    icon: enclosure
                                
                                 });
                           
                                  flightPath<?php echo $i; ?>.setMap(map);
                                  
                                   <?php $conn =''; 
                                       

                                        foreach($row->core_info as $childrow) { 
                                             
                                              if(!empty($childrow->clientinfo)){
                                                    
                                                    $conn.= $childrow->name." : ".$childrow->clientinfo[0]->client_name[0]->name." || ";
                                              }
                                              elseif(!empty($childrow->podinfo)){

                                                    
                                                    $conn.= $childrow->name." : ".$childrow->podinfo[0]->pod_name[0]->to_device_name." || ";
                                                   
                                              }
                                              elseif(!empty($childrow->splitterinfo)){
                                                    
                                                    $conn.= $childrow->name." : ".$childrow->splitterinfo[0]->splitter_name[0]->name." || ";
                                              }
                                              //ad this code manoj
                                              elseif(!empty($childrow->masterinfo)){
                                                    
                                                    $conn.= $childrow->name." : ".$childrow->masterinfo[0]->master_name[0]->name." || ";
                                              }
                                              //till here
                                              else{

                                                   $conn.= $childrow->name." : N/A || ";
                                              }


                                        }
                                                                          
                                   ?>
                                   var contentString<?php echo $i; ?> = '<div style="float: right" id="content">'+
                                                      '<div id="siteNotice">'+
                                                      '</div>'+
                                                      '<h4 id="firstHeading" class="firstHeading">'+"Connection Info"+'</h4>'+
                                                      '<hr>'+
                                                      '<div id="bodyContent">'+
                                                      '<p>'+"Start Location : <?php echo $row->start_location; ?> || End Location : <?php echo $row->end_location; ?> || Length: <?php echo $row->length; ?> || No of Cores: <?php echo $row->core; ?>"+'</p>'+
                                                       '<p>'+"Cores: <?php echo $conn; ?>"+'</p>'+
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



    
