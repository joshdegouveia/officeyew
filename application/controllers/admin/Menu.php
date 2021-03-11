<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * 
 */
class Menu extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Users_model');
		
		if ( $this->userLogged() == false ){
			// redirect them to the login page
			redirect('admin/auth/login', 'refresh');
			exit;
		}
	}

	/**
	 * Redirect if needed, otherwise display the user list
	 */
	public function index ($inactive = false) {
		$this->commonData['activeMenues']['menuParent'] = 'menu';
		$this->commonData['activeMenues']['menuChild'] = 'list';

		$this->commonData['title'] = "Menu";
		$data = $this->Users_model->getData('menu_list');
		$this->commonData['content'] = $data;

		$this->loadScreen('menu');
	}

	public function edit () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($cid)) {
			redirect('admin/menu', 'refresh');
		}

		$this->commonData['activeMenues']['menuParent'] = 'menu';
		$this->commonData['activeMenues']['menuChild'] = 'list';

		$this->commonData['title'] = "Menu";
		$data = $this->Users_model->getData('menu_list', array('id' => $cid));

		if (empty($data)) {
			redirect('admin/menu', 'refresh');
		}

		if ($this->input->post('menu_name')) {
			$post = $this->input->post();

			$fields = array(
				'menu_name' => $post['menu_name'],
				'position' => $post['position'],
				'modified_date' => time(),
			);

			$this->Users_model->updateData('menu_list', array('id' => $cid), $fields);
			$this->session->set_flashData('msg_success', '<em>' . $this->input->post('menu_name') . '</em> successfully updated.');
			redirect(base_url('admin/menu'), 'refresh');
		}

		$this->commonData['content'] = $data[0];
		$this->loadScreen('add_menu');
	}

	public function lists () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;
		$tp = ($this->input->get('tp')) ? $this->input->get('tp') : '' ;
		$mid = ($this->input->get('mid')) ? $this->input->get('mid') : '' ;

		if (empty($cid)) {
			redirect('admin/menu', 'refresh');
		}

		$menu = $this->Users_model->getData('menu_list', array('id' => $cid));

		if (empty($menu)) {
			redirect('admin/menu', 'refresh');
		}

		if ($this->input->post('menu_name')) {
			$post = $this->input->post();

			$fields = array(
				'menu_id' => $cid,
				'name' => $post['menu_name'],
				'link' => $post['menu_url'],
				'position' => $post['position'],
				'modified_date' => time(),
			);

			if (empty($tp) && empty($mid)) {
				$fields['created_date'] = time();
				$this->Users_model->insertData('menu_list_items', $fields);
				$this->session->set_flashData('msg_success', '<em>' . $this->input->post('menu_name') . '</em> successfully added.');
			} else {
				$this->Users_model->updateData('menu_list_items', array('id' => $mid), $fields);
				$this->session->set_flashData('msg_success', '<em>' . $this->input->post('menu_name') . '</em> successfully updated.');
			}
			redirect(base_url('admin/menu/lists?cid=' . $cid), 'refresh');
		}

		$this->commonData['activeMenues']['menuParent'] = 'menu';
		$this->commonData['activeMenues']['menuChild'] = 'list';

		if (!empty($tp) && !empty($mid)) {
			$this->commonData['title'] = "Menu List Items";
			$data = $this->Users_model->getData('menu_list_items', array('id' => $mid));
			if (empty($data)) {
				redirect('admin/menu/lists?cid=' . $cid, 'refresh');
			}
			$this->commonData['item'] = $data[0];
		} else {
			$this->commonData['title'] = "Menu List";
			$data = $this->Users_model->getData('menu_list_items', array('menu_id' => $cid));
			$this->commonData['content'] = $data;
		}
		$this->loadScreen('menu_item_list');
	}

	public function changeStat () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '';
		$mid = ($this->input->get('mid')) ? $this->input->get('mid') : '';
		$stat = ($this->input->get('stat') &&  $this->input->get('stat') == '1') ? '0' : '1';
		$tp = ($this->input->get('tp')) ? $this->input->get('tp') : '';

		if (empty($cid) || empty($mid) || empty($tp)) {
			redirect('admin/menu', 'refresh');
		}
		
		if ($tp == 'list_item') {
			$fields = array(
				'status' => $stat
			);
			$this->Users_model->updateData('menu_list_items', array('id' => $mid), $fields);
			redirect(base_url('admin/menu/lists?cid=' . $cid), 'refresh');
		}
	}

	public function delete () {
		$response = array('success' => false, 'msg' => 'Unable to process');
		$action = (isset($_GET['tp'])) ? $_GET['tp'] : '';
		$cid = (isset($_GET['cid'])) ? $_GET['cid'] : '';
		$mid = ($this->input->get('mid')) ? $this->input->get('mid') : '';
		
		if (empty($action) || empty($cid) || empty($mid)) {
			$this->session->set_flashdata('msg_error', 'Unable process');
			redirect(base_url('admin/menu'), 'refresh');
		}

		if ($action == 'list_item') {
			$this->Users_model->deleteData('menu_list_items', array('id' => $mid));
			$this->session->set_flashdata('msg_success', 'Menu item successfully deleted.');
			redirect(base_url('admin/menu/lists?cid=' . $cid), 'refresh');
		}
	}

}
