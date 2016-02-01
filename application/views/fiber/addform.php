<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="<?php echo base_url()?>fiber/insert" >
                                       
                                        <div class="form-group">
                                            <label>Select Bunch(core)</label>
                                            <select name="bunch" class="form-control" required>
                                            	<option value="">Select</option>
                                                <?php foreach($bunch as $core): ?>
                                                <option value="<?php echo $core->id ?>"><?php echo $core->core; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                        	<label>Drum Number</label>
                                            <input type="text" id="drum_no" name="drum_no" class="form-control" required />
                                        </div>
                                         <div class="form-group">
                                        	<label>Brand Name</label>
                                            <input type="text" id="brans_name" name="brand_name" class="form-control" required />
                                        </div>
                                         <div class="form-group">
                                        	<label>Total Length <span>(In meter)</span></label>
                                            <input type="text" name="total_length" class="form-control" required />
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
                                            

                                            /*var error = 0;
                                            
                                            if($('#name').val() == ""){

                                                error++;
                                            }
                                          
                                           
                                            if(error!= 0){
                                               
                                                alert("Empty feilds");
                                                return false;
                                            }*/
                                    });
                                    
                        $('#reset').click(function(){

                             window.location = base_url+"fiber/add";

                        });

                        
            });
           </script>