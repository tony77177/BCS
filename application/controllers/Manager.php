<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * Created by PhpStorm.
 * User: TONY
 * Date: 2016-12-9
 * Time: 21:38
 */
class Manager extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->admin_model->auth_check();
        $this->load->library('Common_class');
    }

    /**
     * 首页信息加载
     */
    public function index()
    {

        //加载首页数量
        $data = array(
            "welcome_info" => '欢迎使用宽带查询系统！'
        );
        $this->load->view('index', $data);
    }

    /**
     * 宽带解绑页
     */
    public function bd_unbunding()
    {
        $this->load->view('bd_unbunding');
    }



    /**
     * 单一宽带账号解绑操作
     */
    public function bd_unbunding_action()
    {
        $db_id = $this->input->post('db_id', TRUE);

        $data = array(
            'cardno' => $db_id,
            'type' => '3',
            'regionId' => '2',
            'ooperator' => '',
            'passWord' => ''
        );

        $result_info = json_decode($this->common_class->curl_request($this->config->config['unbunding_path'], $data));

        if ($result_info->resultDesc == '') {
            echo json_encode(array(
                "result" => false
            ), JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(array(
                "result" => true
            ), JSON_UNESCAPED_UNICODE);
        }

    }

}