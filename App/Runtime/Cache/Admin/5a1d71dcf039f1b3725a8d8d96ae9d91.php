<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
<title>菜单管理</title>
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
                    <b>菜单管理</b>
                </div>
            </div>
            <div class="jw-box">
                <form>
                    <input type="text" name="name" placeholder="名称">
                    <input type="text" name="url" placeholder="节点">
                    <button>搜索</button>
                </form>
                <a class="btn btn-sm btn-primary" onclick="$('#add-mb').modal()">新增菜单</a>
            </div>
            <div class="jw-box">
                <table class="table table-bordered table-hover">
                    <tr>
                        <th>#</th>
                        <th>菜单名称</th>
                        <th>节点位置</th>
                        <th>icon</th>
                        <th>级数</th>
                        <th>父级菜单(ID)</th>
                        <th>操作</th>
                    </tr>
                    <?php if(is_array($menu)): foreach($menu as $key=>$vo): ?><tr>
                            <td><?php echo ($vo["id"]); ?></td>
                            <td><?php echo ($vo["name"]); ?></td>
                            <td><?php echo ($vo["url"]); ?></td>
                            <td><i class="fa fa-<?php echo ($vo["icon"]); ?>"></i> <?php echo ($vo["icon"]); ?></td>
                            <td><?php echo ($vo["type"]); ?></td>
                            <td><?php echo ($vo["parent_id"]); ?></td>
                            <td>
                                <a class="text-danger" onclick="delTip('<?php echo ($vo["id"]); ?>')">删除</a>
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

    <!--新增菜单-->
    <div class="modal fade" id="add-mb">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">新增菜单</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group m-bottom-md">
                        <select class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                        </select>
                    </div>
                    <div class="form-group m-bottom-md">
                        <input type="text" name="name" class="form-control" placeholder="菜单名称" required>
                    </div>
                    <div class="form-group m-bottom-md">
                        <input type="text" name="icon" class="form-control" placeholder="菜单图标" required>
                    </div>
                    <div class="form-group m-bottom-md">
                        <input type="text" name="url" class="form-control" placeholder="URL网页" required>
                    </div>
                    <div class="form-group m-bottom-md">
                        <input type="text" name="sort" class="form-control" placeholder="排序" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <a id="sure-del-btn" class="btn btn-primary">非常确定</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <footer class="footer">
    <span class="footer-brand">
        <strong class="text-primary">Jiawei</strong>xs.com
    </span>
    <p class="no-margin">
        A PHP Admin Framework By <b>Jiawei</b> 2016.
    </p>
</footer>
    <!--删除提醒-->
<div class="modal fade" id="del-mb">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">提示</h4>
            </div>
            <div class="modal-body">
                <p>你确定删除该项？</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <a id="sure-del-btn" class="btn btn-primary">非常确定</a>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    function delTip($id) {
        $('#sure-del-btn').attr('href','/Snow_php_admin_framework/index.php/Admin/Menu/del/id/'+$id);
        $('#del-mb').modal();
    }
</script>
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
            url:'/Snow_php_admin_framework/index.php/Admin/Menu/alive',
            type:'get',
            success:function (msg) {
                console.log(msg);
            }
        });
    },600000)
</script>
</body>
</html>