

<style>
          

          .table,.table-bordered { padding:5px; }
          .table th { font-weight:400; background-color:#f5f5f5; text-shadow:0px 0px 0px  #000;padding:5px;}
          .panel-default>.panel-heading {color:#09F;text-shadow:0px 0px 0px 1px #000;}


</style>
<div class="row">

<?php //echo '<pre>'; print_r($data[0]->outputs); echo '</pre>';?>


                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo ucwords($title); ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">                                
                              <div class="col-lg-12">      
                                  
                 	
									                  <?php 
                                        if($data[0]->type=='1'){
                                                $data[0]->type = 'L1';
                                        }
                                        elseif($data[0]->type=='0'){
                                                $data[0]->type = 'L2';
                                        }
                                        
                                    ?>                        
                               
                                <div class="panel panel-default">
                                	<div class="panel-heading">Splitter Information</div>
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
                                              <td><?php echo $data[0]->type; ?></td>
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
                                <?php if(isset($data[0]->parent_splitter)) { ?>
                                
                                    <div class="panel panel-default">
                                      <div class="panel-heading">Parent Splitter Information</div>
                                        <div class="panel-body">
                                          
                                          <table class="table table-bordered" style="width:500px;">
                                            <tr>
                                              <td>Name</td>
                                                <td><?php echo $data[0]->parent_splitter[0]->org_name; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Location</td>
                                                 <td><?php echo $data[0]->parent_splitter[0]->org_location;  ?></td>
                                            </tr>
                                            <tr>
                                              <td>Lattitude</td>
                                                 <td><?php echo $data[0]->parent_splitter[0]->org_latittude; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Longitude</td>
                                                 <td><?php echo $data[0]->parent_splitter[0]->org_longitude; ?></td>
                                            </tr>
                                            <tr>
                                              <td>Device Name</td>
                                               <td><?php echo $data[0]->parent_splitter[0]->olt_name; ?></td>
                                            </tr>
                                             <tr>
                                              <td>Device Port</td>
                                               <td><?php echo $data[0]->parent_splitter[0]->olt_port; ?></td>
                                            </tr>
                                                                                 
                                                  
                                            </table>
                                        </div>
                                    </div><!--/ client information-->
                                
                                
                        

                        <div class="panel panel-default">
                            <div class="panel-heading">From L1 splitter to L2 splitter</div>
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
                       
                        foreach($data[0]->connection_info as $key => $value){
                    ?>
                                <tr>
                                    <td><?php echo $value->start_enclosure.'&nbsp;=>&nbsp;'.$value->end_enclosure; ?></td>
                                    <td><?php echo $value->start_location.'&nbsp;=>&nbsp;'.$value->end_location; ?></td>
                                    <td><?php echo $value->start_lattitude.'&nbsp;=>&nbsp;'.$value->end_lattitude; ?></td>
                                    <td><?php echo $value->start_longitude.'&nbsp;=>&nbsp;'.$value->end_longitude; ?></td>
                                    <td><?php echo $value->length; ?></td>
                                    <td><?php echo $value->color; ?></td>
                                    <td><?php echo $value->connection_core; ?></td>
                                </tr>
                                <?php } ?>
                                </table>
                            </div>
                        </div>
                        
                       
                     <?php } else {?>

                         <div class="panel panel-default">
                            <div class="panel-heading">From Olt to L1 splitter</div>
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
                       
                        foreach($data[0]->connection_info as $key => $value){
                    ?>
                                <tr>
                                     <td><?php echo $value->client_start_point.'&nbsp;=>&nbsp;'.$value->client_end_point; ?></td>
                                    <td><?php echo $value->client_start_point_location.'&nbsp;=>&nbsp;'.$value->client_end_point_location; ?></td>
                                    <td><?php echo $value->client_start_point_lattitude.'&nbsp;=>&nbsp;'.$value->client_end_point_lattitude; ?></td>
                                    <td><?php echo $value->client_start_point_longitude.'&nbsp;=>&nbsp;'.$value->client_end_point_longitude; ?></td>          
                                    <td><?php echo $value->length; ?></td>
                                    <td><?php echo $value->color; ?></td>
                                    <td><?php echo $value->connection_core; ?></td>
                                </tr>
                                <?php } ?>
                                </table>
                            </div>
                        </div>


                     <?php } ?>

                     
                     <div class="panel panel-default">
                            <div class="panel-heading">Outputs</div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                <tr>
                                    <th>Output No.</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                                
                                    <th>Longitude</th>
                                    <th>Latitude</th>
                                    
                                </tr>
                                
                                <?php foreach($data[0]->outputs as $row) { ?>
                                   
                                    <tr>
                                        <td><?php echo $row->output_no; ?></td>
                                        <td><?php if($row->output_client_id != 0){  echo "Client"; }elseif($row->output_splitter_id != 0){ echo "Splitter"; }else{ echo 'N/A'; } ?></td>
                                        <td><?php if($row->output_client_id != 0){  echo $row->output_client_name; }elseif($row->output_splitter_id != 0){ echo $row->output_splitter_name; }else{ echo 'N/A';} ?></td>
                                        <td><?php if($row->output_client_id != 0){  echo $row->output_client_longitude; }elseif($row->output_splitter_id != 0){ echo $row->output_splitter_longitude; }else{ echo 'N/A';} ?></td>
                                        <td><?php if($row->output_client_id != 0){  echo $row->output_client_latittude; }elseif($row->output_splitter_id != 0){ echo $row->output_splitter_latittude; }else{ echo 'N/A';} ?></td>
                                        
                                    </tr>
                                <?php } ?>
                                </table>
                            </div>
                        </div>


                  
      
                                
                    
                    <!-- /.col-lg-6 (nested) -->
                  </div><!--col-lg-10-->
                 
                </div>
                <!-- /.row (nested) -->
                <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
                <script type="text/javascript">

                        var base_url = $('body').attr('data-url');

                        function initialize() {
                          var mapOptions = {
                            zoom: 20,
                            center: new google.maps.LatLng(<?php echo $data[0]->latittude; ?>,<?php echo $data[0]->longitude; ?>),
                            mapTypeId: google.maps.MapTypeId.TERRAIN
                          };

                          var map = new google.maps.Map(document.getElementById('map-canvas'),
                              mapOptions);

                          var olt = base_url+'assets/admin/icons/olt.png';
                          var image = base_url+'assets/admin/icons/l1splitter.png';
                          var spilitter = base_url+'assets/admin/icons/splitter.png';
                          


                          <?php $i=1;
                                foreach($data[0]->connection_info as $row) { ?>
                                  
                                
                                  var flightPlanCoordinates<?php echo $i ;?> =[
                                            
                                              new google.maps.LatLng(<?php echo $row->start_lattitude; ?>,<?php echo $row->start_longitude; ?>),
                                              new google.maps.LatLng(<?php echo $row->end_lattitude; ?>,<?php echo $row->end_longitude; ?>),

                                  ]; 

                                 var flightPath<?php echo $i; ?> = new google.maps.Polyline({
                                      
                                      path: flightPlanCoordinates<?php echo $i;?>,
                                      geodesic: true,
                                      strokeColor: "<?php echo $row->color_code; ?>",
                                      strokeOpacity: 0.8,
                                      strokeWeight: 5
                                  
                                  });

                                 var marker<?php echo $i; ?> = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $row->start_lattitude; ?>,<?php echo $row->start_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $row->start_enclosure; ?>",
                                    icon : "<?php echo base_url().'assets/admin/icons/enclosure.png'; ?>"
                                    
                                   
                                 });
                           
                                  flightPath<?php echo $i; ?>.setMap(map);

                                    var contentString<?php echo $i; ?> = '<div style="float: right;" id="content">'+
                                                      '<div id="siteNotice">'+
                                                      '</div>'+
                                                      '<h4 id="firstHeading" class="firstHeading">'+"Connection Info"+'</h4>'+
                                                      '<hr>'+
                                                      '<div id="bodyContent">'+
                                                      '<p>'+"Start Location : <?php echo $row->start_location; ?>"+'</p>'+
                                                      '<p>'+"End Location : <?php echo $row->end_location; ?>"+'</p>'+
                                                      '<p>'+"Length: <?php echo $row->length; ?>"+'</p>'+
                                                      '<p>'+"color: <?php echo $row->color; ?>"+'</p>'+
                                                      '</div>'+
                                                      '</div>';

                                   var infowindow<?php echo $i; ?> = new google.maps.InfoWindow({
                                      content: contentString<?php echo $i; ?>,
                                      maxWidth: 150,
                                      //position: marker<?php echo $i; ?>

                                      
                                  });


                                  google.maps.event.addListener(flightPath<?php echo $i; ?>, 'mouseover', function() {
                                        infowindow<?php echo $i; ?>.open(map,marker<?php echo $i; ?>,flightPath<?php echo $i; ?>);
                                       
                                  });
                                   google.maps.event.addListener(flightPath<?php echo $i; ?>, 'mouseout', function() {
                                        infowindow<?php echo $i; ?>.close(map,marker<?php echo $i; ?>,flightPath<?php echo $i; ?>);
                                       
                                  });

                          <?php $i++; } 
                         
                          ?>      

                                  

                                  //for the focal point splitter
                                  <?php if($data[0]->type == 'L1'){

                                            $focalpoint = base_url().'assets/admin/icons/l1splitter.png';
                                            $source = base_url().'assets/admin/icons/olt.png';
                                            $title_source = $data[0]->device_name; 
                                        }
                                        else{

                                            $focalpoint = base_url().'assets/admin/icons/splitter.png';
                                            $source = base_url().'assets/admin/icons/l1splitter.png';
                                            $title_source = $data[0]->parent_splitter[0]->org_name;
                                        }
 
                                  ?>
                                  
                                  var markerclient = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $data[0]->latittude; ?>,<?php echo $data[0]->longitude; ?>),
                                    map: map,
                                    title: "<?php echo $data[0]->name; ?>",
                                    icon: "<?php echo $focalpoint; ?>",                                                                        
                                 
                                 });

                                  var contentStringL1 = '<div  id="content">'+
                                                        '<div id="siteNotice">'+
                                                        '</div>'+
                                                        '<h4 id="firstHeading" class="firstHeading">'+"Connection Info"+'</h4>'+
                                                        '<hr>'+
                                                        '<div id="bodyContent">'+
                                                        '<p>'+"Device : <?php echo $data[0]->name; ?>"+'</p>'+
                                                        '<p>'+"Location : <?php echo ucfirst($data[0]->location); ?>"+'</p>'+                                                      
                                                        '<p>'+"Device : <?php echo $data[0]->device_name; ?>"+'</p>'+
                                                        '<p>'+"Port: <?php echo $data[0]->device_port; ?>"+'</p>'+
                                                        '</div>'+
                                                        '</div>';

                                  var infowindowL1 = new google.maps.InfoWindow({
                                      content: contentStringL1,
                                      maxWidth: 150,
                                                                          
                                  });

                                 google.maps.event.addListener(markerclient,'mouseover', function(){

                                    infowindowL1.open(map,markerclient);
                                 });

                                 google.maps.event.addListener(markerclient,'mouseout', function(){

                                    infowindowL1.close(map,markerclient);
                                 });


                                 //for the source position

                                 var markersource = new google.maps.Marker({
                                    
                                    position: new google.maps.LatLng(<?php echo $data[0]->connection_info[0]->start_lattitude; ?>,<?php echo $data[0]->connection_info[0]->start_longitude; ?>),
                                    map: map,
                                    title: "<?php echo $title_source; ?>",
                                    icon: "<?php echo $source; ?>",                                                                        
                                 
                                 });
                              
                         



                           
                           <?php   $k=1;
                                  foreach($data[0]->outputs as $row1){ ?>

                                       <?php if(isset($row1->output_connection_info)) { ?>
                                                        
                                        //var spliter_enclosure = base_url+'assets/admin/icons/spliter_enclosure.png'; 
                                           
                                            <?php $j=1; 
                                               foreach($row1->output_connection_info as $childrow){ 
                                                        
                                                         if(isset($childrow->color_code)){

                                                               $color      =  $childrow->color_code;
                                                               $color_name =  $childrow->color;
                                                         
                                                         }else{
                                                              
                                                               $color      = $childrow->color1_code;
                                                               $color_name = $childrow->color1;

                                                         }?>
                                                    
                                                    var output<?php echo $j; ?>flightPlanCoordinates<?php echo $k ;?> =[
                                                              
                                                                new google.maps.LatLng(<?php echo $childrow->start_lattitude; ?>,<?php echo $childrow->start_longitude; ?>),
                                                                new google.maps.LatLng(<?php echo $childrow->end_lattitude; ?>,<?php echo $childrow->end_longitude; ?>),

                                                    ]; 

                                                   var output<?php echo $j; ?>flightPath<?php echo $k; ?> = new google.maps.Polyline({
                                                      path: output<?php echo $j; ?>flightPlanCoordinates<?php echo $k;?>,
                                                      geodesic: true,
                                                      strokeColor: "<?php echo $color; ?>",
                                                      strokeOpacity: 0.8,
                                                      strokeWeight: 5
                                                    });

                                                  
                                             
                                                    output<?php echo $j; ?>flightPath<?php echo $k; ?>.setMap(map);
                                                    
                                                     var marker<?php echo $j; ?>output<?php echo $k; ?> = new google.maps.Marker({
                                    
                                                        position: new google.maps.LatLng(<?php echo $childrow->end_lattitude; ?>,<?php echo $childrow->end_longitude ?>),
                                                        map: map,
                                                        title: "<?php echo $childrow->end_enclosure; ?>", 
                                                        icon : "<?php echo base_url().'assets/admin/icons/enclosure.png'; ?>"                                                                                            
                                                     
                                                     });
                                                    

                                                
                                                     var output<?php echo $j;?>contentString<?php echo $k; ?> = '<div style="float: right;" id="content">'+
                                                                                                                '<div id="siteNotice">'+
                                                                                                                '</div>'+
                                                                                                                '<h4 id="firstHeading" class="firstHeading">'+"Connection Info"+'</h4>'+
                                                                                                                '<hr>'+
                                                                                                                '<div id="bodyContent">'+
                                                                                                                '<p>'+"Start Location : <?php echo $childrow->start_location; ?>"+'</p>'+
                                                                                                                '<p>'+"End Location : <?php echo $childrow->end_location; ?>"+'</p>'+
                                                                                                                '<p>'+"Length: <?php echo $childrow->length; ?>"+'</p>'+
                                                                                                                '<p>'+"color: <?php echo $color_name; ?>"+'</p>'+
                                                                                                                '</div>'+
                                                                                                                '</div>';

                                                     var output<?php echo $j;?>infowindow<?php echo $k; ?> = new google.maps.InfoWindow({
                                                        content: output<?php echo $j;?>contentString<?php echo $k; ?>,
                                                        maxWidth: 150,                                                     

                                                        
                                                    });


                                                    google.maps.event.addListener(output<?php echo $j; ?>flightPath<?php echo $k; ?>, 'mouseover', function() {
                                                          output<?php echo $j;?>infowindow<?php echo $k; ?>.open(map,marker<?php echo $j; ?>output<?php echo $k; ?>,output<?php echo $j; ?>flightPath<?php echo $k; ?>);
                                                         
                                                    });
                                                     google.maps.event.addListener(output<?php echo $j; ?>flightPath<?php echo $k; ?>, 'mouseout', function() {
                                                          output<?php echo $j;?>infowindow<?php echo $k; ?>.close(map,marker<?php echo $j; ?>output<?php echo $k; ?>,output<?php echo $j; ?>flightPath<?php echo $k; ?>);
                                                         
                                                    });
                                              //enclosure info window end                  
                                                     
                                              <?php $j++; } ?>
                                       
                                        
                                        
                                        <?php if($row1->output_client_id != 0) {

                                                  $output_name = $row1->output_client_name;
                                                  $output_lat = $row1->output_client_latittude;
                                                  $output_long = $row1->output_client_longitude;
                                                  $output_icon = base_url().'assets/admin/icons/client.png';
                                             }
                                             elseif($row1->output_splitter_id != 0){

                                                  $output_name = $row1->output_splitter_name;
                                                  $output_lat = $row1->output_splitter_latittude;
                                                  $output_long = $row1->output_splitter_longitude;
                                                  $output_icon = base_url().'assets/admin/icons/splitter.png';
                                             }
                                             else{

                                             }?>

                                        //for the output
                                        var markeroutput<?php echo $k; ?> = new google.maps.Marker({
                                    
                                          position: new google.maps.LatLng(<?php echo $output_lat; ?>,<?php echo $output_long; ?>),
                                          map: map,
                                          title: "<?php echo $output_name; ?>",
                                          icon : "<?php echo $output_icon; ?>"
                                          
                                       
                                       });
                          
                                   <?php  } ?>
                          <?php $k++; } ?> 


                        } 

                       


                        google.maps.event.addDomListener(window, 'load', initialize);

                </script>
                  <div class="row">
                    <ul class="list-inline" style="margin-left:5px;">
                     
                      <li ><img src="<?php echo base_url(); ?>assets/admin/icons/client.png" class="img-responsive"><br>Client</li>
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



    
