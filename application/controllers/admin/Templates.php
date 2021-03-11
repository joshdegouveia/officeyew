<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * 
 */
class Templates extends AdminController{

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
	public function resellerVoucher () {
		$this->commonData['activeMenues']['menuParent'] = 'templates';
		$this->commonData['activeMenues']['menuChild'] = 'reseller-voucher';

		$this->commonData['title'] = "Reseller Voucher Templates";
		$content = $this->Users_model->getData('voucher_template');
		$this->commonData['content'] = $content;

		$this->loadScreen('reseller_voucher_template');
	}

	public function resellervoucherEdit () {
		$pid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($pid)) {
			redirect('admin/templates/resellervoucher', 'refresh');
		}

		$this->resellervoucherAdd($pid);
	}

	public function resellervoucherAdd ($pid = '') {
		$this->commonData['activeMenues']['menuParent'] = 'templates';
		$this->commonData['activeMenues']['menuChild'] = 'reseller-voucher';

		$this->commonData['title'] = "Voucher Template Add";
		$data = array();
		$user = $this->ion_auth->user()->row();

		if (!empty($pid)) {
			$this->commonData['title'] = "Voucher Template Edit";
			$data = $this->Users_model->getData('voucher_template', array('id' => $pid));
			if (empty($data)) {
				redirect('admin/templates/resellervoucher', 'refresh');
			}
			$data = $data[0];
		}

		if ($this->input->post('name')) {
			$post = $this->input->post();

			$fields = array(
				'name' => trim($post['name']),
				'template' => $post['template'],
				'description' => $post['description'],
				'modified_date' => time(),
			);

			if (!empty($pid)) {
				$this->Users_model->updateData('voucher_template', array('id' => $pid), $fields);
				$this->session->set_flashData('msg_success', 'Voucher template successfully updated.');
			} else {
				$fields['created_date'] = time();
				$this->Users_model->insertData('voucher_template', $fields);
				$this->session->set_flashData('msg_success', 'Voucher template successfully added.');
			}

			redirect(base_url('admin/templates/resellervoucher'), 'refresh');
		}

		$this->commonData['content'] = $data;

		$this->loadScreen('reseller_voucher_template_add');
	}

	public function changeStat () {
		$action = ($this->input->get('act')) ? $this->input->get('act') : '' ;

		if (empty($action)) {
			redirect('admin/dashboard', 'refresh');
		}

		$stat = ($this->input->get('stat') &&  $this->input->get('stat') == '1') ? 0 : 1;
		$fields = array(
			'status' => $stat
		);
		$id = 0;
		$table = '';
		$return = '';

		switch ($action) {
			case 'resellervouche':
				$id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;
				$table = 'voucher_template';
				$return = 'resellervoucher';
				break;			
		}

		if ($id == 0) {
			redirect('admin/dashboard', 'refresh');
		}

		$this->Users_model->updateData($table, array('id' => $id), $fields);
		redirect('admin/templates/' . $return, 'refresh');
	}

	public function delete () {
		$action = ($this->input->get('act')) ? $this->input->get('act') : '' ;
		$id = ($this->input->get('cid')) ? $this->input->get('cid') : 0;

		if (empty($action) || $id == 0) {
			redirect('admin/dashboard', 'refresh');
		}

		switch ($action) {
			case 'resellervoucher':
				$this->Users_model->deleteData('voucher_template', array('id' => $id));
				$this->session->set_flashData('msg_success', 'Template successfully deleted.');
				redirect('admin/templates/resellervoucher', 'refresh');
				break;
		}

		redirect('admin/dashboard', 'refresh');
	}

}
