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

    //
    public function getItemsFromSession(){
        
        if(array_key_exists('addToCartItem',$_SESSION)){
            $sessionItems = $_SESSION['addToCartItem'];
           

                foreach($sessionItems as $value){
                    // print_r($value);
                    $items['items'][] = $value;
                    // echo '<pre> items: </br> ',print_r($items['items'],1),'</pre>';
                }
            }
            // echo '<pre> bookInfo: </br> ',print_r($bookInfo,1),'</pre>';
            if(!empty($_SESSION['addToCartItem'])){
                    foreach($_SESSION['addToCartItem'] as $itemKey => $item){
                        $bookInfo[] = $this->books_model->get_exact_book($sessionItems[$itemKey]['id']);
                        // $items['price'][] = $items['items'][1]['quantity'] * $bookInfo[][]['price'];
                    }
                $items['bookInfo'] = $bookInfo;
            }
           
            foreach($items['bookInfo'] as $key  => $val){
                $items['itemTotalPrice'][] = $items['items'][$key]['quantity'] * $items['bookInfo'][$key][0]['price'];
                $items['quantity'][] = $items['items'][$key]['quantity'];
            }
            return $items;
        }


   
    public function updateSession(){
        // session cart_items = this-> items 
    }  


    /*
    return : Total price for all items;
    */
    public function getTotalPrice(){
        $totalPrice = 0;
        // var_dump($_SESSION['addToCartItem']);
        if(!empty($_SESSION['addToCartItem'])){
            
            
            foreach($_SESSION['addToCartItem'] as $item){
                    $itemPrice = $this->books_model->getPriceById($item['id']);
                    // var_dump($itemPrice[0]['price']);    
                        $totalItemPrice = $itemPrice[0]['price'] * $item['quantity']; 
                       
                     $totalPrice += $totalItemPrice;   
            }
        }
        else{
            $totalPrice = 0;
        }
        return $totalPrice;
    }
    
    /*
    При промяна на бройката в количката да се увеличава броя на книгите следователно и цената и крайната цена!
    */
    public function updateItemsCount($itemId, $quantity){
        if (empty($itemId) || empty($quantity)){
            $message = 'empty';
        }

        else{
        // Проверка за кой артикул става дума : 
        //
        // echo $itemId;
        foreach($_SESSION['addToCartItem'] as $key => $item){
            if($item['id'] == $itemId){
                $sessionKey = $key;
            }
        }
            $_SESSION['addToCartItem'][$sessionKey]['quantity'] = $quantity;
            // echo '<pre>'.print_r($_SESSION['addToCartItem']).'</pre>';
            $message['id'] = $itemId;
            $message['quantity'] = $quantity;
            $totalPrice = $this->getTotalPrice();
            // print_r($itemTotalPrice);
            $message['totalPrice'] = $totalPrice; 
            return $message;         
        }
    }

        // return $message;

        // $this->updateSession();
    // }  

    public function removeItem($index){
        $message = "";
        $book_id = $index;
        $removeId = 0;
        
        if (!empty($book_id)){
            $book_id = (int)$book_id;

            foreach($_SESSION['addToCartItem'] as $key => $value) {
                if($book_id == $value['id']){
                    $removeId = $key;
                }
            }
            
                if($removeId >= 0){
                    unset($_SESSION['addToCartItem'][$removeId]);
                    $message = "deleted";
                } 
            }
        else{
                $message = "shopping cart is empty";
        }
        
        return $message;
        // $this->updateSession();
        
    }  

/*
INDEX???
*/

    public function addItem($index){
        // var_dump($_SESSION);
        // var_dump($index);exit();
        $itemId = $index['itemId'];
        $quantity = $index['quantity'];
        $tempQuantity = 0;

        if(empty($_SESSION['addToCartItem'])){
            $_SESSION['addToCartItem'][] = array(
                                                'id' => $itemId, 
                                                'quantity' => $quantity
                                                );
                            return "Added";
        }else{
            
            $found_key = array_search($itemId, array_column($_SESSION['addToCartItem'], 'id'));
            
            if($found_key !== false)
            {
                
                

                if(isset($_SESSION['addToCartItem'][$found_key]))
                {
                    $_SESSION['addToCartItem'][$found_key]['quantity'] += $quantity;
                }

                $message['totalPrice'] = $this->getTotalPrice();
                $message['quantity'] = $quantity;
                $message['message'] = "quantity";
                       
                return $message;
            }
            else
            {
                $count = 0;
                $sessionItems = $_SESSION['addToCartItem'];
                foreach($sessionItems as $key =>$item){
                    $count++;
                }
                // var_dump($count);
                
                $_SESSION['addToCartItem'][] = array(
                                                'id' => $itemId, 
                                                'quantity' => $quantity
                                                );
                
                $message['totalPrice'] = $this->getTotalPrice();
                $message['quantity'] = $quantity;
                $message['count'] = ++$count;                                   
                $message['message'] = "new";
                return $message;
            }

        }
    }
 

    
}