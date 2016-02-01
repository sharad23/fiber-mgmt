<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?php echo $title; ?>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <form role="form" method="post" action="<?php echo base_url()?>bunch/update" >
                                        <input type="hidden" name="id" value="<?php echo $data[0]->id; ?>"/>
                                        
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input id="core" class="form-control" name="core" value="<?php echo $data[0]->core; ?>" readonly>
                                        </div>

                                         <!--<div id="color" class="form-group" hidden>
                                            <label>Colors</label>
                                            <select name="color[]" >
                                                <option>Select a color</option>
                                                <?php foreach($colors as $color){ ?>
                                                    
                                                      <option value="<?php echo $color->id?>"><?php echo $color->name; ?></option>
                                                
                                                <?php } ?>
                                           </select>
                                        </div>-->

                                        <div id="cont">
                                            <?php  foreach($data[0]->bunch_core as $row) { ?>
                                              <input type="hidden" name="bunch_color_id[]" value="<?php echo $row->id; ?>" />
                                              <div id="color" class="form-group">
                                                <label>Colors</label>
                                                <select name="color[]" >
                                                    <option value="<?php echo $row->color_id; ?>"><?php echo $row->color_name; ?></option>
                                                    <option value="<?php echo $row->color_id; ?>">-----------</option>
                                                    <?php foreach($colors as $color){ ?>
                                                          
                                                          <option value="<?php echo $color->id; ?>"><?php echo $color->name; ?></option>
                                                    
                                                    <?php } ?>
                                                </select>
                                              </div>
                                            <?php } ?>
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
                        
                        $('#edit_submit_news').click(function(){

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
                                    $('#color').show();
                                    for (i = 0; i < number ; i++) { 

                                        $('#color').clone().appendTo('#cont');

                                    }
                                }
                                else{

                                    alert("Please enter a number");
                                }
                         });
                                    
                        $('edit_reset_news').click(function(){

                             location.reload();

                        });
                        function isInt(n) {
                            if(n % 1 === 0){

                                return true;
                            }
                        }

                      
                        
                        


            });
           </script>


    
