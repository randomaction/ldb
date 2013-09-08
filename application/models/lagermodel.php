<?php
class Lagermodel extends CI_Model {

    function __construct()    {
        parent::__construct();
        $this->load->database();
    }

    function get_year($year) {
        $this->db->select('persons.name')->from('persons')->
            join('attendances', 'persons.person_id = attendances.person_id')->
            join('groups', 'attendances.group_id = groups.group_id')->
            where('groups.year', $year);
        $query = $this->db->get();
        return $query->result();
    }
}
?>
