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

    function group($group_id='???') {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $data['group_data'] = $this->Lagermodel->get_group_data_by_id($group_id);
        $data['persons'] = $this->Lagermodel->get_group_persons_by_id($group_id);
        $data['suggestions'] = $this->Lagermodel->get_person_suggestions($group_id, '=');
        $data['others'] = $this->Lagermodel->get_person_suggestions($group_id, '<>');
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
        $group_id = $this->input->post('group_id');
        $this->Lagermodel->add_persons($group_id, $this->input->post('persons'));
        redirect('admin/group/'.$group_id);
    }

    function add_existing_persons() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $group_id = $this->input->post('group_id');
        $this->Lagermodel->add_existing_persons($group_id, $this->input->post());
        redirect('admin/group/'.$group_id);
    }

    function add_other_person() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $group_id = $this->input->post('group_id');
        $this->Lagermodel->add_person($group_id, $this->input->post('other'));
        redirect('admin/group/'.$group_id);
    }

    function remove($group_id='???', $person_id='???') {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->remove_attendance($group_id, $person_id);
        redirect('admin/group/'.$group_id);
    }

    function remove_group_confirm($group_id='???') {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $data['group_data'] = $this->Lagermodel->get_group_data_by_id($group_id);
        $this->load->view('header');
        $this->load->view('admin/remove_group_confirm', $data);
        $this->load->view('footer');
    }

    function remove_group() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->remove_group($this->input->post('group_id'));
        redirect('admin');
    }

    function person($person_id='???', $group_id='???') {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $data['person_data'] = $this->Lagermodel->get_person_data($person_id);
        $data['group_id'] = $group_id;
        $this->load->view('header');
        $this->load->view('admin/person', $data);
        $this->load->view('footer');
    }

    function update_person() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->update_person($this->input->post('person_id'),
            $this->input->post('person_name'), $this->input->post('graduation'));
        redirect('admin/group/'.$this->input->post('group_id'));
    }

    function update_attendance() {
        if (!$this->logged_in()) {
            redirect('login');
        }
        $this->Lagermodel->update_photos($this->input->post('person_id'),
            $this->input->post('year'), $this->input->post('photo'),
            $this->input->post('photo_small'));
        $this->Lagermodel->update_role($this->input->post('person_id'),
            $this->input->post('group_id'), $this->input->post('role'));
        redirect('admin/group/'.$this->input->post('group_id'));
    }
}
?>
