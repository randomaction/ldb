<?php
class Lagermodel extends CI_Model {

    function __construct()    {
        parent::__construct();
        $this->load->database();
    }

    function get_years() {
        $this->db->distinct()->select('year')->from('groups');
        return $this->db->get()->result();
    }

    function get_year($year) {
        $this->db->from('groups')->where('year', $year);
        $group_query = $this->db->get();

        foreach ($group_query->result() as $row) {
            $this->db->select('persons.*')->from('persons')->
                join('attendances', 'persons.person_id = attendances.person_id')->
                where('attendances.group_id', $row->group_id);
            $person_query = $this->db->get();
            $result[$row->name] = $person_query->result();
        }

        ksort($result, SORT_NATURAL);
        return $result;
    }

    function get_person_name($id) {
        $this->db->from('persons')->where('person_id', $id);
        return $this->db->get()->row()->name;
    }

    static function cmp_by_name($a, $b) {
        return strnatcmp($a->name, $b->name);
    }

    function get_person_groups($id) {
        $this->db->from('groups')->
            join('attendances', 'groups.group_id = attendances.group_id')->
            where('attendances.person_id', $id);
        $result = $this->db->get()->result();
        usort($result, array("Lagermodel", "cmp_by_name"));
        return $result;
    }
}
?>
