<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                <p  style="color:red;padding:10px;"><?php echo $this->session->flashdata('password_error');
								echo $this->session->flashdata('done'); ?></p>
                                
                                    <form role="form" method="post" action="<?php echo base_url()?>admin/update_password/<?php echo $this->session->userdata('user_id'); ?>" >
                                       
                                        
                                        
                                        <div class="form-group">
                                        	<label>Old Password</label>
                                            <input type="password" name="old_password" class="form-control" required />
                                        </div>
                                         <div class="form-group">
                                        	<label>New Password</label>
                                            <input type="password" id="new1" name="new_password" class="form-control" required />
                                        </div>
                                         <div class="form-group">
                                        	<label>Re-type Password</label>
                                            <input type="password" id="new2"  class="form-control" required />
                                            <span style="color:#C00;" class="error"></span>
                                        </div>
                                       
                                        
                                      
                                        
                                        <button id="submit" name="submit" type="submit" class="btn btn-default">Submit Button</button>
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
                                            
                                            if($('#new1').val()!= $('#new2').val()){

                                                error++;
                                            }
                                          
                                           
                                            if(error!= 0){
                                               
                                                $('.error').text('Not match.please re-type password');
                                                return false;
                                            }
                                    });
                                    
                        $('#reset').click(function(){

                             window.location = base_url+"admin/change_password";

                        });

                        
            });
           </script>