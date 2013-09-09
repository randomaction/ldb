<?php
class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Lagermodel');
        $this->load->helper('url');
    }

    function index() {
        $data['groups'] = $this->Lagermodel->get_groups();
        $this->load->view('header');
        $this->load->view('admin/groups', $data);
        $this->load->view('admin/add_group');
        $this->load->view('footer');
    }

    function add_group() {
        $this->Lagermodel->add_group($this->input->post('year'), $this->input->post('name'));
        redirect('admin');
    }

    function group($id='???') {
        $data['group_data'] = $this->Lagermodel->get_group_data($id);
        $data['persons'] = $this->Lagermodel->get_group_persons($id);
        $data['suggestions'] = $this->Lagermodel->get_person_suggestions($id, '=');
        $data['others'] = $this->Lagermodel->get_person_suggestions($id, '<>');
        $this->load->view('header');
        $this->load->view('admin/group', $data);
        $this->load->view('admin/person_suggestions', $data);
        $this->load->view('admin/other_persons', $data);
        $this->load->view('admin/add_persons', $data);
        $this->load->view('footer', array('admin' => true));
    }

    function add_persons() {
        $id = $this->input->post('group_id');
        $this->Lagermodel->add_persons($id, $this->input->post('persons'));
        redirect('admin/group/'.$id);
    }

    function add_existing_persons() {
        $id = $this->input->post('group_id');
        $this->Lagermodel->add_existing_persons($id, $this->input->post());
        redirect('admin/group/'.$id);
    }

    function add_other_person() {
        $id = $this->input->post('group_id');
        $this->Lagermodel->add_person($id, $this->input->post('other'));
        redirect('admin/group/'.$id);
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
