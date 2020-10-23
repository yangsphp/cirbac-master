

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GKGD智慧商贸管理系统</title>
    <!-- ================= Favicon ================== -->
    <!-- Styles -->

    <link href="<?php echo $skin . $css; ?>lib/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/themify-icons.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>style.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/select/bootstrap-select.css" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo $skin . $css; ?>lib/treegrid/bootstrap-table.css">
    <link href="<?php echo $skin . $css; ?>lib/sweetalert/sweetalert.css" rel="stylesheet">
    <link href="<?php echo $skin . $css; ?>lib/toastr/toastr.min.css" rel="stylesheet">
  
    <script src="<?php echo $skin . $js; ?>lib/jquery.min.js"></script>
	<!-- bootstrap -->
	<script src="<?php echo $skin . $js; ?>lib/bootstrap.min.js"></script>
	<script src="<?php echo $skin . $js; ?>lib/treegrid/bootstrap-table.min.js"></script>
	<script src="https://cdn.bootcss.com/bootstrap-table/1.11.1/locale/bootstrap-table-zh-CN.min.js"></script>
	<!-- 弹出框 -->
	<script src="<?php echo $skin . $js; ?>lib/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript" src="<?php echo $skin . $js; ?>lib/bootstrapValidator.js"></script>
	<script type="text/javascript" src="<?php echo $skin . $js; ?>time.js"></script>
	
</head>
<body>
<div class="main">
    <div class="page-header">
        <ul class="breadcrumb">
            <li><a href="#">提示页</a></li>
        </ul>
    </div>
    <section id="main-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card alert" style="pediting:25px">
                    <div class="card-body">
		               <div class="alert alert-danger">
                         <?php echo $error[$eid];?>
                       </div>
                    </div>
                </div>
                <!-- /# card -->
            </div>
            <!-- /# column -->
        </div>

    </section>
</div>

 
<script type="text/javascript">

</script>
</body>
</html>