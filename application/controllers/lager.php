<?php
class Lager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lagermodel');
    }

    public function index() {
        $data['years'] = $this->Lagermodel->get_years();
        $this->load->view('general', $data);
    }

    public function year($year='???') {
        $data['year'] = $year;
        $data['groups'] = $this->Lagermodel->get_year($year);
        $this->load->view('year', $data);
    }
}
?>
