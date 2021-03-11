<?php

function pre($data, $exit = false) {
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if ($exit) {
        exit();
    }
}

function authentication($return = true) {
    $ci = & get_instance();
    $user = $ci->session->userdata('user_data');
    if (empty($user) && $return) {
        redirect(base_url());
    } else {
        return $user;
    }
}

function createUsername($username, $users, $ind = 1) {
    if (empty($username) || empty($users)) {
        return $username;
    }

    $username1 = explode('-', $users[0]);
    $username1 = (int) end($username1);
    $username_old = $username;

    if ($username1 > 0) {
        $username .= '-' . ++$username1;
    } else {
        $username .= '-' . $ind;
    }

    array_shift($users);

    if (in_array($username, $users)) {
        $username = createUsername($username_old, $users, ++$ind);
    }

    return $username;
}

function folderCheck($dirs) {
    if (empty($dirs)) {
        return true;
    }

    $parent_dir = '';

    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $dirs = explode('\\', $dirs);
    } else {
        $dirs = explode('/', $dirs);
    }

    $create = false;

    foreach ($dirs as $dir) {
        if ($dir == 'upload') {
            $create = true;
        }
        if (!is_dir($parent_dir . $dir) && $create && !empty($dir) && !empty($parent_dir)) {
            $old = umask(0);
            mkdir($parent_dir . $dir, 0777);
            umask($old);
        }
        $parent_dir .= $dir . '/';
    }

    return true;
}

function dateDiff($req_date) {
    $date1 = date_create(date('Y-m-d'));
    $date2 = date_create(date('Y-m-d', $req_date));
    $date = date_diff($date1, $date2);
    $output = '';

    if ($date->y > 0) {
        $output = $date->y . ' year ';
    }

    if ($date->m > 0) {
        $output .= $date->m . ' month ';
    }

    if (($date->y == 0 || $date->m == 0) && $date->d > 0) {
        $output .= $date->d . ' day ';
    }

    if (($date->y == 0 && $date->m == 0) && $date->h > 0) {
        $output .= $date->h . ' hour ';
    }

    if (($date->y == 0 && $date->m == 0 && $date->d == 0) && $date->i > 0) {
        $output .= $date->i . ' hour ';
    }

    if (($date->y == 0 && $date->m == 0 && $date->d == 0 && $date->i == 0) && $date->s > 0) {
        $output .= $date->s . ' second ';
    }

    if (!empty($output)) {
        $output = trim($output) . 's ago';
    } else {
        $output = 'Just now';
    }

    return $output;
}

function superAdmin() {
    $ci = & get_instance();
    $ci->db->select('ug.user_id');
    $ci->db->from('users_groups ug');
    $ci->db->join('groups g', 'ug.group_id = g.id');
    $ci->db->where('g.name', 'superadmin');
    $query = $ci->db->get();
    $result = $query->row();

    if (!empty($result)) {
        return $query->row()->user_id;
    }
}

function getUser($id) {
    $ci = & get_instance();
    $ci->db->select('id, email, first_name, last_name, type, active');
    $ci->db->from('users');
    $ci->db->where('id', $id);
    $query = $ci->db->get();
    return $query->row();
}

function dbInsert($table, $fields) {
    if (!empty($table) && !empty($fields)) {
        $ci = & get_instance();
        $ci->db->insert($table, $fields);
    }
}

function dbDelete($table, $where) {
    if (!empty($table)) {
        $ci = & get_instance();
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $ci->db->where($k, $value);
            }
        }

        $ci->db->delete($table);
    }
}

function getSocialLinks() {
    $ci = & get_instance();
    $ci->db->select('id, name, type, value');
    $ci->db->from('sociallinks');
    $ci->db->where('status', 1);
    $query = $ci->db->get();
    return $query->result();
}

function validEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

function getAdmin() {
    $ci = & get_instance();
    $ci->db->select('u.*');
    $ci->db->from('users u');
    $ci->db->where('id', 1);
//    $ci->db->where('type', ADMIN);
    $ci->db->order_by('created_date', 'DESC');
    $query = $ci->db->get();
    return $query->result();
}

function getSettingData() {
    $ci = & get_instance();
    $ci->db->select('*');
    $ci->db->from('setting');
    $query = $ci->db->get();
    $result = $query->result();
    return (!empty($result)) ? $result[0] : array();
}

function checkEmail($email) {
    $ci = & get_instance();
    $ci->db->select('u.id');
    $ci->db->from('users u');
    $ci->db->where('u.email', $email);
    $query = $ci->db->get();
    return $query->row();
}

function getBreadCrumb() {
    $output = '';
    $urls = explode('/', $_SERVER['REQUEST_URI']);

    if (!empty($urls)) {
        $parent = '';
        $black_list = array('booking-management', '~mywork', 'user', SELLER, 'report', 'dashboard', 'business', 'detail');
        $parent_exist = array('user', SELLER, 'report', 'business');
        $is_detail = false;
        foreach ($urls as $value) {
            if ($value == 'detail') {
                $is_detail = true;
            }
            if (in_array($value, $parent_exist)) {
                $parent .= $value . '/';
            }
            if (empty($value) || in_array($value, $black_list) || $is_detail) {
                continue;
            }

            $output .= ' > <a href="' . base_url($parent . $value) . '">' . ucfirst($value) . '</a>';
            $parent .= $value . '/';
        }
    }

    if (!empty($output)) {
        if (!empty(authentication(false))) {
            $output = '<a href="' . base_url('user/dashboard') . '">Dashboard</a>' . $output;
        } else {
            $output = '<a href="' . base_url() . '">Home</a>' . $output;
        }
    }

    return $output;
}

function getAdminStripe() {
    $admin = getAdmin();
    $ci = & get_instance();
    $ci->db->select('secret_key, publish_key');
    $ci->db->from('stripe_details');
    $ci->db->where('user_id', $admin[0]->id);
    $query = $ci->db->get();
    return $query->row();
}

function getMenuLinks() {
    /* $ci = & get_instance();
      $ci->db->select('ml.menu_name, mli.*');
      $ci->db->from('menu_list ml');
      $ci->db->join('menu_list_items mli', 'mli.menu_id = ml.id');
      $ci->db->where('ml.status', 1);
      $ci->db->where('mli.status', 1);
      $ci->db->order_by('ml.position');
      $ci->db->order_by('mli.position');
      $query = $ci->db->get();

      return $query->result();
     */
    $arr = array();
    return $arr;
}

function name_to_url($name) {
    return str_replace(["'", "/", " ", ",", "_"], '-', $name);
}

function url_to_name($url) {
    return str_replace(["-"], ' ', $url);
}

function get_rating_btn_color($rating = 0) {
    if ($rating > 2) {
        return 'success';
    } elseif ($rating == 2) {
        return 'warning';
    } else {
        return 'danger';
    }
}

function upload_image($tmp_name, $path, $imgName) {

    $upload_dir = UPLOADDIR . $path;
    folderCheck($upload_dir);

    move_uploaded_file($tmp_name, "$upload_dir/$imgName");
}

function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

function formatOutput($ls_inputString) {
    $ls_inputString = stripcslashes(trim($ls_inputString));
    return $ls_inputString;
}
