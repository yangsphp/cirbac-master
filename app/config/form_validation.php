<?php
//if (!defined('BASEPATH')) exit ('No direct script access allowed');

$config = array(
    'role_rules' => array(
        array(
            'field' => 'post[name]',
            'label' => '名称',
            'rules' => 'required',
            'errors' => array("required" => "请输入角色%s")
        )
    ),
    'login_admin' => array(
        array(
            'field' => 'username',
            'label' => 'lang:登陆账号',
            'rules' => 'trim|required|min_length[2]|max_length[30]|callback_check_user',
        ),
        array(
            'field' => 'password',
            'label' => 'lang:密码',
            'rules' => 'trim|required|min_length[6]|callback_check_password',
        ),
    ),
    'login_user' => array(
        array(
            'field' => 'username',
            'label' => 'lang:form_username',
            'rules' => 'trim|required|min_length[5]|max_length[30]|callback_check_user|xss_clean',
        ),
        array(
            'field' => 'password',
            'label' => 'lang:form_password',
            'rules' => 'trim|required|min_length[6]|callback_check_password|xss_clean',
        ),
    )
);

?>
