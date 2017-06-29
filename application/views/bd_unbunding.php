<?php require_once('common/header.php'); ?>
<?php require_once('common/menu.php'); ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">宽带解绑</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        单一解绑
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" id="btn-add"><i class="fa fa-plus"></i> 单一宽带解绑
                            </button>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        批量解绑
                    </div>

                    <div class="panel-body">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-primary" id="btn-multi-add"><i class="fa fa-plus"></i>
                                批量宽带解绑
                            </button>
                        </div>

                    </div>
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-6 -->

        </div>
        <!-- /.row -->
    </div>


    <script>

        $("#btn-multi-add").click(function () {
            var community_info = $("#community_info").val();

            if (community_info == 'all') {
                var d = dialog({
                    content: '请选择所属小区！'
                });
                d.show();
                setTimeout(function () {
                    d.close().remove();
                }, 1500);
                return;
            }
            var data_array = ($.trim(community_info)).split(',');//利用,来分割小区ID和分前端ID
            var community_info = data_array[0];
            var sr_info = data_array[1];

            //uploading both data and file in one form using Ajax
            //resolution: http://stackoverflow.com/questions/21060247/send-formdata-and-string-data-together-through-jquery-ajax
            var formData = new FormData();
            formData.append('file', $('#file')[0].files[0]);
            formData.append('community_info', community_info);
            formData.append('sr_info', sr_info);
            if ($('#file').val() == '') {
                var info = dialog({
                    content: '请选择需要添加的文件'
                });
                info.show();
                setTimeout(function () {
                    info.close().remove();
                }, 1500);
                return false;
            }
            //loading事件
            dialog({
                id: 'result_info',
                title: '设备批量添加中，请稍后...',
                width: 'auto',
                quickClose: true
            }).show();
            $.ajax({
                url: '<?php echo site_url('device_info/add_multi_dev') ?>',
                type: 'POST',
                cache: false,
                data: formData,
                processData: false,
                contentType: false
            }).done(function (res) {
                var res = jQuery.parseJSON(res);//解析JSON
//                alert(res.result);
                if (res.result == 'file_error') {
                    var info = dialog({
                        content: '上传文件类型错误，只能上传excel文件'
                    });
                    info.show();
                    setTimeout(function () {
                        dialog.get('result_info').close();
                        info.close().remove();
                    }, 1500);
                    return false;
                } else if (res.result == 'fail') {
                    var info = dialog({
                        content: '添加失败，请稍后再试'
                    });
                    info.show();
                    setTimeout(function () {
                        dialog.get('result_info').close();
                        info.close().remove();
                    }, 1500);
                    return false;
                } else {
                    $("#btn-multi-add").html("添加成功");
                    $("#btn-multi-add").attr('disabled', true);
                    var info = dialog({
                        content: '添加成功<br>添加成功局端数：' + res.success_num + '<br>添加失败局端数：' + res.fail_num
                    });
                    info.show();
                    setTimeout(function () {
                        dialog.get('result_info').close();
//                        info.close().remove();
                    }, 1000);
                    return false;
                }
            }).fail(function (res) {
                var info = dialog({
                    content: '上传失败，请稍后再试'
                });
                info.show();
                setTimeout(function () {
                    dialog.get('result_info').close();
                    info.close().remove();
                }, 1500);
                return false;
            });

        });

        //添加局端信息
        $("#btn-add").click(function () {
            var d = dialog({
                title: '宽带解绑',
                width: 'auto',
                content: '宽带账号：<input type="text" class="form-control" id="db_id" placeholder="请输入宽带账号" autofocus>' +
                '',
                okValue: '解绑',
                ok: function () {
                    var db_id = $.trim($('#db_id').val());

                    if (db_id.length == 0 || db_id.length == 0) {
                        var info = dialog({
                            content: '请输入宽带账号！'
                        });
                        info.show();
                        setTimeout(function () {
                            info.close().remove();
                        }, 1500);
                        return false;
                    } else {
                        //loading事件
                        dialog({
                            id: 'result_info',
                            title: '解绑中，请稍后...',
                            width: 150,
                            quickClose: true
                        }).show();
                        $.ajax({
                            url: "<?php echo site_url('manager/bd_unbunding_action') ?>",
                            type: "POST",
                            data: {
                                db_id: db_id
                            },
                            dataType: "json",
                            success: function (msg) {
                                if (msg.result == true) {
                                    var success_info = dialog({
                                        content: '解绑成功！'
                                    });
                                    success_info.show();
                                    setTimeout(function () {
                                        success_info.close().remove();
                                    }, 3000);
                                } else {
                                    dialog.get('result_info').close();
                                    var err_msg = dialog({
                                        content: '解绑失败，请检查宽带账号是否正确！'
                                    });
                                    err_msg.show();
                                    setTimeout(function () {
                                        err_msg.close().remove();
                                    }, 3000);
                                    return false;
                                }
                                dialog.get('result_info').close();
                            },
                            error: function () {
                                dialog.get('result_info').close();
                                var d = dialog({
                                    content: '连接数据库错误，请稍后再试！'
                                });
                                d.show();
                                setTimeout(function () {
                                    d.close().remove();
                                }, 3000);
                            }
                        });
                    }
                },
                cancelValue: '取消',
                cancel: function () {
                }
            });
            d.showModal();
        });
    </script>

<?php require_once('common/footer.php'); ?>