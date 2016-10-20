<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo L('_QWECHAT_TITLE_');?></title>

    <link href="/Desktop/palcomm/qwechat/Public/Static/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Desktop/palcomm/qwechat/Public/Static/css/metisMenu.min.css" rel="stylesheet">
    <link href="/Desktop/palcomm/qwechat/Public/Static/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/Desktop/palcomm/qwechat/Public/Static/css/qwechat-admin.css" rel="stylesheet">

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo U('Qwechat/Qwechat/qwechat');?>"><?php echo L('_QWECHAT_TITLE_');?></a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="padding: 10px;">
                    <i><img class="nav-user-photo" src="<?php echo (cookie('avatar')); ?>" alt="<?php echo (cookie('name')); ?>" style="width:30px;height:30px;border-radius: 50%;" /></i> &nbsp;<i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="<?php echo U('Qwechat/Admin/admin');?>"><i class="fa fa-user fa-fw"></i><?php echo (cookie('name')); ?></a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="<?php echo U('Qwechat/Admin/signout');?>"><i class="fa fa-sign-out fa-fw"></i><?php echo L('_LOGOUT_');?></a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav in" id="side-menu">
                    <li>
                        <a href="<?php echo U('Qwechat/Qwechat/qwechat');?>" class="active"><i class="fa fa-dashboard fa-fw"></i> <?php echo L('_DASHBOARD_');?></a>
                    </li>
                    <li>
                        <a href="<?php echo U('Qwechat/Organize/index');?>"><i class="fa fa-file-text fa-fw"></i> <?php echo L('_ORGANIZESETTINGS_');?><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Organize/groupSettings');?>"> <?php echo L('_GROUPSETTINGS_');?></a>
                            </li>
                        </ul>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Organize/branchManage');?>"> <?php echo L('_BRANCHMANAGE_');?></a>
                            </li>
                        </ul>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Organize/departmentManage');?>"> <?php echo L('_DEPARTMENTMANAGE_');?></a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="<?php echo U('Qwechat/Employee/index');?>"><i class="fa fa-user fa-fw"></i> <?php echo L('_EMPLOYEEMANAGE_');?><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Employee/employeeManage');?>"> <?php echo L('_EMPLOYEEMANAGE_SUB1_');?></a>
                            </li>
                        </ul>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Employee/leaveEmployee');?>"> <?php echo L('_LEAVEEMPLOYEE_');?></a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?php echo U('Qwechat/Application/index');?>"><i class="fa fa-lock fa-fw"></i> <?php echo L('_APPLICATIONMANAGE_');?><span class="fa arrow"></span></a>
                         <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Application/applicationManage');?>"> <?php echo L('_APPLICATIONMANAGE_SUB1_');?></a>
                            </li>
                        </ul>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Application/basicConfig');?>"> <?php echo L('_BASICCONFIG_');?></a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="<?php echo U('Qwechat/Message/index');?>"><i class="fa fa-user-md fa-fw"></i> <?php echo L('_MESSAGEMANAGE_');?><span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Message/activeMessage');?>"> <?php echo L('_ACTIVEMESSAGE_');?></a>
                            </li>
                        </ul>
                        <ul class="nav nav-second-level collapse">
                            <li>
                                <a href="<?php echo U('Qwechat/Message/messageList');?>"> <?php echo L('_MESSAGELIST_');?></a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper" style="min-height: 299px;">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"> <?php echo L('_DASHBOARD_');?></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>


    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<script src="/Desktop/palcomm/qwechat/Public/Static/js/jquery.min.js"></script>
<script src="/Desktop/palcomm/qwechat/Public/Static/js/bootstrap.min.js"></script>
<script src="/Desktop/palcomm/qwechat/Public/Static/js/metisMenu.min.js"></script>
<script src="/Desktop/palcomm/qwechat/Public/Static/js/qwechat-admin.js"></script>

</body>

</html>