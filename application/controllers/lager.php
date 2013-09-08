<?php
class Lager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Lagermodel');
    }

    public function index() {
        $this->year('2013');
    }

    public function year($year='???') {
        $data['year'] = $year;
        $data['groups'] = $this->Lagermodel->get_year($year);

        $this->load->view('year', $data);
    }
}
?>
