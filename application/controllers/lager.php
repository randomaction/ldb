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
        $data['group_data'] = $this->Lagermodel->get_groups($year);
        $data['groups'] = $this->Lagermodel->get_year($year);
        $this->load->view('header');
        $this->load->view('year', $data);
        $this->load->view('footer');
    }

    function group($id='???') {
        $data['group'] = $this->Lagermodel->get_group_data($id);
        $data['persons'] = $this->Lagermodel->get_group_persons($id);
        $data['images'] = $this->Lagermodel->get_group_photos($id, 'image_small', true);
        $this->load->view('header');
        $this->load->view('group', $data);
        $this->load->view('footer');
    }

    function person($id='???', $group_id='???') {
        $data['person_data'] = $this->Lagermodel->get_person_data($id);
        $data['current_group'] = $this->Lagermodel->get_group_data($group_id);
        $data['groups'] = $this->Lagermodel->get_person_groups($id);
        $data['image'] = $this->Lagermodel->get_photo($id, $group_id);
        $this->load->view('header');
        $this->load->view('person', $data);
        $this->load->view('footer');
    }
}
?>
