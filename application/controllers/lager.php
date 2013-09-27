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
        $this->load->view('footer', array('link' => false));
    }

    function view($enc_year='', $enc_group_name='') {
        $year = urldecode($enc_year);
        $group_name = urldecode($enc_group_name);
        if ($group_name == '') {
            $data['year'] = $year;
            $data['group_data'] = $this->Lagermodel->get_groups($year);
            $data['groups'] = $this->Lagermodel->get_year($year);
        } else {
            $data['group'] = $this->Lagermodel->get_group_data($year, $group_name);
            $data['persons'] = $this->Lagermodel->get_group_persons($year, $group_name);
        }
        $this->load->view('header');
        $this->load->view($group_name == '' ? 'year' : 'group', $data);
        $this->load->view('footer');
    }

    function person($person_id='???', $group_id='???') {
        $data['person_data'] = $this->Lagermodel->get_person_data($person_id);
        $data['groups'] = $this->Lagermodel->get_person_groups($person_id);
        $data['current_group'] = $this->Lagermodel->find_group($data['groups'], $group_id);
        $this->load->view('header');
        $this->load->view('person', $data);
        $this->load->view('footer');
    }
}
?>
