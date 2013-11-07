<?php
class Lager extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Lagermodel');
    }

    function index() {
        $data['years'] = $this->Lagermodel->get_years();
        $this->load->view('header');
        $this->load->view('general', $data);
        $this->load->view('footer');
    }

    function everybody() {
        $data['persons'] = $this->Lagermodel->get_all_persons();
        $this->load->view('header');
        $this->load->view('everybody', $data);
        $this->load->view('footer');
    }

    function view($enc_year='', $enc_group_name='') {
        $year = urldecode($enc_year);
        $group_name = urldecode($enc_group_name);
        if ($group_name != '') {
            $this->_group($year, $group_name);
            return;
        }
        $data['year'] = $year;
        $data['group_data'] = $this->Lagermodel->get_groups($year);
        $data['groups'] = $this->Lagermodel->get_year($year);
        $this->load->view('header');
        $this->load->view('year', $data);
        $this->load->view('footer');
    }

    function _group($year, $group_name) {
        $data['group'] = $this->Lagermodel->get_group_data($year, $group_name);
        $this->load->view('header');
        $data['persons'] = $this->Lagermodel->get_group_persons($year, $group_name, true);
        $data['leads'] = true;
        $this->load->view('group', $data);
        $data['persons'] = $this->Lagermodel->get_group_persons($year, $group_name, false);
        $data['leads'] = false;
        $this->load->view('group', $data);
        $this->load->view('footer');
    }

    function person($person_id='', $enc_year='') {
        $year = urldecode($enc_year);
        $data['person_data'] = $this->Lagermodel->get_person_data($person_id);
        $data['groups'] = $this->Lagermodel->get_person_groups($person_id);
        $data['current_group'] = $this->Lagermodel->find_group($data['groups'], $year);
        $this->load->view('header');
        $this->load->view('person', $data);
        $this->load->view('footer');
    }
}
?>
