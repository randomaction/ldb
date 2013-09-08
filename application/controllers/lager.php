<?php
class Lager extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Lagermodel');
    }

    function index() {
        $data['years'] = $this->Lagermodel->get_years();
        $this->load->view('general', $data);
    }

    function year($year='???') {
        $data['year'] = $year;
        $data['groups'] = $this->Lagermodel->get_year($year);
        $this->load->view('year', $data);
    }

    function person($id='???') {
        $data['name'] = $this->Lagermodel->get_person_name($id);
        $data['groups'] = $this->Lagermodel->get_person_groups($id);
        $this->load->view('person', $data);
    }
}
?>
