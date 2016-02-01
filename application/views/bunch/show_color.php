<div class="row">
   <p class="pull-right" style="margin:20px;"><button id="addpage" class="btn btn-primary">Add Bunch</button></p>  
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
                                            <th>Color</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php  
                                                $i = 1;
                                                foreach($data as $row) {
                                                        
                                        ?>
                                        <tr class="gradeA">
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $row->color_name; ?></a></td>
                                           
                                            
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
                                     
                      window.location = base_url+"bunch/add";
                    });

               });
           </script>          