<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Login extends QW_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("Admin_model", "admin_model");
        $this->load->model("Logs_model", "log_model");
        $this->lang->load("user");
    }

    public function redircet()
    {
        $this->load->view('login/redircet');
    }

    public function login_admin()
    {
        $username = $this->input->post('username');
        if (!isset($username) && $this->is_logined_in() == FALSE) {
            $this->load->view("login/login_admin");
        } elseif (isset($username) && $this->is_logined_in() == FALSE) {
            $password = $this->input->post('password');
            $password = do_hash($password, 'md5');
            $result = $this->admin_model->get_admin($username, $password);
            if ($result != FALSE) {
                $data = array(
                    'user_id' => $result ['id'],
                    'username' => $result ['username'],
                    'role_code' => $result ['role_code'],
                    'login_in' => TRUE
                );
                $this->session->set_userdata($data);
                $this->save_login_info($result);
                $newinfo = array(
                    'last_login' => time()
                );
                $message_id = $this->admin_model->update_user($result ['id'], $newinfo);
            } else {
                $message_id = FALSE;
            }
            $infos = array('message_id' => $message_id);
            echo json_encode($infos, JSON_NUMERIC_CHECK);
        } else {
            redirect("manage/index");
        }
    }

    public function check_user($username)
    {
        $result = $this->admin_model->check_user($username);
        if ($result == FALSE) {
            $this->form_validation->set_message("check_user", $this->lang->line("invalid_username"));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_password($password)
    {
        $username = $this->input->post('username');
        $password = do_hash($password, 'md5');
        $result = $this->admin_model->check_password($username, $password);
        if ($result == FALSE) {
            $this->form_validation->set_message("check_password", $this->lang->line("invalid_password"));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /**
     * 登录日志
     * @param $result
     */
    function save_login_info($result)
    {
        $logs = array('username' => $result ['username'], 'logindate' => time(), 'loginip' => $this->input->ip_address(), 'useragent' => $this->input->user_agent(), 'state' => TRUE);
        $this->log_model->insert($logs);
    }

    function alter_password()
    {
        $this->load->view("admin/password");
    }

}

?>