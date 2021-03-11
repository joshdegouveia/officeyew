<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insertUser($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    function getUsersIndex($userType = 'members') {
        if ($userType == 'members') {
            $this->db->select('*')
                    ->from('users')
                    ->where('type', 'member');
            $query = $this->db->get();
        }
        //echo $this->db->last_query() ;exit ;

        return $query->result();
    }

    function getUsersTotal($userType = 'all') {
        $this->db->select('id')
                ->from('users')
                // ->where('type', 'member')
                ->where('active', '1');
        $query = $this->db->get();

        return $query->num_rows();
    }

    /**
     * Fetch user row
     *
     * @param number $id
     *
     * @return array
     */
    function getUsersDetails($req, $where = array(), $join_all = false) {
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }

        $this->db->from('users u');

        if ($join_all) {
            $this->db->join('user_data ud', 'ud.user_id = u.id', 'left');
            $this->db->select('u.id AS uid, u.*, ud.*');
        }

        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Update user row
     *
     * @param number $id
     *
     * @return void
     */
    function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

	function resumeupdate($id, $data) {
		$la_candidate_details = $this->get_candidate_data($id, 'candidate');
		$data['modified_date'] = time();
		if(empty($la_candidate_details)){
			$data['created_date'] = time();
			$data['userid'] = $id;
			$this->db->insert('users_candidate_details', $data);
			$li_candId = $this->db->insert_id();
		}else{
			$returnData = $this->updateData('users_candidate_details', ['details_id' => $la_candidate_details[0]->details_id], $data);
			$li_candId = $la_candidate_details[0]->details_id;
		}
		return $li_candId;
	}

	function upload_stripe_document($id, $data){
		$check_details = $this->get_stripe_details($id);
		$data['refresh_date'] = time();
		if(empty($check_details)){
			$data['created_date'] = time();
			$data['userid'] = $id;
			$this->db->insert('users_payment_details', $data);
			$li_candId = $this->db->insert_id();
		}else{
			$li_candId = $this->updateData('users_payment_details', ['userid' => $check_details[0]->userid], $data);

		}
		return $li_candId;
	}

	function upload_account_details($id, $data){
		$check_details = $this->get_stripe_details($id);
		$data['refresh_date'] = time();
		if(empty($check_details)){
			$data['created_date'] = time();
			$data['userid'] = $id;
			$this->db->insert('users_payment_details', $data);
			$li_candId = $this->db->insert_id();
		}else{
			$li_candId = $this->updateData('users_payment_details', ['userid' => $check_details[0]->userid], $data);

		}
		return $li_candId;
	}



    /**
     * Delete user row
     *
     * @param number $id
     *
     * @return void
     */
    function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }



    function insertData($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function deleteData($table, $where) {
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }

        return $this->db->delete($table);
    }

    function updateData($table, $where, $data) {
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }

        return $this->db->update($table, $data);
    }

    function insertBatch($table, $data) {
        $this->db->insert_batch($table, $data);
    }

    public function emailCheck($email = '') {
        if (empty($email)) {
            return FALSE;
        }
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->row()) {
            return true;
        } else {
            return false;
        }
    }
function getData_2($table, $where = array(), $fields = '', $or_where = array(), $in_where = array(), $order_by = array(), $limit = array(), $groupBy = '') {
        if (!empty($fields)) {
            $this->db->select($fields);
        }

        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }

        if (!empty($or_where)) {
            $ow = '';
            foreach ($or_where as $k => $value) {
                // $this->db->or_where($k, $value);
                $ow .= $k . '="' . $value . '" OR ';
            }

            $pos = strrpos($ow, 'OR');
            $ow = substr($ow, 0, $pos - 1);
            $ow = '(' . $ow . ')';
            $this->db->where($ow);
        }

        if (!empty($in_where)) {
            foreach ($in_where as $k => $value) {
                // $this->db->where('(' . $k . ' IN (' . implode(',', $value) . '))');
                $this->db->where_in($k, $value);
            }
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by['order_by'], $order_by['sort']);
        }
        if (!empty($groupBy)) {
            $this->db->group_by($groupBy);
        }

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }

        $query = $this->db->get($table);
        echo $this->db->last_query();
//        exit;
        return $query->result();
    }
    function getData($table, $where = array(), $fields = '', $or_where = array(), $in_where = array(), $order_by = array(), $limit = array(), $groupBy = '') {
        if (!empty($fields)) {
            $this->db->select($fields);
        }

        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }

        if (!empty($or_where)) {
            $ow = '';
            foreach ($or_where as $k => $value) {
                // $this->db->or_where($k, $value);
                $ow .= $k . '="' . $value . '" OR ';
            }

            $pos = strrpos($ow, 'OR');
            $ow = substr($ow, 0, $pos - 1);
            $ow = '(' . $ow . ')';
            $this->db->where($ow);
        }

        if (!empty($in_where)) {
            foreach ($in_where as $k => $value) {
                // $this->db->where('(' . $k . ' IN (' . implode(',', $value) . '))');
                $this->db->where_in($k, $value);
            }
        }

        if (!empty($order_by)) {
            $this->db->order_by($order_by['order_by'], $order_by['sort']);
        }
        if (!empty($groupBy)) {
            $this->db->group_by($groupBy);
        }

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }

        $query = $this->db->get($table);
//        echo $this->db->last_query();
//        exit;
        return $query->result();
    }

	   function applied_jobs($jid = 0, $appliedUserId = 0) {
        $this->db->select('jp.*'); // my_favorites information for product details
        $this->db->from('job_applied jp');
        $this->db->where('jp.applied_in_job_id', $jid);
        $this->db->where('jp.applied_by_user_id', $appliedUserId);
        $query = $this->db->get();
        return $query->result();
    }

	

	function saved_jobs($jid = 0, $appliedUserId = 0){
		$this->db->select('sj.*'); // my_favorites information for product details
        $this->db->from('save_jobs sj');
        $this->db->where('sj.saved_job_id', $jid);
        $this->db->where('sj.save_by_user_id', $appliedUserId);
        $query = $this->db->get();
        return $query->result();
	}

	function get_favorite_list ($favid= 0, $favbyid= 0){
		$this->db->select('fc.*'); // my_favorites information for product details
        $this->db->from('favorites_candidate fc');
        $this->db->where('fc.favorite_in_user_id', $favid);
        $this->db->where('fc.favorite_by_user_id', $favbyid);
        $query = $this->db->get();
        return $query->result();

	}

    function db_show_single_user($id) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        return $query->row_array();
    }

    function get_user_by_id($id) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where(array('id' => $id));
        $query = $this->db->get();
        return $query->row_array();
    }

    function getPost($id) {
        $this->db->select('p.*, COUNT(DISTINCT pl.id) AS likes, GROUP_CONCAT(DISTINCT pl.user_id) AS like_users, COUNT(DISTINCT c.id) AS comments, GROUP_CONCAT(DISTINCT c.user_id) AS comment_users, COUNT(DISTINCT r.id) AS reviews, GROUP_CONCAT(DISTINCT r.user_id) AS review_users');
        $this->db->from('post p');
        $this->db->join('post_comment c', 'c.post_id = p.id', 'left');
        $this->db->join('post_likes pl', 'pl.post_id = p.id', 'left');
        $this->db->join('post_review r', 'r.post_id = p.id', 'left');
        $this->db->group_by(array('p.id', 'pl.post_id', 'c.post_id'));
        $this->db->order_by('p.modified_date', 'DESC');
        $this->db->where('p.user_id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function getComment($pid) {
        $this->db->select('c.comment, u.first_name, u.last_name, u.filename');
        $this->db->from('post_comment c');
        $this->db->join('users u', 'u.id = c.user_id', 'left');
        $this->db->order_by('c.created_date', 'ASC');
        $this->db->where('c.post_id', $pid);
        $query = $this->db->get();
        return $query->result();
    }

    function getEndorse($action, $uid) {
        $this->db->select('e.*, u.first_name, u.last_name, u.filename, u.email');
        $this->db->from('endorse_business e');
        $this->db->join('users u', 'u.id = e.follow_by', 'left');
        $this->db->order_by('e.created_date', 'DESC');
        $this->db->where('e.user_id', $uid);
        $query = $this->db->get();
        return $query->result();
    }

	function getUserTypeData($userId = 0){
		$this->db->select('g.name');
		$this->db->from('users_groups ug');
		$this->db->join('groups g', 'g.id = ug.group_id', 'left');
		$this->db->where('ug.user_id', $userId);
		$query = $this->db->get();
		return $query->result();

	}

    function getFollowers($uid, $where = array()) {
        $this->db->select('f.*, u.first_name, u.last_name, u.filename, u.email');
        $this->db->from('follow_business_seller f');
        $this->db->join('users u', 'u.id = f.follow_by', 'left');
        $this->db->order_by('f.created_date', 'DESC');
        $this->db->where('f.user_id', $uid);
        if (!empty($where)) {
            foreach ($where as $k => $value) {
                $this->db->where($k, $value);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }

	function get_product_order_data($uid = 0){
		 $this->db->select('po.*, p.name');
		 $this->db->from('product_orders po');
		 $this->db->join('products p', 'p.id = po.product_id', 'left');
		 $this->db->where('po.order_by', $uid);
		 $this->db->group_by('po.id');
         $query = $this->db->get();
         return $query->result();
	}

    function getMessages($action, $uid = 0, $target_id = '') {
        if ($action == 'user_list') {
            $this->db->select('u.id, u.email, u.first_name, u.last_name, u.filename, u.type');
            $this->db->from('users u');
            $this->db->join('messages m', '(m.from_id = u.id OR m.to_id = u.id)', 'left');
            $this->db->where('u.active', 1);
            if ($target_id == B2B) {
                $this->db->where('u.type', SELLER);
            } else if ($target_id == CUSTOMER) {
                $this->db->where('u.type', SELLER);
            } else {
                $this->db->where('(u.type = "' . B2B . '" OR u.id IN (SELECT m1.from_id FROM messages m1 WHERE m1.to_id = ' . $uid . ' GROUP BY m1.from_id))');
            }
            $this->db->group_by('u.id');
            $query = $this->db->get();
            return $query->result();
        } else if ($action == 'message_by_user') {
            $this->db->select('m.*');
            $this->db->from('messages m');
            $this->db->where('((m.from_id = "' . $uid . '" AND m.to_id = "' . $target_id . '") OR (m.from_id = "' . $target_id . '" AND m.to_id = "' . $uid . '"))');
            $this->db->where('(m.id NOT IN (SELECT DISTINCT md.msg_id FROM messages_delete AS md WHERE md.user_id = ' . $uid . '))');
            $query = $this->db->get();
            return $query->result();
        }
    }

    function getReviews($action, $where = array()) {
        if ($action == 'post') {
            $this->db->select('u.id, u.first_name, u.last_name, u.filename, u.type, r.review');
            $this->db->from('post_review r');
            $this->db->join('users u', '(u.id = r.user_id)', 'left');
            $this->db->where('r.post_id', $where['pid']);
            $query = $this->db->get();
            return $query->result();
        }
    }

    ///Koustav 19-12-2019/////
    function getUsermeta($where = array()) {

        $this->db->select('um.meta_value');
        $this->db->from('users_meta um');
        if (!empty($where)) {
            foreach ($where as $key => $val) {
                $this->db->where($key, $val);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }

    /* Rupam trending brands */

    function getTrendingBrands($action) {
        if ($action == 'admin_list') {
            $this->db->select('bd.company_name, bd.company_logo, bd.about_company, u.id, u.first_name, u.last_name, u.filename');
            $this->db->from('users u');
            $this->db->join('users_business_details bd', 'bd.user_id = u.id', 'left');
            $this->db->where('u.type', B2B);
            $query = $this->db->get();
            return $query->result();
        } else if ($action == 'home_page') {
            $this->db->select('bd.company_name, bd.company_logo, bd.about_company, u.id, u.first_name, u.last_name, u.filename');
            $this->db->from('trending_brands_setting tb');
            $this->db->join('users u', 'u.id = tb.brand_id', 'inner');
            $this->db->join('users_business_details bd', 'bd.user_id = u.id', 'left');
            $this->db->where('u.type', B2B);
            $query = $this->db->get();
            return $query->result();
        }
    }

    /* Rupam get header current rating graph */

    function getRating($action, $user_id, $user_type, $date_start, $date_end) {
        if ($action == 'products') {
            $this->db->select('COUNT(sp.id) AS total');
            if ($user_type == SELLER) {
                $this->db->from('seller_stock_product sp');
                $this->db->where('sp.seller_id', $user_id);
            } else if ($user_type == B2B) {
                $this->db->from('products sp');
                $this->db->where('sp.user_id', $user_id);
            }
            $this->db->where('sp.status', 1);
            $this->db->where('sp.created_date BETWEEN ' . $date_start . ' AND ' . $date_end);
        } else if ($action == 'sales') {
            $this->db->select('SUM(po.quantity) AS total');
            $this->db->from('product_orders po');
            if ($user_type == SELLER) {
                $this->db->where('po.seller_id', $user_id);
            } else if ($user_type == B2B) {
                $this->db->join('products p', 'p.id = po.product_id');
                $this->db->where('p.user_id', $user_id);
                $this->db->where('p.status', 1);
            }
            $this->db->where('po.status', 1);
            $this->db->where('po.created_date BETWEEN ' . $date_start . ' AND ' . $date_end);
        } else if ($action == 'followers') {
            $this->db->select('COUNT(f.id) AS total');
            $this->db->from('follow_business_seller f');
            $this->db->where('f.user_id', $user_id);
            $this->db->where('f.created_date BETWEEN ' . $date_start . ' AND ' . $date_end);
        }

        $query = $this->db->get();
        // pre($this->db->last_query());
        return $query->result();
    }

    public function getUserListByType($ls_userType) {
        $la_userList = $this->db->select('u.*')->from('users u')
                        ->join("users_groups ug", "ug.user_id = u.id", 'left')
                        ->join("groups g", "g.id = ug.group_id", 'left')
                        ->order_by("u.id", "desc")
                        ->where("g.name", $ls_userType)->get()->result();
                        //echo $this->db->last_query();
        return $la_userList;
    }

    public function getUserListById($id) { // use backend && frontend
        $la_user = $this->db->select('u.*, GROUP_CONCAT(g.name) user_types')->from('users u')
                        ->join("users_groups ug", "ug.user_id = u.id", 'left')
                        ->join("groups g", "g.id = ug.group_id", 'left')
                        ->where("u.id", $id)->get()->result();
        return $la_user;
    }

    public function getUserCount() {
        $la_user = $this->db->select('g.name, COUNT(u.id) user_count')
                        ->from('groups g')
                        ->join("users_groups ug", "ug.group_id = g.id", 'left')
                        ->join("users u", "u.id = ug.user_id", 'left')
                        ->group_by('g.name')->where("g.name != 'admin'")->get()->result();
        return $la_user;
    }

    public function getUserType($where) {
        $this->db->select('GROUP_CONCAT(g.name) user_types')->from('users u')
                ->join("users_groups ug", "ug.user_id = u.id", 'left')
                ->join("groups g", "g.id = ug.group_id", 'left');
        foreach ($where as $k => $cond) {
            $this->db->where("u.$k", $cond);
        }
        $la_user = $this->db->get()->row();
        return $la_user;
    }

    public function get_location_for_search($where = []) {
        $this->db->select('*, c.name city')->from('cities c');
        foreach ($where as $k => $cond) {
            $this->db->where("u.$k", $cond);
        }
        $this->db->order_by('name', 'ASC');
        $this->db->group_by('name');
        $la_data = $this->db->get()->result();
        return $la_data;
    }

    public function get_location_autocomplete_search($searchVal = '', $limit = []) {
        $this->db->select('lc.ID, lc.CITY, lc.COUNTRY')->from('location_cities lc');
        $this->db->where("lc.CITY LIKE '$searchVal%'");
        $this->db->where("lc.CITY != ''");
        $this->db->order_by('CITY', 'ASC');
        $this->db->group_by('CITY');
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();
        return $la_data;
    }

    public function getUserReq_count($ls_userType = '', $loggedId = 0, $limit = []) {
        $this->db->select('COUNT(DISTINCT(u.id)) user_count');
        $this->db->from('users u');
        $this->db->join("users_groups ug", "ug.user_id = u.id", 'left');
        $this->db->join("groups g", "g.id = ug.group_id", 'left');
         $this->db->join("users_business_map bm", "bm.user_id = u.id", 'left');
        $this->db->join("users_business_details ub", "ub.id = bm.business_id", 'left');
        $this->db->join("users_business_location ubl", "ubl.business_id = ub.id", 'left');
        $this->db->join("location_cities lc", "lc.ID = ubl.city_id", 'left');
		
        
		if (!empty($ls_userType)) {
			$ls_userType=trim($ls_userType,"'");
			$this->db->where("g.name",$ls_userType);	
			$this->db->where('bm.user_type', $ls_userType);
		}
        if ($loggedId != 0) {
            $this->db->where("u.id != $loggedId");
        }
        $this->db->where("u.active = 1");
         if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->row();
        //echo $this->db->last_query();
        return $la_data;
    }


	public function getUsersByUserType_count($ls_userType = '', $loggedId = 0, $limit = []) {
    	//echo $ls_userType.'<br>';
        $this->db->select('COUNT(DISTINCT(u.id)) user_count');
        if($ls_userType=="'candidate'"){
        	$this->db->from('users_candidate_details uc');
        	$this->db->join("users u ", "uc.userid = u.id", 'left');
        }else{
        	$this->db->from('users u');
        }
        $this->db->join("users_groups ug", "ug.user_id = u.id", 'left');
        $this->db->join("groups g", "g.id = ug.group_id", 'left');
        
		if (!empty($ls_userType)) {
			$ls_userType=trim($ls_userType,"'");
			//$this->db->where("g.name LIKE ($ls_userType)");	
			$this->db->where("g.name",$ls_userType);	
		}
		
        
        if ($loggedId != 0) {
            $this->db->where("u.id != $loggedId");
        }
        $this->db->where("u.active = 1");
         if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->row();
		//echo $this->db->last_query();
		//exit;
        return $la_data;
    }
	public function getjobbyuser_count($loggedId = 0){
		$this->db->select('count(jobs.id) as Total');
		$this->db->from('jobs');
		  if ($loggedId != 0) {
            $this->db->where("jobs.id != $loggedId");
        }
		$this->db->where("jobs.job_status = 1");
		$la_data = $this->db->get()->row();
        return $la_data;
	}
	public function getjobbyuser_count_2($loggedId = 0,$uName='',$locationName='',$location_id=''){
		$this->db->select('count(jobs.id) as Total');
		$this->db->from('jobs');
		  if ($loggedId != 0) {
            $this->db->where("jobs.id != $loggedId");
        }
        if ($uName != '') {
            $this->db->where("jobs.designation LIKE '$uName%'");
        }
		if(!empty($location_id)){
		 $this->db->join('job_city', 'jobs.id = job_city.job_id', 'inner');
		 $this->db->where(array('job_city.location_id'=>$location_id));
		}
	
		
		$this->db->where("jobs.job_status = 1");
		
		$la_data = $this->db->get()->row();
		//echo $this->db->last_query();
        return $la_data;
	}

    public function getUsersByUserType_auto($ls_userType = '', $loggedId = 0, $limit = [], $name = '', $select = '') {
        if ($select == '') {
            $this->db->select('u.*, g.name user_type');
        } else {
            $this->db->select($select);
        }
        $this->db->from('users u');
        $this->db->join("users_groups ug", "ug.user_id = u.id", 'left');
        $this->db->join("groups g", "g.id = ug.group_id", 'left');
        $this->db->where("g.name LIKE ($ls_userType)");
        if ($loggedId != 0) {
            $this->db->where("u.id != $loggedId");
        }
        if ($name != '') {
            $this->db->where("u.first_name LIKE '$name%'");
        }
        $this->db->where("u.active = 1");
        $this->db->order_by('u.first_name', 'ASC');
        $this->db->group_by('u.id');
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();

        return $la_data;
    }

	public function getTypedetails($ls_userType = '', $loggedId = 0, $limit = [], $name = '', $select = '', $uId = 0, $location_id = 0, $locationFlag = ''){
		$this->db->select('*');
		$this->db->from('users u');
		$this->db->join("users_business_map bm", "bm.user_id = u.id", 'left');
        $this->db->join("users_business_details ub", "ub.id = bm.business_id", 'left');
		$this->db->where("g.name LIKE ($ls_userType)");
		$this->db->where('bm.user_type', $userType);
		$la_data = $this->db->get()->result();
		return $la_data;
	}

    public function getUsersByUserType($ls_userType = '', $loggedId = 0, $limit = [], $name = '', $select = '', $uId = 0, $location_id = 0, $locationFlag = '') {
		if ($select == '') {
			$this->db->select('u.*, g.name user_type, ub.*,ub.company_name');
        } else {
            $this->db->select($select);
        }
        $this->db->from('users u');
        $this->db->join("users_groups ug", "ug.user_id = u.id", 'left');
        $this->db->join("groups g", "g.id = ug.group_id", 'left');
        $this->db->join("users_business_map bm", "bm.user_id = u.id", 'left');
        $this->db->join("users_business_details ub", "ub.id = bm.business_id", 'left');
        $this->db->join("users_business_location ubl", "ubl.business_id = ub.id", 'left');
        $this->db->join("location_cities lc", "lc.ID = ubl.city_id", 'left');
		$this->db->where('g.name', $ls_userType);
		$this->db->where('bm.user_type', $ls_userType);
	
        if ($loggedId != 0) {
            $this->db->where("u.id != $loggedId");
        }
        if ($uId != 0) {
            $this->db->where("u.id = $uId");
        }
		if ($name != '') {
			
            //$this->db->where("u.first_name LIKE '$name%'");
			//$this->db->where("u.first_name LIKE 'king%'");
			
			$this->db->where("ub.company_name LIKE '$name%'");
        }
        if ($locationFlag == '') {
            if ($location_id != 0) {
                $this->db->where("ubl.city_id = $location_id");
            } else {
                $currentCity = "Kolkata";
                $currentIp = get_client_ip();
                if (!in_array($currentIp, ["::1", "127.0.0.1"])) {
                    $currentData = json_decode(file_get_contents('http://ip-api.io/json/' . get_client_ip()));
                    $currentCity = $currentData->city;
                }
                $this->db->where("lc.CITY = '$currentCity'");
            }
        }
        $this->db->where("u.active = 1");
        $this->db->order_by('u.first_name', 'ASC');
        $this->db->group_by('u.id');
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();
        //echo $this->db->last_query();
        //exit;

        if (($location_id == 0) && (count($la_data) == 0)) {

            $la_data = $this->getUsersByUserType($ls_userType, $loggedId, $limit, $name, $select, $uId, 0, $locationFlag = 'all');
        }
//        die($ls_userType);
        return $la_data;
    }
public function getUsersByUserType_s($ls_userType = '', $loggedId = 0, $limit = [], $name = '', $select = '', $uId = 0, $location_id = 0, $locationFlag = '') {
		if ($select == '') {
			$this->db->select('u.*, g.name user_type, ub.*,ub.company_name');
        } else {
            $this->db->select($select);
        }
        $this->db->from('users u');
        $this->db->join("users_groups ug", "ug.user_id = u.id", 'left');
        $this->db->join("groups g", "g.id = ug.group_id", 'left');
        $this->db->join("users_business_map bm", "bm.user_id = u.id", 'left');
        $this->db->join("users_business_details ub", "ub.id = bm.business_id", 'left');
        $this->db->join("users_business_location ubl", "ubl.business_id = ub.id", 'left');
        $this->db->join("location_cities lc", "lc.ID = ubl.city_id", 'left');
		$this->db->where('g.name', $ls_userType);
		$this->db->where('bm.user_type', $ls_userType);
	
        if ($loggedId != 0) {
            $this->db->where("u.id != $loggedId");
        }
        if ($uId != 0) {
            $this->db->where("u.id = $uId");
        }
		if ($name != '') {
			
            //$this->db->where("u.first_name LIKE '$name%'");
			//$this->db->where("u.first_name LIKE 'king%'");
			
			$this->db->where("ub.company_name LIKE '$name%'");
        }
        if ($locationFlag == '') {
            if ($location_id != 0) {
                $this->db->where("ubl.city_id = $location_id");
            } else {
                $currentCity = "Kolkata";
                $currentIp = get_client_ip();
                if (!in_array($currentIp, ["::1", "127.0.0.1"])) {
                    $currentData = json_decode(file_get_contents('http://ip-api.io/json/' . get_client_ip()));
                    $currentCity = $currentData->city;
                }
                $this->db->where("lc.CITY = '$currentCity'");
            }
        }
        $this->db->where("u.active = 1");
        $this->db->order_by('u.first_name', 'ASC');
        $this->db->group_by('u.id');
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();
        //echo $this->db->last_query();
        //exit;

        if (($location_id == 0) && (count($la_data) == 0)) {

            $la_data = $this->getUsersByUserType($ls_userType, $loggedId, $limit, $name, $select, $uId, 0, $locationFlag = 'all');
        }
//        die($ls_userType);
        return $la_data;
    }
	public function getusersType($ls_userType = '', $loggedId = 0, $limit = [], $uname = '', $location_id = 0, $locationname='', $locationFlag = '')
	{
		//echo $locationname.':'.$loggedId.':'.$limit;
		$this->db->select('*');

		$this->db->from('users_candidate_details uc');
		$this->db->join('users u', "u.id = uc.userid", 'left');
		$this->db->join("users_groups ug", "ug.user_id = u.id", 'left');
		$this->db->join("groups g", "g.id = ug.group_id", 'left');
		$this->db->where("g.name LIKE ($ls_userType)");
		if ($loggedId != 0) {
			$this->db->where("u.id != $loggedId");
		}
		if ($uname != '') {
			$this->db->where("uc.candidate_designation LIKE '$uname%'");
		}
		if ($locationFlag == '') {
	/*if ($location_id != 0) {
	$this->db->where("uc.candidate_location LIKE '$locationname%'");
	}
	*/
			if (($location_id != '')&&($location_id != '0') ) {
				$this->db->join('candidate_city', 'uc.userid = candidate_city.user_id', 'inner');
				$this->db->where(array('candidate_city.location_id'=>$location_id));
			}
		}
		$this->db->where("u.active = 1");
		$this->db->order_by('u.first_name', 'ASC');
		if (!empty($limit)) {
			$this->db->limit($limit['limit'], $limit['offset']);
		}

		$la_data = $this->db->get()->result();
		//echo $this->db->last_query();
		return $la_data;
	}

	public function getjobbyuserType($loggedId = 0, $limit = [],$uname = '', $location_id = 0,$locationname, $locationFlag = ''){
		$this->db->select('*');
		$this->db->from('jobs');
		
		if ($loggedId != 0) {
			$this->db->where("jobs.userid != $loggedId");
        }
		if ($uname != '') {
            $this->db->where("jobs.designation LIKE '$uname%'");
        }
		if(!empty($_GET['location_id'])){
		  $location_id=$_GET['location_id'];
		}
	
		if ($locationFlag == '') {
           if ($location_id != 0) {
			  $this->db->join('job_city', 'jobs.id = job_city.job_id', 'inner');
              //$this->db->where("jobs.preferred_location LIKE '$locationname%'");
			  $this->db->where(array('job_city.location_id'=>$location_id));
           }
		  
        }
		$this->db->where("jobs.job_status = 1");
		$this->db->order_by('jobs.job_title', 'ASC');
		if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        
		$la_data = $this->db->get()->result();
		//echo $this->db->last_query();
        //exit;
		return $la_data;



	}

	public function getjobbyadvanceType($loggedId = 0, $limit = [],$job_title = '',$job_desc = '',$experience = 0,$designation = '',$locationname='',$avl_time_frame='',$travel='', $locationFlag = ''){
		$this->db->select('*');
		$this->db->from('jobs');
		if ($loggedId != 0) {
			$this->db->where("jobs.userid != $loggedId");
        }
		if ($job_title != '') {
            $this->db->where("jobs.job_title LIKE '$job_title%'");
        }
		if ($job_desc != '') {
            $this->db->where("jobs.job_description LIKE '$job_desc%'");
        }
		if ($experience != 0) {
            $this->db->where("jobs.experience = '$experience'");
        }
		if ($designation != '') {
            $this->db->where("jobs.designation LIKE '$designation%'");
        }
		/*if ($locationFlag == '') {
           if ($locationname != '') {
              $this->db->where("jobs.preferred_location LIKE '$locationname%'");
           }
        }
        */
		if ($avl_time_frame != '') {
            $this->db->where("jobs.avl_time_frame = '$avl_time_frame'");
        }
		/*if ($travel != '') {
            $this->db->where("jobs.travel_required = '$travel'");
        }
        */
		$this->db->where("jobs.job_status = 1");
		$this->db->order_by('jobs.job_title', 'ASC');
		if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
		$la_data = $this->db->get()->result();
		//echo $this->db->last_query();
		//exit;
		return $la_data;
	}

	public function single_user($ls_userId = ''){
		$this->db->select('*');
		$this->db->from('users');
		$this->db->join('users_candidate_details', 'users.id= users_candidate_details.userid');
		$this->db->where('users.id', $ls_userId);
		$la_data = $this->db->get()->result();
		return $la_data;
	}

	public function get_job_details($ls_jobId = ''){
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->where('jobs.id', $ls_jobId);
		$la_data = $this->db->get()->result();
		return $la_data;
	}

    public function get_profile_details($ls_userType = '', $limit = []) {
        $this->db->select('u.*, g.name user_type');
        $this->db->from('users u');
        $this->db->join("users_groups ug", "ug.user_id = u.id", 'left');
        $this->db->join("groups g", "g.id = ug.group_id", 'left');
        $this->db->where("g.name LIKE ($ls_userType)");
        $this->db->where("u.active = 1");
        $this->db->order_by('u.first_name', 'ASC');
        $this->db->group_by('u.id');
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();
        return $la_data;
    }

    public function get_boost_users() {
        $this->db->select('sb.*, bpc.cat_name, u.first_name, u.last_name');
        $this->db->from('subscription_for_boost sb');
        $this->db->join("boost_product_charges bc", "bc.boost_id = sb.subscription_id", 'left');
        $this->db->join("boost_product_category bpc", "bpc.cat_id = bc.boost_cat_id", 'left');
        $this->db->join("users u", "u.id = sb.user_id", 'left');
        $this->db->order_by('sb.subscription_for_boost_id', 'desc');
        $this->db->group_by('sb.subscription_for_boost_id');

        $la_data = $this->db->get()->result();
        return $la_data;
    }

    function single_user_location($businessId = '') {
        $this->db->select('ubl.*, lc.CITY, lc.COUNTRY');
        $this->db->from('users_business_location ubl');
        $this->db->join('location_cities lc', 'lc.ID = ubl.city_id', 'left');
        $this->db->where('ubl.business_id', $businessId);
        $this->db->order_by('lc.CITY', 'ASC');

        $query = $this->db->get();
        return $query->result();
    }
	function get_job_applicant($emplrId = ''){
		$this->db->select('ja.*, u.*, j.*');
		$this->db->from(' job_applied ja');
		$this->db->join('users u', 'u.id = ja.applied_by_user_id', 'left');
		$this->db->join('jobs j', 'j.id = ja.applied_in_job_id', 'left');
		$this->db->where('j.userid', $emplrId);
		$this->db->order_by('ja.applied_id', 'DESC');
		$query = $this->db->get();
        return $query->result();
	}

	function get_applied_data($cndteId = ''){
		$this->db->select('ja.*, u.*, j.*');
		$this->db->from(' job_applied ja');
		$this->db->join('users u', 'u.id = ja.applied_by_user_id', 'left');
		$this->db->join('jobs j', 'j.id = ja.applied_in_job_id', 'left');
		$this->db->where('ja.applied_by_user_id', $cndteId);
		$this->db->order_by('ja.applied_id', 'DESC');
		$query = $this->db->get();
        return $query->result();
	}
	function get_saved_data($cndteId = ''){
		$this->db->select('sj.*, u.*, j.*');
		$this->db->from(' save_jobs sj');
		$this->db->join('users u', 'u.id = sj.save_by_user_id', 'left');
		$this->db->join('jobs j', 'j.id = sj.saved_job_id', 'left');
		$this->db->where('sj.save_by_user_id', $cndteId);
		$this->db->order_by('sj.save_id', 'DESC');
		$query = $this->db->get();
        return $query->result();
	}

    function single_designer_business($userId = '', $userType = '') {
        $this->db->select('bd.*, GROUP_CONCAT(DISTINCT(l.CITY)) business_locations,ins.services as ins_service,sm.*');
        $this->db->select('GROUP_CONCAT(DISTINCT(ds.services)) business_services');
        $this->db->from('users_business_details bd');
        $this->db->join('users_business_location bl', 'bl.business_id = bd.id', 'left');
        $this->db->join('location_cities l', 'l.ID = bl.city_id', 'left');
        $this->db->join('users_business_map bm', 'bm.business_id = bd.id', 'left');
        $this->db->join('users_business_services_map sm', 'sm.business_id = bd.id', 'left');
        $this->db->join('interior_design_specialty ds', 'ds.services_id = sm.services_id', 'left');
		$this->db->join(' installation_services ins', 'ins.services_id = sm.services_id', 'left');
        $this->db->where('bd.user_id', $userId);
        $this->db->where('bm.user_type', $userType);
        $this->db->where('ds.status', 'A');
        $this->db->group_by('bd.id', 'ASC');

        $query = $this->db->get();
        $result = $query->row();
//        print_r($result);die;
        return $result;
    }

	function single_business_profile_details($userId = '', $userType = '') {
        $this->db->select('bd.*, GROUP_CONCAT(DISTINCT(l.CITY)) business_locations');
		$this->db->select('GROUP_CONCAT(DISTINCT(sm.service_info)) business_services_info');
        $this->db->select('GROUP_CONCAT(DISTINCT(ds.services)) business_services');
		$this->db->select('GROUP_CONCAT(DISTINCT(ins.services)) ins_service');
        $this->db->from('users_business_details bd');
        $this->db->join('users_business_location bl', 'bl.business_id = bd.id', 'left');
        $this->db->join('location_cities l', 'l.ID = bl.city_id', 'left');
        $this->db->join('users_business_map bm', 'bm.business_id = bd.id', 'left');
        $this->db->join('users_business_services_map sm', 'sm.business_id = bd.id', 'left');
        $this->db->join('interior_design_specialty ds', 'ds.services_id = sm.services_id', 'left');
		$this->db->join(' installation_services ins', 'ins.services_id = sm.services_id', 'left');
        $this->db->where('bd.user_id', $userId);
        $this->db->where('bm.user_type', $userType);
		 $this->db->order_by('bd.id', 'ASC');


        $query = $this->db->get();
        $result = $query->row();
//        print_r($result);die;
        return $result;
    }

    function get_business_data($uid = '', $user_type = '') {
        $this->db->select('bd.*');
        $this->db->from('users_business_map bm');
        $this->db->join('users_business_details bd', 'bd.id = bm.business_id', 'left');
        $this->db->where('bm.user_id', $uid);
        $this->db->where('bm.user_type', "$user_type");
        $query = $this->db->get();
        $la_business = $query->result();
        return $la_business;
    }

	function get_candidate_data($uid = '', $user_type = ''){
		$this->db->select('*');
		$this->db->from('users_candidate_details');
		$this->db->where('userid', $uid);
		$query = $this->db->get();
        $la_candidate_details = $query->result();
		return $la_candidate_details;
	}

	function get_payment_data($uid = '', $user_type = ''){
		$this->db->select('*');
		$this->db->from('users_payment_details');
		$this->db->where('userid', $uid);
		$query = $this->db->get();
        $la_payment_details = $query->result();
		return $la_payment_details;
	}

	function get_stripe_details($uid = ''){
		$this->db->select('*');
		$this->db->from('users_payment_details');
		$this->db->where('userid', $uid);
		$query = $this->db->get();
        $la_stripe_details = $query->result();
		return $la_stripe_details;
	}

	function get_jobs_data($uid = '', $user_type = '',$limit = []){
		$this->db->select('*');
		$this->db->from('jobs');
		$this->db->where('userid', $uid);
		$this->db->order_by('id', 'DESC');
		 if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
		$query = $this->db->get();
        $la_job_details = $query->result();
		return $la_job_details;
	}

    function business_data_update($uid = '', $user_type = '', $bPost = []) {
        $la_business = $this->get_business_data($uid, $user_type);

        $bPost['modified_date'] = time();
        $li_businessId = 0;
        if (empty($la_business)) {
            $bPost['created_date'] = time();
            $bPost['user_id'] = $uid;
            $this->db->insert('users_business_details', $bPost);
            $li_businessId = $this->db->insert_id();

            $this->db->insert('users_business_map', ['user_id' => $uid, 'user_type' => $user_type, 'business_id' => $li_businessId]);
        } else {
            $returnData = $this->updateData('users_business_details', ['id' => $la_business[0]->id], $bPost);
            if ($returnData) {
                $li_businessId = $la_business[0]->id;
            }
        }
        return $li_businessId;
    }


	function candidate_data_update($uid = '', $user_type = '', $cPost = []){
		$la_candidate_details = $this->get_candidate_data($uid, $user_type);
		$cPost['modified_date'] = time();
		if(empty($la_candidate_details)){
			$cPost['created_date'] = time();
			$cPost['userid'] = $uid;
			$this->db->insert('users_candidate_details', $cPost);
            $li_candId = $this->db->insert_id();
		} else {
			 $returnData = $this->updateData('users_candidate_details', ['details_id' => $la_candidate_details[0]->details_id], $cPost);
            if ($returnData) {
                $li_candId = $la_candidate_details[0]->details_id;
            }
		}
		return $li_candId;
	}

	function payment_data_update($uid = '', $cPost = []){
		$check_details = $this->get_stripe_details($uid);
		$data['refresh_date'] = time();
		if(empty($check_details)){
			$data['created_date'] = time();
			$data['userid'] = $uid;
			$this->db->insert('users_payment_details', $cPost);
            $li_candId = $this->db->insert_id();
		}else{
			$returnData = $this->updateData('users_payment_details', ['userid' => $check_details[0]->userid], $cPost);
			if($returnData){
				$li_candId = $check_details[0]->id;
			}
		}
		return $li_candId;
	}

    public function get_business_service_autocomplete_search($searchVal = '', $uType = '') {
        if ($uType == 'designer') {
            $table = "interior_design_specialty";
        } elseif ($uType == 'installer') {
            $table = "installation_services";
        }

        $this->db->select('*');
        $this->db->from("$table bs");
        $this->db->where("bs.services LIKE '%$searchVal%'");
        $this->db->where("bs.status", 'A');
        $this->db->order_by('bs.services_id', 'ASC');
        $this->db->group_by('bs.services');
        $la_data = $this->db->get()->result();
        return $la_data;
    }

    function get_business_service($uid = '', $uType = '', $businessId = 0) {
        if ($uType == 'designer') {
            $table = "interior_design_specialty";
        } elseif ($uType == 'installer') {
            $table = "installation_services";
        }

        $this->db->select('*');
        $this->db->from("$table bs");
        $this->db->join('users_business_services_map sm', 'sm.services_id = bs.services_id', 'left');
        $this->db->where("sm.business_id", $businessId);
        $this->db->where("bs.status", "A");
        $this->db->order_by('bs.services', 'ASC');
        $this->db->group_by('bs.services');
        $la_data = $this->db->get()->result();
        return $la_data;
    }

function get_all_details($uid = ''){
		$this->db->select('*');
        $this->db->from('users us');
		$this->db->join('users_payment_details sp', 'sp.userid = us.id', 'left');
		$this->db->where("sp.userid", $uid);
		$la_data = $this->db->get()->row();
        return $la_data;
	}

    function getCountDesignerServiceRequest($user_id) {
        $sql = "SELECT count(id) as count FROM `designer_request` WHERE `user_id` = '" . $user_id . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function getCountDesignerServiceRequest_received($user_id) {
        $sql = "SELECT count(dr.id) as count FROM `designer_request` dr "
                . "LEFT JOIN designer_request_user dru ON dru.request_id = dr.id "
                . "WHERE dru.designer_id = '" . $user_id . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function designer_request_received($user_id, $limit = []) {
        $this->db->select('dr.*, u.first_name, u.last_name')->from('designer_request dr');
        $this->db->join('designer_request_user dru', 'dru.request_id = dr.id', 'left');
        $this->db->join('users u', 'u.id = dr.user_id', 'left');
        $this->db->where("dru.designer_id = $user_id");
        $this->db->order_by('dr.id', 'DESC');

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();
//        print_r($la_data);die;
        return $la_data;
    }

    public function get_designer_autocomplete_search($searchVal = '', $limit = []) {
        $this->db->select('lc.id, lc.first_name, lc.last_name')->from('users lc');
        $this->db->join('users_groups ug', 'ug.group_id = 5', 'ug.user_id = lc.id', 'left');
        $this->db->where("lc.first_name LIKE '$searchVal%'");
        $this->db->where("lc.first_name != ''");
        $this->db->order_by('lc.id', 'ASC');
        $this->db->group_by('lc.id');
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();
        return $la_data;
    }

    public function get_installer_autocomplete_search($searchVal = '', $limit = []) {
        $this->db->select('lc.id, lc.first_name, lc.last_name')->from('users lc');
        $this->db->join('users_groups ug', 'ug.user_id = lc.id', 'left');
        $this->db->join('groups g', "g.name = 'installer'", 'ug.group_id = g.id', 'left');
        $this->db->where("lc.first_name LIKE '$searchVal%'");
        $this->db->where("lc.first_name != ''");
        $this->db->order_by('lc.id', 'ASC');
        $this->db->group_by('lc.id');
        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();
        return $la_data;
    }

    public function designer_purchase_requests_details($loggedId = 0, $puchaseId = 0, $flag = '') {
        $returnArr = [];
        $ls_areaData = '';
        $ls_reqUserData = '';
//        $ls_reqColaData = '';

        $this->db->select('dr.*')->from('designer_request dr');
        $this->db->where("dr.id = $puchaseId");
        $la_requestData = $this->db->get()->result();
        $returnArr['la_requestData'] = [];

        if (count($la_requestData) > 0) {
            $returnArr['la_requestData'] = $la_requestData[0];
            $this->db->select('arq.*')->from('designer_area_required arq');
            $this->db->join('designer_request_area_map amp', 'amp.designer_area_id = arq.designer_area_id', 'left');
            $this->db->where("amp.request_id = $puchaseId");
            $this->db->where("arq.status = 'A'");
            $la_areaData = $this->db->get()->result();
            $returnArr['la_areaData'] = $la_areaData;
            foreach ($la_areaData as $k => $row) {
                if ($k == 0) {
                    $ls_areaData .= $row->name;
                } else {
                    $ls_areaData .= ", " . $row->name;
                }
            }

            if ($flag == 'send') {
                /*$this->db->select('dra.*, u.first_name, u.last_name')->from('designer_request_user dra');
                $this->db->join('users u', 'u.id = dra.designer_id', 'left');
                $this->db->where("dra.request_id = $puchaseId");
                */
                
				$this->db->select('dra.*, u.first_name, u.last_name,ubd.company_name')->from('designer_request_user dra');
				$this->db->join('users u', 'u.id = dra.designer_id', 'left');
				$this->db->join('users_business_map ubmap', 'u.id = ubmap.user_id', 'left');
				$this->db->join('users_business_details ubd', 'ubmap.business_id = ubd.id', 'left');
				$this->db->where("dra.request_id = $puchaseId");
				$this->db->where("ubmap.user_type = 'designer'");
                
                
                $la_reqUserData = $this->db->get()->result();
                $returnArr['la_reqUserData'] = $la_reqUserData;

                foreach ($la_reqUserData as $k => $row) {
					if ($k == 0) {
						$ls_reqUserData .= $row->company_name;
                        //$ls_reqUserData .= $row->first_name . " " . $row->last_name;
//                    $ls_reqUserData .= "<a href='" . BASE_URL . "profile-details/designer/$row->id' target='_blank'>" . $row->first_name . " " . $row->last_name . "</a>";
                    } else {
						//$ls_reqUserData .= ", " . $row->first_name . " " . $row->last_name;
						$ls_reqUserData .= ", " .$row->company_name;
                        
                    }
                }
            }


//            $this->db->select('cdr.*')->from('collaboration_for_designer_req cdr');
//            $this->db->join('designer_collaboration_map dcm', 'dcm.collaboration_id = cdr.collaboration_id', 'left');
//            $this->db->where("dcm.request_id = $puchaseId");
//            $la_reqColaData = $this->db->get()->result();
//            $returnArr['la_reqColaData'] = $la_reqColaData;
//
//            foreach ($la_reqColaData as $k => $row) {
//                if ($k == 0) {
//                    $ls_reqColaData .= $row->collaboration;
//                } else {
//                    $ls_reqColaData .= ", " . $row->collaboration;
//                }
//            }
        }
        $returnArr['ls_areaData'] = $ls_areaData;
        $returnArr['ls_reqUserData'] = $ls_reqUserData;
//        $returnArr['ls_reqColaData'] = $ls_reqColaData;
        return $returnArr;
    }

    function getCountInstallerRequest($user_id) {
        $sql = "SELECT count(installer_request_id) as count FROM `installer_request` WHERE `user_id` = '" . $user_id . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    function installer_request_received($user_id, $limit = [], $installer_order_by = []) {
        $this->db->select('ir.*, u.first_name, u.last_name')->from('installer_request ir');
        $this->db->join('installer_request_map irm', 'irm.request_id = ir.installer_request_id', 'left');
        $this->db->join('users u', 'u.id = ir.user_id', 'left');
        $this->db->where("irm.installer_id = $user_id");
        $this->db->order_by('ir.installer_request_id', 'DESC');

        if (!empty($limit)) {
            $this->db->limit($limit['limit'], $limit['offset']);
        }
        $la_data = $this->db->get()->result();
//        print_r($la_data);die;
        return $la_data;
    }

    function getCountInstallerRequest_received($user_id) {
        $sql = "SELECT count(ir.installer_request_id) as count FROM `installer_request` ir "
                . "LEFT JOIN installer_request_map irm ON irm.request_id = ir.installer_request_id "
                . "WHERE irm.installer_id = '" . $user_id . "'";
        $query = $this->db->query($sql);
        return $query->row();
    }

    public function installer_purchase_requests_details($loggedId = 0, $puchaseId = 0, $flag = '') {
        $returnArr = [];
//        $ls_areaData = '';
        $ls_reqUserData = '';
        $ls_reqText = '';

        $this->db->select('ir.*')->from('installer_request ir');
        $this->db->where("ir.installer_request_id = $puchaseId");
        $la_requestData = $this->db->get()->result();
        $returnArr['la_requestData'] = [];

        if (count($la_requestData) > 0) {
            $lo_requestData = $la_requestData[0];
            $returnArr['la_requestData'] = $la_requestData[0];

            foreach ($lo_requestData as $key => $val) {
                if (in_array($key, ['user_id', 'installer_request_id', 'ip'])) {
                    continue;
                }
                $val = ($key == 'status') ? (($val == 'A') ? "Active" : "Archived") : $val;
                $label = ucfirst(str_replace('_', ' ', $key));
                $value = ($val == '') ? "--" : ucfirst($val);
                $ls_reqText .= '<p><span>' . $label . ': </span><strong class="request_type">' . $value . '</strong></p>';
            }

            if ($lo_requestData->user_id == $loggedId) {
            	/*
                $this->db->select('irm.*, u.first_name, u.last_name')->from('installer_request_map irm');
                $this->db->join('users u', 'u.id = irm.installer_id', 'left');
                $this->db->where("irm.request_id = $puchaseId");
                */
				$this->db->select('irm.*, u.first_name, u.last_name,ubd.company_name')->from('installer_request_map irm');
				$this->db->join('users u', 'u.id = irm.installer_id', 'left');
				$this->db->join('users_business_map ubmap', 'u.id = ubmap.user_id', 'left');
				$this->db->join('users_business_details ubd', 'ubmap.business_id = ubd.id', 'left');
				
				$this->db->where("irm.request_id = $puchaseId");
				$this->db->where("ubmap.user_type = 'installer'");
                $la_reqUserData = $this->db->get()->result();
				
                $returnArr['la_reqUserData'] = $la_reqUserData;

                foreach ($la_reqUserData as $k => $row) {
                    if ($k == 0) {
                        //$ls_reqUserData .= $row->first_name . " " . $row->last_name;
						$ls_reqUserData .= $row->company_name ;
//                    $ls_reqUserData .= "<a href='" . BASE_URL . "profile-details/designer/$row->id' target='_blank'>" . $row->first_name . " " . $row->last_name . "</a>";
                    } else {
                        //$ls_reqUserData .= ", " . $row->first_name . " " . $row->last_name;
						$ls_reqUserData .= ", " . $row->company_name ;
                    }
                }

				if (count($la_reqUserData) > 0) {
					//$ls_reqUserData = $this->db->last_query();
                    $ls_reqText .= "<p>Request to : <strong class='request_type'>" . $ls_reqUserData . "</strong></p>";
                }
            }
        }
//        $returnArr['ls_areaData'] = $ls_areaData;
        $returnArr['ls_reqText'] = $ls_reqText;
        $returnArr['ls_reqUserData'] = $ls_reqUserData;
        return $returnArr;
    }

}
