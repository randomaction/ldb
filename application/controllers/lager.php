<?php
class Lager extends CI_Controller {

    public function index() {
        $this->year('2013');
    }

    public function year($year='???') {
        $data['year'] = $year;
        $data['persons']= array();

        if ($year == '2012') {
            $data['persons'] = array('Люлина', 'Максакова');
        }
        if ($year == '2013') {
            $data['persons'] = array('Портянкин', 'Буренёв', 'Семёнов');
        }

        $this->load->view('year', $data);
    }
}
?>
