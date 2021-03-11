<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function getSettings() {
        $query = $this->db->get('setting');
        $result = $query->result();
        return $result;
    }

    function insert($table, $data) {
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function getUser($where, $order_by = array(), $like_where = array(), $all_row = true) {
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }
        if (!empty($like_where)) {
            foreach ($like_where as $value) {
                $this->db->like($value['field'], $value['search'], $value['wildcard']);
            }
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by['field'], $order_by['order']);
        }

        $query = $this->db->get('users');

        if ($all_row) {
            $result = $query->result();
        } else {
            $result = $query->row();
        }
        return $result;
    }

    function update($table, $data, $where) {
        foreach ($where as $k => $value) {
            $this->db->where($k, $value);
        }
        $this->db->update($table, $data);
    }

    function from_validation_resgistration() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'First name', 'required', array('required' => '<span class="help-block form-error">First Name is a required field</span>')
        );
        
        $this->form_validation->set_rules('last_name', 'Last name', 'required', array('required' => '<span class="help-block form-error">Last Name is a required field</span>')
        );

        // $this->form_validation->set_rules('last_name', 'Last name', 'required',
        //     array('required'=>'<span class="help-block form-error">This is a required field</span>')
        // );

        $this->form_validation->set_rules('email', 'Email Address', 'required', array('required' => '<span class="help-block form-error">Email is a required field</span>')
        );

        /* $this->form_validation->set_rules('phone', 'Phone Number', 'required',
          array('required'=>'<span class="help-block form-error">This is a required field</span>')
          ); */

        $this->form_validation->set_rules('user_type', 'User Type', 'required', array('required' => '<span class="help-block form-error">User Type is a required field</span>')
        );

        $this->form_validation->set_rules('password', 'Password', 'required|md5|min_length[6]', array("required" => '<span class="help-block form-error">Password is a required field</span>')
        );
        /*
          $this->form_validation->set_rules('terms', 'Terms and conditions', 'required',
          array('required'=>'<span class="help-block form-error">Please accept terms and conditions</span>')
          );
         */
        // $this->form_validation->set_rules('privacy', 'Privacy policy', 'required',
        //     array('required'=>'<span class="help-block form-error">Please accept privacy policy</span>')
        // );

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function from_validation_login() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('email', 'email', 'trim|required', array('required' => '<span class="help-block login_error alert-danger">Please submit your email.</span>')
        );

        $this->form_validation->set_rules('password', 'password', 'required|md5|min_length[6]', array('required' => '<span class="help-block login_error alert-danger">Please submit your password.</span>')
        );

        if ($this->form_validation->run() == FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function send_mail($toEmail, $subject, $body) {
        $config = array(
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'priority' => '1'
        );
        $this->email->initialize($config);
        $this->email->from(SITE_EMAIL, SITE_NAME);
        $this->email->to($toEmail);
        $this->email->subject(SITE_NAME . ": $subject");
        $this->email->message($body);
        @$this->email->send();
    }

    function save_notification($la_notification = []) {
        $la_notification['is_view'] = 'N';
        $la_notification['created_at'] = date('Y-m-d H:i:s');
        $la_notification['status'] = 'Ar';
        $this->insert('notification', $la_notification);
    }

}
