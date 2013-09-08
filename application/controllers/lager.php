<?php
class Lager extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        $this->year('2013');
    }

    public function year($year='???') {
        $data['year'] = $year;

        $this->db->select('persons.name')->from('persons')->
            join('attendances', 'persons.person_id = attendances.person_id')->
            join('groups', 'attendances.group_id = groups.group_id')->
            where('groups.year', $year);
        $query = $this->db->get();

        $data['persons'] = $query->result();

        $this->load->view('year', $data);
    }
}
?>
