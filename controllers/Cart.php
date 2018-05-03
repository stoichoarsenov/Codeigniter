<?php

class Cart extends CI_Controller{



public function __construct(){
    
    parent::__construct();
    $this->load->library('session');
    $this->load->model('books_model');
    $this->load->model('cart_model');
    
    $this->load->helper('url_helper');


}

public function index()
{
       $result['items'] = $this->cart_model->getItems();
       $this->load->view('cart', $result); 
}


public function order(){
    $this->load->view('order', $result); 

}

public function getTotalPriceAsync(){
    // json -> total price
}




}