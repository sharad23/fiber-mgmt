<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="<?php echo base_url()?>color/update" >
                                        <input type="hidden" name="id" value="<?php echo $data[0]->id; ?>"/>
                                        
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input id="name" class="form-control" name="name" value="<?php echo $data[0]->name; ?>">
                                        </div>

                                        <div class="form-group">
                                             <input id="name" class="colorpicker" name="code"  value="<?php echo $data[0]->code; ?>">
                                        </div>
                                        
                                        <button id="edit_submit_news" type="submit" class="btn btn-default">Submit Button</button>
                                        <button id="edit_reset_news" type="reset" class="btn btn-default">Reset Button</button>
                                    
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
                       
                        
                        $('#edit_submit_news').click(function(){

                                var error = 0;
                                if($('#name').val() == ""){

                                    error++;
                                }
                              
                                if(error!= 0){
                                   
                                    alert("Empty feilds");
                                    return false;
                                }
                        });
                                    
                        $('edit_reset_news').click(function(){

                             location.reload();

                        });

                      
                        
                        


            });
           </script>


    
