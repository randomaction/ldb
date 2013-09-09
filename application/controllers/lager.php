<?php
class Lager extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Lagermodel');
    }

    function index() {
        $data['years'] = $this->Lagermodel->get_years();
        $this->load->view('header');
        $this->load->view('general', $data);
        $this->load->view('footer', array('link' => false));
    }

    function year($year='???') {
        $data['year'] = $year;
        $data['groups'] = $this->Lagermodel->get_year($year);
        $this->load->view('header');
        $this->load->view('year', $data);
        $this->load->view('footer');
    }

    function person($id='???') {
        $data['person_data'] = $this->Lagermodel->get_person_data($id);
        $data['groups'] = $this->Lagermodel->get_person_groups($id);
        $this->load->view('header');
        $this->load->view('person', $data);
        $this->load->view('footer');
    }
}
?>
