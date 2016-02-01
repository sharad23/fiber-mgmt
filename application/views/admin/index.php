<div class="row">
   <p class="pull-right" style="margin:20px;"><button id="addpage" class="btn btn-primary">Add User</button></p>  
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
                                            <th>Username</th>
                                            <th>Role</th>
                                            <th>Permission</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i=1; foreach($data as $value): ?>
                                    <?php
											if($value->user_type=='0'){
												
												$value->user_type = 'Admin';
											}
											else if($value->user_type=='1'){
												
												$value->user_type='Master Admin';
											}
											if($value->flag=='0'){
												
												$value->flag='Read Only';
											}
											else if($value->flag=='1'){
												
												$value->flag='Read/Write';
											}	
									?>
                                         <tr>
                                         	<td><?php echo $i++; ?></td>
                                            <td><?php echo ucwords($value->name); ?></td>
                                         	<td><?php echo ucfirst($value->username); ?></td>
                                            <td><?php echo $value->user_type; ?></td>
                                            <td><?php echo $value->flag; ?></td>
                                            <td>
                                            	<a href="<?php echo base_url().'admin/edit/'.$value->id; ?>" class="btn btn-default">Edit</a>
                                               <?php if($value->block==0){ ?>
                                                <a href="<?php echo base_url().'admin/block/'.$value->id; ?>" class="btn btn-default">Block</a><?php }elseif($value->block==1) { ?>
                                                <a href="<?php echo base_url().'admin/unblock/'.$value->id; ?>" class="btn btn-default">Unblock</a>
                                                <?php } ?>
                                                
                                            </td>
                                         </tr>
                                    <?php endforeach; ?>
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
                                     
                      window.location = base_url+"admin/add";
                    });

               });
           </script>          