<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="<?php echo base_url()?>color/insert" >
                                       
                                        <div class="form-group">
                                            <label>Color Name</label>
                                            <input id="name" class="form-control" name="name">
                                        </div>
                                       
                                        <div class="form-group">
                                             <input id="code" class="colorpicker" name="code"  value="#B6BD79">
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
                         
                         $('.colorpicker').colorPicker();
                       

                         $('#submit').click(function(){
                                            

                                            var error = 0;
                                            
                                            if($('#name').val() == ""){

                                                error++;
                                            }
                                            if($('#code').val() == ""){

                                                error++;
                                            }
                                           
                                            if(error!= 0){
                                               
                                                alert("Empty feilds");
                                                return false;
                                            }
                                    });
                                    
                        $('#reset').click(function(){

                             window.location = base_url+"color/add";

                        });

                        
            });
           </script>