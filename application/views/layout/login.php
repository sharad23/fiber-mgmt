<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $page_title; ?></title>

    <!-- Bootstrap Core CSS -->
   <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap.min.css" rel="stylesheet">
     <!-- jquery UI-->
    <link href="<?php echo base_url(); ?>assets/admin/css/jquery-ui.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php echo base_url(); ?>assets/admin/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url(); ?>assets/admin/css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_Url(); ?>assets/admin/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url(); ?>assets/admin/css/plugins/morris.css" rel="stylesheet">

     <!-- DataTables CSS -->
    <link href="<?php echo base_url(); ?>assets/admin/css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url(); ?>assets/admin/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

       <!--cropic css-->
    <link href="<?php echo base_url(); ?>assets/admin/css/croppic.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
	<body>   
   
   
        <div class="container">           
          
           
             <div  style="margin-top:5em; background-color:#ddd;" class="col-md-8 col-sm-8 col-sm-offset-2"> 
                  <div class="row" style="color:#FFF;background-color:#4C3731; padding:15px;margin-bottom:3em;">
                      <p style="font-family:'Courier New', Courier, monospace; font-weight:600; font-size:16px;">   						<?php echo $title; ?>
                      </p>
                  </div>
                    
                    <?php echo $this->session->flashdata('Login_error'); ?>
                    
                    <form class="form-horizontal col-md-5" method="post" action="<?php echo base_url().'home/do_login'; ?>">
            
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="login-username" type="text" class="form-control" name="username" placeholder="username or email">                                        
                        </div>
            
                        <div style="margin-bottom: 25px" class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="login-password" type="password" class="form-control" name="password" placeholder="password">
                        </div>
            
                        <div style="margin-top:10px" class="form-group">
                        <!-- Button -->
                            <div class="col-sm-12 controls">
                                <button type="submit" class="btn btn-default">Login </button>   
                
                            </div>
                        </div>       
            
                    </form> 
                    <div class="col-md-3 col-md-offset-3 pull-left">
                    	<img src="<?php echo base_url().'assets/img/websurfer.png'; ?>" class="img-responsive">
                        <!--<p style="font-family:'Courier New', Courier, monospace; ">Fiber Network Management</p>-->
                    </div>      
            
                </div>
                
                
            
		</div><!--/container-->
        
	</body>
</html>