<?php
defined('BASEPATH') OR exit('No direct script access allowed');
   
class StripeController extends CI_Controller {
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function __construct() {
       parent::__construct();
       $this->load->library("session");
       $this->load->helper('url');
    }
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function index()
    {
        $this->load->view('my_stripe');
    }
       
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function stripePost()
    {
		
        require_once('application/libraries/stripe-php/init.php');
    
        \Stripe\Stripe::setApiKey($this->config->item('stripe_secret'));
     
	 // Add customer to stripe
    $customer = \Stripe\Customer::create(array(
        'email' => 'test@stripe.com',
        'source'  => $this->input->post('stripeToken'),
"address" => ["city" => 'Kolkata', "country" => 'IN', "line1" => '14 MP Road', "line2" => "", "postal_code" => '700067', "state" => 'WB']

    ));

        \Stripe\Charge::create ([
		"customer" =>$customer->id,
		/*"address['line1']"="510 Townsend St" ,
  "address[postal_code]"="700067" ,
  "address[city]"="Kolkata",
  "address[state]"="WB",
  "address[country]"="IN",*/

                "amount" => 100 * 100,
                "currency" => "rs",
                "source" => $this->input->post('stripeToken'),
                "description" => "Test payment from itsolutionstuff.com." 
        ]);
            
        $this->session->set_flashdata('success', 'Payment made successfully.');
             
        redirect('/my-stripe', 'refresh');
    }
}
