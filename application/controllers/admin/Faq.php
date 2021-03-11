<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Faq
 * 
 */
class Faq extends AdminController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Users_model');
		
		if ( $this->userLogged() == false ){
			// redirect them to the login page
			redirect('admin/auth/login', 'refresh');
			exit;
		}
	}

	public function Categories () {
		$this->commonData['activeMenues']['menuParent'] = 'faq';
		$this->commonData['activeMenues']['menuChild'] = 'faq-category';

		$this->commonData['title'] = "FAQ Categories";
		$faq = $this->Users_model->getData('faq_category');
		$this->commonData['faq'] = $faq;

		$this->loadScreen('faq_category');
	}

	public function categoryEdit () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($cid)) {
			redirect('admin/faq/categories', 'refresh');
		}

		$this->categoryAdd($cid);
	}

	public function categoryAdd ($cid = '') {
		$this->commonData['activeMenues']['menuParent'] = 'faq';
		$this->commonData['activeMenues']['menuChild'] = 'faq-category';

		$this->commonData['title'] = "FAQ Category";
		$faq = array();

		if (!empty($cid)) {
			$faq = $this->Users_model->getData('faq_category', array('id' => $cid));
			if (empty($faq)) {
				redirect('admin/faq/categories', 'refresh');
			}
			$faq = $faq[0];
		}

		if ($this->input->post('name')) {
			$post = $this->input->post();

			$fields = array(
				'name' => $post['name'],
				'modified_date' => time(),
			);

			if (!empty($cid)) {
				$this->Users_model->updateData('faq_category', array('id' => $cid), $fields);
				$this->session->set_flashData('msg_success', 'FAQ category successfully updated.');
			} else {
				$fields['created_date'] = time();
				$this->Users_model->insertData('faq_category', $fields);
				$this->session->set_flashData('msg_success', 'FAQ category successfully added.');
			}

			redirect(base_url('admin/faq/categories'), 'refresh');
		}

		$this->commonData['faq'] = $faq;
		$this->loadScreen('add_faq_category');
	}

	public function categoryDelete () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($cid)) {
			redirect('admin/faq/categories', 'refresh');
		}

		$this->Users_model->deleteData('faq_category', array('id' => $cid));
		$this->session->set_flashdata('msg_success', 'FAQ category deleted successfully.');
		redirect('admin/faq/categories', 'refresh');
	}

	public function items () {
		$this->commonData['activeMenues']['menuParent'] = 'faq';
		$this->commonData['activeMenues']['menuChild'] = 'faq-item';

		$this->commonData['title'] = "FAQ Item List";
		$faq = $this->Users_model->getData('faq_items');
		$this->commonData['faq'] = $faq;

		$this->loadScreen('faq_items');
	}

	public function itemEdit () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;

		if (empty($cid)) {
			redirect('admin/faq/items', 'refresh');
		}

		$this->itemAdd($cid);
	}

	public function itemAdd ($cid = '') {
		$this->commonData['activeMenues']['menuParent'] = 'faq';
		$this->commonData['activeMenues']['menuChild'] = 'faq-item';

		$this->commonData['title'] = "FAQ Items";
		$faq = array();

		if (!empty($cid)) {
			$faq = $this->Users_model->getData('faq_items', array('id' => $cid));
			if (empty($faq)) {
				redirect('admin/faq/items', 'refresh');
			}
			$faq = $faq[0];
		}

		if ($this->input->post('answer')) {
			$post = $this->input->post();

			$fields = array(
				'category_id' => $post['category'],
				'question' => $post['question'],
				'answer' => $post['answer'],
				'modified_date' => time(),
			);

			if (!empty($cid)) {
				$this->Users_model->updateData('faq_items', array('id' => $cid), $fields);
				$this->session->set_flashData('msg_success', 'FAQ item successfully updated.');
			} else {
				$fields['created_date'] = time();
				$this->Users_model->insertData('faq_items', $fields);
				$this->session->set_flashData('msg_success', 'FAQ item successfully added.');
			}

			redirect(base_url('admin/faq/items'), 'refresh');
		}

		$faq_category = $this->Users_model->getData('faq_category', array('status' => 1), 'id, name');

		$this->commonData['faq'] = $faq;
		$this->commonData['faq_category'] = $faq_category;
		$this->loadScreen('add_faq_item');
	}

	public function changeStat () {
		$cid = ($this->input->get('cid')) ? $this->input->get('cid') : '' ;
		$stat = ($this->input->get('stat') &&  $this->input->get('stat') == '1') ? '0' : '1' ;

		if (empty($cid)) {
			redirect('admin/faq/items', 'refresh');
		}
		
		$fields = array(
			'status' => $stat
		);
		$this->Users_model->updateData('faq_items', array('id' => $cid), $fields);
		redirect('admin/faq/items', 'refresh');
	}

}
