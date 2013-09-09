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

    function get_person_data($id) {
        $this->db->from('persons')->where('person_id', $id);
        $query = $this->db->get();
        if ($query->num_rows == 0)
            return null;
        return $query->row();
    }

    static function cmp_by_name($a, $b) {
        return strnatcmp($a->name, $b->name);
    }

    function get_person_groups($id) {
        $this->db->from('groups')->
            join('attendances', 'groups.group_id = attendances.group_id')->
            where('attendances.person_id', $id);
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_groups'));
        return $result;
    }

    function get_ids_not_in_group($id) {
        $this->db->from('attendances')->where('group_id', $id);
        $already_in = array();
        foreach ($this->db->get()->result() as $row) {
            array_push($already_in, $row->person_id);
        }
        return $already_in;
    }

    function get_person_suggestions($id, $operator) {
        $grad = $this->get_group_default_graduation($id);
        $already_in = $this->get_ids_not_in_group($id);
        $this->db->from('persons')->where('graduation '.$operator, $grad);
        if (count($already_in) > 0)
            $this->db->where_not_in('person_id', $already_in);
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_by_name'));
        return $result;
    }

    function add_group($year, $name) {
        $this->db->insert('groups', array('year' => $year, 'name' => $name));
    }

    function add_persons($id, $persons) {
        $grad = $this->get_group_default_graduation($id);
        foreach(explode("\n", $persons) as $name) {
            if (strlen(trim($name)) == 0)
                continue;
            $this->db->insert('persons', array('name' => $name, 'graduation' => $grad));
            $this->db->insert('attendances', array('person_id' => $this->db->insert_id(), 'group_id' => $id));
        }
    }

    function add_existing_persons($id, $data) {
        foreach($data as $key => $value) {
            if (strcmp($value, 'add') == 0)
                $this->add_person($id, $key);
        }
    }

    function add_person($group_id, $id_string) {
        if (strcmp(substr($id_string, 0, 2), 'id') != 0)
            return;
        $person_id = substr($id_string, 2);
        $this->db->insert('attendances', array('person_id' => $person_id, 'group_id' => $group_id));
    }

    function clean_persons() {
        $this->db->select('persons.*')->from('persons')->
            join('attendances', 'persons.person_id = attendances.person_id', 'left')->
            where('attendances.group_id', null);
        $to_delete = array();
        foreach ($this->db->get()->result() as $row) {
           array_push($to_delete, $row->person_id);
        }
        if (count($to_delete) == 0) {
            return;
        }
        $this->db->from('persons')->where_in('person_id', $to_delete)->delete();
    }

    function remove_attendance($group_id, $person_id) {
        $this->db->from('attendances')->
            where(array('group_id' => $group_id, 'person_id' => $person_id))->delete();
        $this->clean_persons();
    }

    function remove_group($id) {
        $this->db->from('attendances')->where('group_id', $id)->delete();
        $this->db->from('groups')->where('group_id', $id)->delete();
        $this->clean_persons();
    }

    function update_person($id, $name, $graduation) {
        $this->db->where('person_id', $id)->
            update('persons', array('name' => $name, 'graduation' => $graduation));
    }

    function get_group_default_graduation($id) {
        $group_data = $this->get_group_data($id);
        return $this->get_default_graduation($group_data->year, $group_data->name);
    }

    function get_default_graduation($year, $name) {
        return $year + 12 - (int)$name;
    }
}
?>
