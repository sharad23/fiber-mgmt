<div class="row">
   <p class="pull-right" style="margin:20px;"><button id="addpage" class="btn btn-primary">Add Fiber</button></p>
   <p class="pull-right" style="margin:20px;"><button id="deadpage" class="btn btn-primary">Dead Fiber</button></p>    
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
										<tr role="row">
											<th>S.N</th>
											<th>Drum Number</th>
											<th>Number of Cores</th>
		                  <th>Brand Name</th>
		                  <th>Total length(m)</th>
                      <th>Available Length(m)</th>
                      <th>Action</th>
                                           <!-- <th>Available Length</th>-->
											
										</tr>
									</thead>
									<tbody>
										 <?php $i=1; foreach($data  as $row) { ?>
                                         <?php $core = $this->bunchmodel->get_bunch(array('id'=>$row->bunch_id)); ?>
                                         <?php if($row->available_length > 0) {?>
											<tr>

											   <td><?php echo $i; ?></td>
                                               <td><?php echo $row->drum_no;?></td> 
		                                       <td><?php echo $core[0]->core; ?></td>
											   
											   <td><?php echo ucfirst($row->brand_name); ?></td>
                                               <td><?php echo $row->total_length; ?></td>
                                               <td><?php echo $row->available_length; ?></td>
											   <td>
												   	<a href="<?php echo base_url();?>fiber/edit/<?php echo $row->id; ?>"><button id="edit" >Edit</button></a>
												   	
											   </td>
											</tr>
                       <?php } ?>
										 <?php $i++; } ?>
										
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
                                     
                      window.location = base_url+"fiber/add";
                    });

                    $('#deadpage').click(function(){
                                     
                      window.location = base_url+"fiber/deadfiber";
                    });

               });
           </script> 