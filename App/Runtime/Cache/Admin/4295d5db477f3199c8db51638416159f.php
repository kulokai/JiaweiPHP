<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
<title>账号管理</title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="kai">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="Shortcut Icon" href="/Snow_php_admin_framework/Public/img/sm.png">
<link href="/Snow_php_admin_framework/Public/css/bootstrap.min.css" rel="stylesheet">
<link href="/Snow_php_admin_framework/Public/css/font-awesome.min.css" rel="stylesheet">
<link href="/Snow_php_admin_framework/Public/css/datepicker.css" rel="stylesheet"/>
<link href="/Snow_php_admin_framework/Public/css/animate.min.css" rel="stylesheet">
<link href="/Snow_php_admin_framework/Public/css/simplify.min.css" rel="stylesheet">
<link href="/Snow_php_admin_framework/Public/css/jw.css" rel="stylesheet">
</head>

<body class="overflow-hidden">
<div class="wrapper preload">
    <!--顶栏-->
    <header class="top-nav">
    <div class="top-nav-inner">
        <div class="nav-header">
            <a href="#" class="brand">
                <span class="brand-name" style="vertical-align: middle"><i class="fa fa-code"></i> <span class=text-primary>Jiawei PAF (Alpha)</span></span>
            </a>
        </div>
        <div class="nav-container">
            <a href="/Snow_php_admin_framework/index.php/Home/Index/logout">
                <div class="pull-right text-danger" style="line-height: 54px;padding: 0 30px">
                    <i class="fa fa-sign-out"></i> <b>退出</b>
                </div>
            </a>
        </div>
    </div>
</header>

    <!-- 菜单 -->
    <aside class="sidebar-menu fixed">
    <div class="sidebar-inner scrollable-sidebar">
        <div class="main-menu">
            <div class="side-head">
                <img class="img-circle" src="<?php echo ($man_info["head_img"]); ?>">
                <br><br>
                <span><?php echo ($man_info["nick_name"]); ?></span>
            </div>
            <ul class="accordion">
                <?php echo ($menu_html); ?>
            </ul>
        </div>
    </div><!-- sidebar-inner -->
</aside>

    <!--主要内容-->
    <div class="main-container">
        <div class="padding-md">
            <!--标题-->
            <div class="jw-box">
                <div class="page-title text-primary">
                    <b>账号管理</b>
                </div>
            </div>
            <div class="jw-box">
                <form>
                    <input type="text" name="name" placeholder="姓名">
                    <input type="text" name="uname" placeholder="账号">
                    <button>搜索</button>
                </form>
            </div>
            <div class="jw-box">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>#</th>
                        <th>姓名</th>
                        <th>账号</th>
                        <th>最后IP</th>
                        <th>角色</th>
                        <th>创建时间</th>
                        <th>操作</th>
                    </tr>
                    <?php if(is_array($user)): foreach($user as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><?php echo ($vo["username"]); ?></td>
                            <td><?php echo ($vo["last_login_ip"]); ?></td>
                            <td><?php echo ($vo["role_name"]); ?></td>
                            <td><?php echo ($vo["create_time"]); ?></td>
                            <td>
                                删除
                                修改
                            </td>
                        </tr><?php endforeach; endif; ?>
                </table>
            </div>
            <!--导入分页-->
            <div class="jw-box text-center">
    <form>
        <?php if(is_array($pages)): foreach($pages as $key=>$vo): if($vo["page"] == -1): ?><a class="btn btn-success btn-sm" href="<?php echo ($vo["link"]); ?>">上一页</a>
                <?php elseif($vo["page"] == -2): ?>
                <a class="btn btn-success btn-sm" href="<?php echo ($vo["link"]); ?>">下一页</a>
                <?php else: ?>
                <a class="btn btn-success btn-sm" href="<?php echo ($vo["link"]); ?>"><?php echo ($vo["page"]); ?></a><?php endif; endforeach; endif; ?>
        <input type="text" name="p" style="width:60px" placeholder="页码">
        <button class="btn btn-success btn-sm">跳转</button>
        <span>共<?php echo ($page_count); ?>页，当前第<?php echo ($current_page); ?>页</span>
    </form>
</div>
        </div><!-- ./padding-md -->
    </div><!-- /main-container -->

    <footer class="footer">
    <span class="footer-brand">
        <strong class="text-primary">Jiawei</strong>xs.com
    </span>
    <p class="no-margin">
        A PHP Admin Framework By <b>Jiawei</b> 2016.
    </p>
</footer>
</div><!-- /wrapper -->
<a href="#" class="scroll-to-top hidden-print"><i class="fa fa-chevron-up fa-lg"></i></a>
<!-- Jquery -->
<script src="/Snow_php_admin_framework/Public/js/jquery-1.11.1.min.js"></script>
<!--<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>-->
<!-- Bootstrap -->
<script src="/Snow_php_admin_framework/Public/js/bootstrap.min.js"></script>
<!-- Slimscroll平滑滚动 -->
<script src='/Snow_php_admin_framework/Public/js/jquery.slimscroll.min.js'></script>
<!-- Datepicker时间选择 -->
<script src='/Snow_php_admin_framework/Public/js/datepicker.js'></script>
<!-- Sortable -->
<script src='/Snow_php_admin_framework/Public/js/jquery.sortable.js'></script>
<!-- Simplify -->
<script src="/Snow_php_admin_framework/Public/js/simplify.js"></script>
<script>
    setInterval(function () {
        $.ajax({
            url:'/Snow_php_admin_framework/index.php/Admin/User/alive',
            type:'get',
            success:function (msg) {
                console.log(msg);
            }
        });
    },600000)
</script>
</body>
</html>