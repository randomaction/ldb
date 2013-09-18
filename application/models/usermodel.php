<?php
class Usermodel extends CI_Model {

    function __construct()    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
    }

    function admin_exists() {
        $this->db->from('users')->where('username', 'admin');
        return $this->db->get()->num_rows() > 0;
    }

    function login_successful($username, $password) {
        $this->db->from('users')->where('username', $username);
        $query = $this->db->get();
        error_log('checking');
        if ($query->num_rows() == 0) {
        error_log('no users');
            return false;
        }
        $encoded = $query->row()->password;
        error_log($password);
        error_log($encoded);
        return crypt($password, $encoded) == $encoded;
    }

    function create_user($username, $password) {
        $this->db->insert('users', array('username' => $username, 'password' => crypt($password)));
    }

    function change_password($username, $password) {
        $this->db->where('username', $username)->update('users', array('password' => crypt($password)));
    }
}
?>
