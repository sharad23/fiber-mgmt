<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="<?php echo base_url()?>admin/update/<?php echo $data[0]->id; ?>" >
                                       <div class="form-group">
                                            <label>Name</label>
                                            <input value="<?php echo $data[0]->name; ?>" id="name" class="form-control" name="name" style="width:300px;">
                                        </div>
                                       
                                       
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input value="<?php echo $data[0]->username; ?>" id="username" class="form-control" name="username" style="width:300px;">
                                        </div>
                                        <div class="form-group">
                                            <label>User Type</label>
                                            <select name="user_type" class="form-control" style="width:300px;">
                                            	<option value="">Select</option>
                                                <option value="0" <?php if($data[0]->user_type=='0'){ echo 'selected';} ?>>Admin</option>
                                                <option value="1"<?php if($data[0]->user_type=='1'){ echo 'selected'; } ?>>Master Admin</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Permission</label>
                                            <select name="permission" class="form-control" style="width:300px;">
                                            	<option value="">Select</option>
                                                <option value="0" <?php if($data[0]->flag=='0'){echo 'selected';} ?>>Read Only</option>
                                                <option value="1"<?php if($data[0]->flag=='1'){echo 'selected';} ?>>Read/Write</option>
                                            </select>
                                        </div>                  
                                        
                                      
                                        
                                        <button id="submit" type="submit" class="btn btn-default">Submit Button</button>
                                        <button id="reset" type="reset" class="btn btn-default">Reset Button</button>
                                    </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                              
                             
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
           <script>
               $(document).ready(function(){
        
                        var base_url = $('body').attr('data-url');
                        
                       

                         $('#submit').click(function(){
                                            

                                            var error = 0;
                                            
                                            if($('#name').val() == ""){

                                                error++;
                                            }
                                          
                                           
                                            if(error!= 0){
                                               
                                                alert("Empty feilds");
                                                return false;
                                            }
                                    });
                                    
                        $('#reset').click(function(){

                             window.location = base_url+"admin/add";

                        });

                        
            });
           </script>