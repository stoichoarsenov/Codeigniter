<?php

class Cart_model extends CI_Model {
    //Limit on page
    // var items;
    

    public function __construct(){
        $this->load->database();
        $this->load->library('session');
        $this->load->model('books_model');
        // $this->items=$this->getItemsFromSession();
    }

    public function getItems($update_from_session=false){
        // if($update_from_session){
            // $this->items=$this->getItemsFromSession();
        // }
        // return $this->items;
    }

    public function updateSession(){
        // session cart_items = this-> items 
    }  
    
    public function getTotalPrice(){

    }  
    
    public function updateItesmCount($index){


        $this->updateSession();
    }  

    public function removeItem($index){

        $this->updateSession();
        
    }  

/*
INDEX???
*/

    public function addItem($index){
        $data = $this->input->post();
        if(!isset($data)){
            exit('няма намерени резултати в POST');
        }
        
        $quantity = $data['quantity'];
        $itemId = $data['itemId'];
        $itemId = (int)$itemId;
        $quantity = (int)$quantity;
        $bookInfo = $this->books_model->get_exact_book($itemId);

        

        // var_dump($bookInfo[0]);exit();
     
        $title = $bookInfo[0]['title'];
        $author = $bookInfo[0]['author'];
        $price = $bookInfo[0]['price'];

        if($quantity < 1){
            $quantity = 1;
        }
        $totalPrice = $price * $quantity;        if(array_key_exists('addToCartItem',$_SESSION)){
            $quantity += $_SESSION['addToCartItem'][$itemId]['quantity'];
            $_SESSION['addToCartItem'][$itemId] = array(
                                                'id' => $itemId,
                                                'title' => $title, 
                                                'quantity' => $quantity, 
                                                'price' => $price,
                                                'total_price' => $totalPrice);
            $message = "Added";
            
        } else {
        $_SESSION['addToCartItem'][$itemId] = array(
                                'id' => $itemId,
                                'title' => $title, 
                                'quantity' => $quantity, 
                                'price' => $price,
                                'total_price' => $totalPrice);
                                $message = "Created";
        }
        $ajax_result = array(
            'data' => $message
        );
        

        if($this->input->is_ajax_request()){
            error_reporting (0);
            echo json_encode($ajax_result);
        }
        
        else{
            echo 'NON AJAX MODE :<br /><br /><pre>';
            print_r($ajax_result);
            echo '</pre>';
        }

        exit(1);
        
        
        
    }  


    
}