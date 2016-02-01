<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="<?php echo base_url()?>bunch/insert" >
                                       
                                        <div class="form-group">
                                            <label>No. of cores</label>
                                            <input id="core" class="form-control" name="core">
                                        </div>
                                        
                                        
                                       <div id="color" class="form-group">
                                            <label>Colors</label>
                                            <select name="color[]" >
                                                <option>Select a color</option>
                                                <?php foreach($colors as $color){ ?>
                                                    
                                                      <option value="<?php echo $color->id?>"><?php echo $color->name; ?></option>
                                                
                                                <?php } ?>
                                           </select>
                                        </div>
                                     
                                        <div id="cont">
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
                                
                                if($('#core').val() == ""){

                                    error++;
                                }
                              
                               
                                if(error!= 0){
                                   
                                    alert("Empty feilds");
                                    return false;
                                }
                        });

                        $('#core').keyup(function(){
                                
                                $('#cont').html('');
                                var number = $('#core').val();
                                if(isInt(number) == true){ 
                                    number =  number -1;
                                    for (i = 0; i < number ; i++) { 

                                        $('#color').clone().appendTo('#cont');

                                    }
                                }
                                else{

                                    alert("Please enter a number");
                                }
                         });
                                    
                        $('#reset').click(function(){

                             window.location = base_url+"bunch/add";

                        });

                        function isInt(n) {
                            if(n % 1 === 0){

                                return true;
                            }
                        }

                        
            });
           </script>