<?php
class Login extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Usermodel');
        $this->load->library('session');
        $this->load->helper('url');
    }

    function index() {
        $this->load->view('header');
        $this->load->view('user/login');
        $this->load->view('footer');
    }

    function create() {
        $this->load->view('header');
        $this->load->view('user/create');
        $this->load->view('footer');
    }

    function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    function login_action() {
        $username = $this->input->post('username');
        if ($this->Usermodel->login_successful($username, $this->input->post('password'))) {
            $this->session->set_userdata('username', $username);
            redirect('admin');
        } else {
            redirect('login');
        }
    }

    function create_action() {
        $new_username = $this->input->post('username');
        $password = $this->input->post('password');
        $current_username = $this->session->userdata('username');
        if ($current_username != null && $new_username == $current_username) {
            error_log('change password');
            $this->Usermodel->change_password($current_username, $password);
            redirect('login');
        } else if (!$this->Usermodel->admin_exists() || $current_username == 'admin') {
            error_log('create user');
            $this->Usermodel->create_user($new_username, $password);
            redirect('login');
        } else {
            error_log('create failed');
            redirect('login/create');
        }
    }
}
?>
