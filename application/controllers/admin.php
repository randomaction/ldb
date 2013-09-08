<?php
class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Lagermodel');
    }

    function index() {
        $data['groups'] = $this->Lagermodel->get_groups();
        $this->load->view('header');
        $this->load->view('admin/groups', $data);
        $this->load->view('admin/add_group');
        $this->load->view('admin/footer', array('link' => false));
    }

    function add_group() {
        $this->Lagermodel->add_group($this->input->post('year'), $this->input->post('name'));
        $this->index();
    }

    function group($id='???') {
        $data['group_data'] = $this->Lagermodel->get_group_data($id);
        $data['persons'] = $this->Lagermodel->get_group_persons($id);
        $this->load->view('header');
        $this->load->view('admin/group', $data);
        $this->load->view('admin/add_persons', $data);
        $this->load->view('admin/footer');
    }

    function add_persons() {
        $id = $this->input->post('group_id');
        $this->Lagermodel->add_persons($id, $this->input->post('persons'));
        $this->group($id);
    }

    function person($id='???') {
        $data['name'] = $this->Lagermodel->get_person_name($id);
        $data['groups'] = $this->Lagermodel->get_person_groups($id);
        $this->load->view('header');
        $this->load->view('person', $data);
        $this->load->view('footer');
    }
}
?>
