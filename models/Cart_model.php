<?php
// namespace application\models;


class Cart_model extends CI_Model {
    //Limit on page
    // var items;
    

    public function __construct(){
        $this->load->database();
        $this->load->library('session');
        $this->load->model('books_model');
    }



    /**
     * The function get all items from session
     * it is used in PrintSessionItems
     * 
     * @param Array $value
     * It is used to get the total value of items 
     * in this array there are two variables -> item ID and item quantity
     * 
     * @param Array $bookInfo
     * Also multidimensional array
     * It stores id, title, author, description and price
     * there is also dimension for current category ->
     * 
     * @param Array $items 
     * collect all information about item
     * 
     * @return Array 
     */
    
    public function getItemsFromSession(){
        // Check if there is item in the cart alredy. 
        //
        if(array_key_exists('addToCartItem',$_SESSION)){
            $sessionItems = $_SESSION['addToCartItem'];
        
            foreach($sessionItems as $value){
                $items['items'][] = $value;
            }
        }
          
        //If there is already item in the cart
        //it returns information to Cart_model with the new data
        if(!empty($_SESSION['addToCartItem'])){
        
            foreach($_SESSION['addToCartItem'] as $itemKey => $item){
                    $bookInfo[] = $this->books_model->get_exact_book($sessionItems[$itemKey]['id']);
                }
            $items['bookInfo'] = $bookInfo;
        // }
           
            foreach($items['bookInfo'] as $key  => $val){
                $items['itemTotalPrice'][] = $items['items'][$key]['quantity'] * $items['bookInfo'][$key][0]['price'];
                $items['quantity'][] = $items['items'][$key]['quantity'];
            }
        }


            return $items;
        }

        public function getSessionQuantityData(){
                $count = 0;
                if(!array_key_exists('addToCartItem',$_SESSION)){
                    $data['count'] = 0;
                } else {
                        $sessionItems = $_SESSION['addToCartItem'];
                            foreach($sessionItems as $key =>$item){
                                $count ++;
                            }
                $data['count'] = $count;
                }
                return $count;
            }
 



    /**
     * return : Total price for all items; 
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
         
            $itemPrice = $this->books_model->getPriceById($itemId);
           
            $_SESSION['addToCartItem'][$sessionKey]['quantity'] = $quantity;
            $totalPriceForItem = $itemPrice[0]['price'] * $quantity;
            $message['id'] = $itemId;
            $message['quantity'] = $quantity;
            $totalPrice = $this->getTotalPrice();
            $message['totalPriceForItem'] = $totalPriceForItem;
            $message['totalPrice'] = $totalPrice; 
            return $message;         
        }
    }

    /**
     * Изчистване на цялата количка
     * @return string  
     */
    public function clearCart(){
        $message = "";
        if(isset($_SESSION['addToCartItem'])){
            unset($_SESSION['addToCartItem']);
            $message = "deleted";
        }
        else{                               
            $message = "shopping cart is empty";
        }
        return $message;                       
    }


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

    /**
    * запазване на ифнормация за продуктите и кой ги е добавил (id на потребителя)
    * запазват се следните данни id (primary) ... 
    * created_by (последното въведено id - на потребителя)
    * product_id 
    * quantity
    * price
    */
    public function setUserProduct($createdBy, $productId, $quantity, $totalPrice, $dateAdded){
    
        $productInformationSql = array(
                            'createdBy'     => $createdBy, 
                            'productId'     => $productId,
                            'quantity'      => $quantity,
                            'totalPrice'    => $totalPrice,
                            'dateAdded'     => $dateAdded
        );
                            
            $sql = $this->db->insert('st_order_product', $productInformationSql);
            // var_dump($sql);
            if($sql)
            {
                return true; // to the controller
            }
            else{
                return false;
            } 
        
    }


        // $sql = $this->db->insert('st_order_customer', $insertNewUserSQL)
    
    // }
 

    
}