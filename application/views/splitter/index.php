<div class="row">
   <p class="pull-right" style="margin:20px;"><button id="addpage" class="btn btn-primary">Add Splitter</button></p>
   <p class="pull-right" style="margin:20px;"><button id="splittergraph" class="btn btn-primary">Splitter graph</button></p>    
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
                                            <th>Name</th>
                                            <th>Splitter. Type</th>
                                            <th>Updated Date</th>
                                            <th>Content Control</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php  
                                                $i = 1;
                                                foreach($data as $row) {
                                                        
                                                        if($row->type == 1){
                                                              
                                                              $row->type = "L1";  
                                                        }
                                                        else{
                                                              $row->type = "L2";
                                                        }
                                                       
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $i; ?></td>
                                            <td><a href="<?php echo base_url(); ?>splitter/details/<?php echo $row->id; ?>"><?php echo $row->name; ?></a></td>
                                            <td><?php echo $row->type; ?></td>
                                            <td><?php echo date('Y-m-d',$row->date); ?></td>
                                            <td class="center">
                                                &nbsp;&nbsp;&nbsp;
                                               
                                                <a href="<?php echo base_url()?>splitter/edit/<?php echo $row->id; ?>"><button class="edit-icon" data-placement="left" data-toggle="tooltip" 
                                                 data-original-title="Edit"type="button" class="btn btn-success btn-circle">Edit
                                                 </button></a>&nbsp;&nbsp;
                                                <a onclick="return confirm('Are you sure you want to delete this item?');" href="<?php echo base_url()?>splitter/delete/<?php echo $row->id; ?>"><button class="Delete-icon"  data-placement="left" data-toggle="tooltip" 
                                                data-original-title="delete" type="button" class="btn btn-warning btn-circle">Delete
                                                </button></a>
                                            
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
                                     
                      window.location = base_url+"splitter/add";
                    
                    });
                    $('#splittergraph').click(function(){
                                     
                      window.location = base_url+"splitter/splittergraph";
                    });
               });
           </script>          