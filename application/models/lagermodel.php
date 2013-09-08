<?php
class Lagermodel extends CI_Model {

    function __construct()    {
        parent::__construct();
        $this->load->database();
    }

    function get_year($year) {
        $result = array();
        $this->db->from('groups')->where('year', $year);
        $group_query = $this->db->get();

        foreach ($group_query->result() as $row) {
            $this->db->select('persons.name')->from('persons')->
                join('attendances', 'persons.person_id = attendances.person_id')->
                where('attendances.group_id', $row->group_id);
            $person_query = $this->db->get();
            $result[$row->name] = $person_query->result();
        }

        ksort($result, SORT_NATURAL);
        return $result;
    }
}
?>
