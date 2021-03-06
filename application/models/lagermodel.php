<?php
class Lagermodel extends CI_Model {

    function __construct()    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->default_url = base_url('media/the_son_of_atom.jpg');
    }

    function get_years() {
        $this->db->distinct()->select('year')->from('groups')->order_by('year', 'desc');
        return $this->db->get()->result();
    }

    function get_year($year) {
        $result = array();
        $this->db->from('groups')->where('year', $year);
        $group_query = $this->db->get();

        foreach ($group_query->result() as $row) {
            $result['persons'][$row->group_name] = $this->get_group_persons($year, $row->group_name, false);
            $result['leads'][$row->group_name] = $this->get_group_persons($year, $row->group_name, true);
        }

        ksort($result, SORT_NATURAL);
        return $result;
    }

    function get_group_data($year, $group_name) {
        $this->db->from('groups')->where('year', $year)->where('group_name', $group_name);
        return $this->db->get()->row();
    }

    function get_group_data_by_id($group_id) {
        $this->db->from('groups')->where('group_id', $group_id);
        return $this->db->get()->row();
    }

    function get_all_persons() {
        $this->db->from('persons');
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_by_name'));
        return $result;
    }

    function select_persons_from_group($with_role) {
        $columns = 'persons.person_id, persons.person_name, photos.photo, photos.photo_small, attendances.role';
        $this->db->select($columns)->from('persons')->
            join('attendances', 'persons.person_id = attendances.person_id')->
            join('groups', 'groups.group_id = attendances.group_id')->
            join('photos', 'persons.person_id = photos.person_id and {PRE}groups.year = {PRE}photos.year', 'left');
            $this->db->where('attendances.role is '.($with_role ? 'not ' : '').'null');
    }

    function get_group_persons($year, $group_name, $with_role) {
        $this->select_persons_from_group($with_role);
        $this->db->where('groups.year', $year)->where('groups.group_name', $group_name);
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_by_name'));
        return $result;
    }

    function get_group_persons_by_id($group_id, $with_role) {
        $this->select_persons_from_group($with_role);
        $this->db->where('attendances.group_id', $group_id);
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_by_name'));
        return $result;
    }

    static function cmp_groups($a, $b) {
        $names = strnatcmp($a->year, $b->year);
        if ($names != 0)
            return $names;
        return strnatcmp($a->group_name, $b->group_name);
    }

    function get_groups($year='all') {
        $this->db->from('groups');
        if (strcmp($year, 'all') != 0) {
            $this->db->where('year', $year);
        }
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_groups'));
        return $result;
    }

    function get_person_data($person_id) {
        $this->db->from('persons')->where('person_id', $person_id);
        $query = $this->db->get();
        if ($query->num_rows() == 0)
            return null;
        return $query->row();
    }

    static function cmp_by_name($a, $b) {
        $name_a = str_replace("ё", "е", str_replace("Ё", "Е", $a->person_name));
        $name_b = str_replace("ё", "е", str_replace("Ё", "Е", $b->person_name));
        return strnatcmp($name_a, $name_b);
    }

    function get_person_groups($person_id) {
        $columns = 'groups.group_id, groups.year, groups.group_name, photos.photo, attendances.role';
        $this->db->select($columns)->from('groups')->
            join('attendances', 'groups.group_id = attendances.group_id')->
            join('photos', 'attendances.person_id = photos.person_id and {PRE}groups.year = {PRE}photos.year', 'left')->
            where('attendances.person_id', $person_id);
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_groups'));
        return $result;
    }

    function find_group($groups, $year) {
        foreach ($groups as $group) {
            if ($group->year == $year) {
                return $group;
            }
        }
        return null;
    }

    function get_ids_not_in_group($group_id) {
        $this->db->from('attendances')->where('group_id', $group_id);
        $already_in = array();
        foreach ($this->db->get()->result() as $row) {
            array_push($already_in, $row->person_id);
        }
        return $already_in;
    }

    function get_person_suggestions($group_id, $operator) {
        $grad = $this->get_group_default_graduation($group_id);
        $already_in = $this->get_ids_not_in_group($group_id);
        $this->db->from('persons')->where('graduation '.$operator, $grad);
        if (count($already_in) > 0)
            $this->db->where_not_in('person_id', $already_in);
        $result = $this->db->get()->result();
        usort($result, array('Lagermodel', 'cmp_by_name'));
        return $result;
    }

    function add_group($year, $group_name) {
        $this->db->insert('groups', array('year' => $year, 'group_name' => $group_name));
    }

    function add_persons($group_id, $persons) {
        $grad = $this->get_group_default_graduation($group_id);
        foreach(explode("\n", $persons) as $person_name) {
            if (strlen(trim($person_name)) == 0)
                continue;
            $this->db->insert('persons', array('person_name' => $person_name, 'graduation' => $grad));
            $this->db->insert('attendances', array('person_id' => $this->db->insert_id(), 'group_id' => $group_id));
        }
    }

    function add_existing_persons($group_id, $data) {
        foreach($data as $key => $value) {
            if (strcmp($value, 'add') == 0) {
                $this->add_person($group_id, $key);
            }
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

    function remove_group($group_id) {
        $this->db->from('attendances')->where('group_id', $group_id)->delete();
        $this->db->from('groups')->where('group_id', $group_id)->delete();
        $this->clean_persons();
    }

    function update_person($person_id, $person_name, $graduation) {
        $this->db->where('person_id', $person_id)->
            update('persons', array('person_name' => $person_name, 'graduation' => $graduation));
    }

    function get_group_default_graduation($group_id) {
        $group_data = $this->get_group_data_by_id($group_id);
        return $this->get_default_graduation($group_data->year, $group_data->group_name);
    }

    function get_default_graduation($year, $group_name) {
        return $year + 12 - (int)$group_name;
    }

    function update_photos($person_id, $year, $photo_raw, $photo_small_raw) {
        $photo = $this->null_if_empty($photo_raw);
        $photo_small = $this->null_if_empty($photo_small_raw);
        if ($photo == null && $photo_small == null) {
            $this->db->where('person_id', $person_id)->where('year', $year)->delete('photos');
            return;
        }
        $this->db->from('photos')->where('person_id', $person_id)->where('year', $year);
        if ($this->db->get()->num_rows() == 0) {
            $this->db->insert('photos',
                array('person_id' => $person_id, 'year' => $year, 'photo' => $photo, 'photo_small' => $photo_small));
        } else {
        $this->db->where('person_id', $person_id)->where('year', $year)->
            update('photos', array('photo' => $photo, 'photo_small' => $photo_small));
        }
    }

    function update_role($person_id, $group_id, $role_raw) {
        $role = $this->null_if_empty($role_raw);
        $this->db->where('person_id', $person_id)->where('group_id', $group_id)->
            update('attendances', array('role' => $role));
    }

    function replace_url($url) {
       return $url == null ? $this->default_url : $url;
    }

    function null_if_empty($string) {
        return $string == '' ? null : $string;
    }
}
?>
