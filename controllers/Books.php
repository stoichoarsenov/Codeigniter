<?php

class Books extends CI_Controller{

    public $cartItemCount;
    public $category;
    public $totalPrice;

public function __construct(){
    
    parent::__construct();
    
    $this->load->library('session');
    $this->load->model('cart_model');
    $this->load->model('books_model');
    $this->load->helper('url_helper');
    $this->totalPrice = $this ->cart_model->getTotalPrice();
    $this->cartItemCount = $this->getSessionQuantityData();
    $this->category = $this->getCategories();


}

public function index()
{
       $result['categories'] = $this->books_model->get_categories();
    //    var_dump($result['categories']);
       if(count($result['categories'])>0){
            redirect('books/page/'.$result['categories'][0]['id'].'/1');        
       }
       

}


public function page($cat,$page=1,$records_per_page=2,$order_by="",$order_type="",$pagesCount="3") {   


    if(empty($order_type)){
        $order_type = "asc";
    }

    if(empty($order_by) || ($order_by != "title" && $order_by != "author" && $order_by != "price")){
        $order_by = "price";
    }

    if(empty($order_type) || ($order_type != "asc" && $order_type != "desc")){
        $order_type = "asc";
    }

    if(empty($records_per_page)){
        $records_per_page = 2;
    }
    
    // var_dump();exit();

    $result['recordsPerPage'] = $records_per_page;

    $result['ordery_by'] = $order_by;
    $result['ordery_type'] = $order_type;
    
    $result['cat']=$cat;
    $result['page']=$page;
    $result['prevPage']=1;
    $result['nextPage']=1;
    $booksByCat = $this->books_model->getBooksByCategory($cat,$page,$records_per_page,$order_by,$order_type);
    $result['books'] = $booksByCat['records'];
    $categories = $this->books_model->get_categories();
    
    // $result['categories'] = $categories;
    // var_dump($categories);
    $result['maxPages'] = floor($booksByCat['maxPages']);
    $maxPages = floor($result['maxPages']); 



    // var_dump($result['maxPages']);exit();
    if($maxPages==0)$maxPages=1;

    if($page > 1 ){
        $result['prevPage']=$page-1;
    }
    else{
        $result['prevPage']= 1;
    }
    if($page < $maxPages){
        $result['nextPage']=$page+1;
    }
    else{
        $result['nextPage'] = $maxPages;
    }

    if($page < 0 || $page > $maxPages){
        // $page=1;
        echo 'Няма подходящи резултати';
        exit();
    }
    $page=intval($page);
    $cat=intval($cat);
    if($page==0 || $cat==0){
        echo 'Няма подходящи резултати';
        exit();
    }
    $result['pageCount'] = $pagesCount;
    $result['totalPrice'] = $this->totalPrice;
    $result['category'] = $this->category;
    $result['count'] = $this->cartItemCount;
    $this->load->view('books/pages', $result);
}

//Функция за категориите и техните бройки

public function getCategories(){
    $categories = $this->books_model->get_categories();
    foreach($categories['category'] as $item){
        $categoryTitle['title'][] = $item;
    }
    foreach($categories['category_item_id'] as $itemId){
        $categoryTitle['itemId'][] = $itemId;
    }
    return $categoryTitle;
}




public function getExactBook($id = NULL){
    if(empty($id)){
        $id = 1;
    }

    $data = $this->books_model->get_exact_book($id);
    // var_dump($data);exit();
    
    if(!empty($data)){
    $data['result'] = $data[0];   
    }

    else{
        redirect(base_url()."books/getexactbook/70");
    }



    $category = $this->books_model->get_categories();
    foreach($category as $category_item){
       $data['categories'][] = $category_item;

    }
    $data['totalPrice'] = $this->totalPrice;
    $data['category'] = $this->category;
    $data['count'] = $this->cartItemCount;
    $this->load->view('books/getExactBook', $data); 

}

    /*
        Proverka dali se sesiqta e prazna 
        dopulva sesiqta s masiv ot dannni 
        dannite sa za : Id Title Broika Price i total price
        proverka za cenata na artikula
    */

    /*
    $itemId -> book item id
    $quantity -> quantity
    */

    public function setSesssionData(){
        // var_dump($_SESSION);
        $itemId = $this->input->post('itemId');
        $itemId = (int)$itemId;
        $quantity = $this->input->post('quantity');
        $quantity = (int)$quantity;
        // var_dump($quantity); exit();
        if(!isset($itemId)){
            exit('няма намерени резултати в POST');
        }

        if($quantity < 1){
            $quantity = 1;
        }

        $sessionData = array(
                'itemId' => $itemId,
                'quantity' => $quantity
        );

        


        $ajax_result = array(
            'data' => $this->cart_model->addItem($sessionData)
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

    /* 
    Вземам броя на артикулите в количката
    би трябвало да успея да добавя ново view, което да ми показва колко артикула имам добавени в количката

    */
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
    // $this->load->view('books/cartQuantity',$data);
    }

    public function setItemQuantity($book_id, $quantity){
        if(empty($quantity) || empty($book_id)){
                redirect('/books/printSessionItems');
            }
        else{
            $ajax_result = array(
                'updated_items' => $this->cart_model->updateItemsCount($book_id, $quantity),
            );
            // var_dump($this->input->is_ajax_request());exit();
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


    /*
    извеждане на количката
    */
    public function printSessionItems(){

        $items = $this->cart_model->getItemsFromSession();
        if(empty($items)){
            redirect('http://www.test.com:8080/books/page/33');
        }
            $items['totalPrice'] = $this->totalPrice;
            $items['category'] = $this->category;
            $items['count'] = $this->cartItemCount;
            $this->load->view('books/printSessionItems', $items);
    }

    




    //Remove item from shopping cart 
    //than return to the Shopping cart view
    // @param $itemId 

    public function removeItemsFromSession($book_id){

        // var_dump($book_id);exit();

        $ajax_result = array(
            'data' => $this->cart_model->removeItem($book_id)
        );
        // var_dump($this->input->is_ajax_request());exit();
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





// public function getItemsAddedInCartCount(){
//     $countitemsAddedInCart = 0;
//     $session  = $_SESSION['addToCartItem'];
//     foreach($session as $key => $item)
//     {        
//         $countitemsAddedInCart++;
//         // echo $item['id'].'</br>';
//     }
//     return $countitemsAddedInCart;
//     //    set ... getItemsAddedInCartCount...
// }


public function getBooksByCategory($id = NULL){
    $categoryId = $this->input->post('category',true);
    $data['exactBooks'] = $this->books_model->getBooksByCategory($id);
    // var_dump($data['exactBooks']);exit();
    if(count($data['exactBooks']>0)){
            echo 'Няма съществуващи записи';
    }

    $this->load->view('templates/header');
    $this->load->view('books/getBooksByCategory', $data); 
    $this->load->view('templates/footer');  
    // $this->session->sess_destroy();

}

 //Създаване на нова книга

    public function create(){
        $this->load->helper('form');
        $this->load->library('form_validation');
        $data['categoryies'] = $this->books_model->get_categories();
        $categoryId = $this->input->post('category',true);
        
        if(!empty($_POST)){

            $insert_arr['title'] = trim($_POST['title']);
            $insert_arr['author'] = trim($_POST['author']);
            $insert_arr['description'] = trim($_POST['description']);
            $insert_arr['price'] =  trim($_POST['price']);
            $insert_arr['category'] = trim($_POST['category']);
            $insert_arr['date'] = trim(date('Y-m-d H:i:s'));

            
            $this->books_model->set_book($insert_arr);
            // echo $error;
            $bookId = $this->db->insert_id();
            $this->books_model->set_book_category($bookId,$categoryId);
            redirect('books/getexactbook/'.$bookId);
        }


        else {
            $data['totalPrice'] = $this->totalPrice;
            $data['category'] = $this->category;
            $data['count'] = $this->cartItemCount;                                         
            $this->load->view('books/create', $data);
    
        }

    }

//Използва се при създаването на книга 
//Прави проверка в базата дани дали има книга със същото име
//и съответно връща съобщение 


    public function checkTitle($title){
        $query = "SELECT * FROM av_books WHERE `title` = ?";
        $params = array( $title );
        $result = $this->db->query( $query, $params );
        
        
        if( $result->num_rows() === 0 ) {
            $message = "success";
        } else {
            $message = "Името вече е заето";
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