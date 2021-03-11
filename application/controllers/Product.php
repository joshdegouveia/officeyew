    <?php
    	class Product extends BaseController {
            public function __construct() {
                parent::__construct();
                $this->load->model('Users_model');
                $this->load->model('Product_model');
                $this->load->model('Login_model');
                $this->load->library('image_lib');
            }

            public function getallproducts(){
                $limit['limit'] = ITEM_PRODACT_LG;
                $limit['offset'] = (($currentPage - 1 ) * ITEM_PRODACT_LG);
                $orderBy['orderBy'] = 'p.is_boost';
                $orderBy['type'] = 'DESC';
                $la_all_products = $this->Product_model->getProductList('', 0, $limit, '', '', '', $orderBy);
                $response['data'] = $la_categoey;
                $response['success'] = true;
                echo json_encode($response);
        
            }
        }
    ?>