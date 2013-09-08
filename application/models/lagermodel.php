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
        $result = array();
        $this->db->from('groups')->where('year', $year);
        $group_query = $this->db->get();

        foreach ($group_query->result() as $row) {
            $result[$row->name] = $this->get_group_persons($row->group_id);
        }

        ksort($result, SORT_NATURAL);
        return $result;
    }

    function get_group_data($id) {
        $this->db->from('groups')->where('group_id', $id);
        return $this->db->get()->row();
    }

    function get_group_persons($id) {
        $this->db->select('persons.*')->from('persons')->
            join('attendances', 'persons.person_id = attendances.person_id')->
            where('attendances.group_id', $id);
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_by_name'));
        return $result;
    }

    static function cmp_groups($a, $b) {
        $names = strnatcmp($a->year, $b->year);
        if ($names != 0)
            return $names;
        return strnatcmp($a->name, $b->name);
    }

    function get_groups() {
        $this->db->from('groups');
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_groups'));
        return $result;
    }

    function get_person_name($id) {
        $this->db->from('persons')->where('person_id', $id);
        $query = $this->db->get();
        if ($query->num_rows == 0)
            return '';
        return $query->row()->name;
    }

    static function cmp_by_name($a, $b) {
        return strnatcmp($a->name, $b->name);
    }

    function get_person_groups($id) {
        $this->db->from('groups')->
            join('attendances', 'groups.group_id = attendances.group_id')->
            where('attendances.person_id', $id);
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_by_name'));
        return $result;
    }

    function add_group($year, $name) {
        $this->db->insert('groups', array('year' => $year, 'name' => $name));
    }

    function add_persons($id, $persons) {
        foreach(explode("\n", $persons) as $name) {
            if (strlen(trim($name)) == 0)
                continue;
            $this->db->insert('persons', array('name' => $name));
            $this->db->insert('attendances', array('person_id' => $this->db->insert_id(), 'group_id' => $id));
        }
    }
}
?>
