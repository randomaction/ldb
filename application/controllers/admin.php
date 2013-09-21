<?php
class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Lagermodel');
        $this->load->helper('url');
        $this->load->library('session');
    }

    private function logged_in() {
        return $this->session->userdata('username') != null;
    }

    function index() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $data['groups'] = $this->Lagermodel->get_groups();
        $this->load->view('header');
        $this->load->view('admin/groups', $data);
        $this->load->view('admin/add_group');
        $this->load->view('footer');
    }

    function add_group() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->add_group($this->input->post('year'), $this->input->post('group_name'));
        redirect('admin');
    }

    function group($id='???') {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $data['group_data'] = $this->Lagermodel->get_group_data($id);
        $data['persons'] = $this->Lagermodel->get_group_persons($id);
        $data['suggestions'] = $this->Lagermodel->get_person_suggestions($id, '=');
        $data['others'] = $this->Lagermodel->get_person_suggestions($id, '<>');
        $this->load->view('header');
        $this->load->view('admin/group', $data);
        $this->load->view('admin/person_suggestions', $data);
        $this->load->view('admin/other_persons', $data);
        $this->load->view('admin/add_persons', $data);
        $this->load->view('footer');
    }

    function add_persons() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $id = $this->input->post('group_id');
        $this->Lagermodel->add_persons($id, $this->input->post('persons'));
        redirect('admin/group/'.$id);
    }

    function add_existing_persons() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $id = $this->input->post('group_id');
        $this->Lagermodel->add_existing_persons($id, $this->input->post());
        redirect('admin/group/'.$id);
    }

    function add_other_person() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $id = $this->input->post('group_id');
        $this->Lagermodel->add_person($id, $this->input->post('other'));
        redirect('admin/group/'.$id);
    }

    function remove($group_id='???', $person_id='???') {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->remove_attendance($group_id, $person_id);
        redirect('admin/group/'.$group_id);
    }

    function remove_group_confirm($id='???') {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $data['group_data'] = $this->Lagermodel->get_group_data($id);
        $this->load->view('header');
        $this->load->view('admin/remove_group_confirm', $data);
        $this->load->view('footer');
    }

    function remove_group() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->remove_group($this->input->post('id'));
        redirect('admin');
    }

    function person($id='???', $group_id='???') {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $data['person_data'] = $this->Lagermodel->get_person_data($id);
        $data['group_id'] = $group_id;
        $this->load->view('header');
        $this->load->view('admin/person', $data);
        $this->load->view('footer');
    }

    function update_person() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->update_person($this->input->post('id'),
            $this->input->post('person_name'), $this->input->post('graduation'));
        redirect('admin/group/'.$this->input->post('group_id'));
    }

    function update_photos() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->update_photos($this->input->post('person_id'),
            $this->input->post('year'), $this->input->post('image'),
            $this->input->post('image_small'));
        redirect('admin/group/'.$this->input->post('group_id'));
    }
}
?>
