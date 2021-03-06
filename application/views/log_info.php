<?php require_once('common/header.php');?>
<?php require_once('common/menu.php');?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">操作日志</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    操作信息列表
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="log_list_info" width="100%">
                            <thead>
                            <tr>
                                <th width="10%">序号</th>
                                <th width="20%">操作人</th>
                                <th width="20%">登录IP</th>
                                <th width="30%">操作内容</th>
                                <th width="20%">操作时间</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-6 -->

    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->


<link href="resource/DataTables/media/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="resource/DataTables/media/css/dataTables.responsive.css">

<script type="text/javascript" charset="utf8" src="resource/DataTables/media/js/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="resource/DataTables/media/js/dataTables.bootstrap.js"></script>

<script type="text/javascript" src="resource/DataTables/media/js/dataTables.responsive.min.js"></script>


<script>
    $(document).ready(function () {
//        table = ini_paging('log_list_info',4,'<?php //echo site_url('log_info/get_log_info') ?>//');
        $("#log_list_info").DataTable({
//            "paging":true,
            "pagingType": "full_numbers",
            "responsive": true,
            //"lengthMenu":[5,10,25,50],
            "processing": true,
            "searching": true, //是否开启搜索
            "serverSide": true,//开启服务器获取数据
            "order": [[4, "desc"]], //默认排序
            "ajax": { // 获取数据
                "url": "<?php echo site_url('log_info/get_log_info') ?>",
                "dataType": "json" //返回来的数据形式
            },
            "columns": [ //定义列数据来源
                {'data': "id"},
                {'data': "log_username"},
                {'data': "ip_addr"},
                {'data': "log_content"},
                {'data': "log_datetime"}
            ],
            "language": { // 定义语言
                "sProcessing": "<img src='resource/images/loading.gif'/> &nbsp;&nbsp;数据加载中，请稍后...&nbsp;&nbsp;",
                "sLengthMenu": "每页显示 _MENU_ 条记录",
                "sZeroRecords": "没有匹配的结果",
                "sInfo": "当前显示第 _START_ 至 _END_ 条，共 _TOTAL_ 条。",
                "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
                "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                "sInfoPostFix": "",
                "sSearch": "搜索:",
                "sUrl": "",
                "sEmptyTable": "表中数据为空",
                "sLoadingRecords": "<img src='resource/images/loading.gif'/>载入中...",
                "sInfoThousands": ",",
                "oPaginate": {
                    "sFirst": "首页",
                    "sPrevious": "上一页",
                    "sNext": "下一页",
                    "sLast": "末页"
                },
                "stripeClasses": ["odd", "even"],//为奇偶行加上样式，兼容不支持CSS伪类的场合
            }

        });//table end
    });
</script>

<?php require_once('common/footer.php');?>


