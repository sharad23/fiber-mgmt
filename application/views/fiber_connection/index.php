<div class="row">
   <p class="pull-right" style="margin:20px;"><button id="addpage" class="btn btn-primary">Add Connection</button></p> 
   <p class="pull-right" style="margin:20px;"><button id="graph" class="btn btn-primary">Full Network</button></p>   
</div>

<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                         <?php echo $title; ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">

                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.N</th>
                                            <th>Conn. Obj</th>
                                            <th>Start - End Location</th>
                                            <th>Start - End Enclosure</th>
                                            <th>Added</th>
                                            <th></th>
                                       
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php  
                                                $i = 1;
                                                foreach($data as $row) {
                                                        
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $i; ?></td>
                                            <td><a href="<?php echo base_url(); ?>fiberconnection/details/<?php echo $row->id; ?>"><?php echo $row->objective; ?></a></td>
                                            <td><?php echo $row->start_location.' => '.$row->end_location; ?></td>
                                            <td><?php echo $row->start_name.' =>  '.$row->end_name; ?></td>
                                            <td><?php echo date('Y-m-d',$row->date); ?></td>
                                            <td class="center">
                                                &nbsp;&nbsp;&nbsp;
                                               
                                                 <a href="<?php echo base_url(); ?>fiberconnection/details/<?php echo $row->id; ?>"><button class="edit-icon" data-placement="left" data-toggle="tooltip" 
                                                 data-original-title="Edit"type="button" class="btn btn-success btn-circle">Details
                                                 </button></a>&nbsp;&nbsp;
                                               
                                            </td>
                                            
                                        </tr>

                                                         
                                         <?php           
                                                 $i++;
                                                
                                        }?>
                                       
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                           
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <script>
               $(document).ready(function(){
                   

                    var base_url = $('body').attr('data-url');
                    $('#addpage').click(function(){
                                     
                      window.location = base_url+"fiberconnection/add";
                    });
                     $('#graph').click(function(){
                                     
                      window.location = base_url+"fiberconnection/networkgraph";
                    });
               });
           </script>          