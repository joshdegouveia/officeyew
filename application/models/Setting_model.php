<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Setting_model extends CI_model {
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    function get() {
        $query = $this->db->get('setting');
        return $query->row();
    }
    function update($data) {
        $this->db->where('id', 1);
        $this->db->update('setting', $data);
    }
}
