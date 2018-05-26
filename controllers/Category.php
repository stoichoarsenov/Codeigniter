<?php
class Category extends CI_controller{

    private $cartItemCount;
    private $totalPrice;
    private $category;
    private $isLogged;
    private $getUsername;


    public function __construct(){
        parent::__construct();
        $this->load->library('session');



        $this->load->model('category_model');
        $this->load->model('cart_model');
        $this->load->model('user_model');
        
        $this->totalPrice = $this ->cart_model->getTotalPrice();
        $this->cartItemCount = $this->cart_model->getSessionQuantityData();
        $this->isLogged = $this->user_model->isLogged();
        $this->getUsername = $this->user_model->getUsername();
        }    
        

        
    
    public function index(){
       // $data['category'] = $this->category_model->get_category();  
        // $category = $data['category'];
        // var_dump($data['category']);
        // foreach ($data['category'] as $data_item){
            // print_r($data_item['title']); exit();
        // }
        $category['category'] = $this->category_model->get_category();
        // print_r($category);exit();

        foreach($category as $category_item){
            echo 'Категория : '.$category_item['title'].'</br>';
        }
        

       

        $this->load->view('category/index', $category); 
        }

        
        public function createCategory(){

           
            $category['totalPrice'] = $this->totalPrice;
            $category['category'] = $this->category;
            $category['count'] = $this->cartItemCount;
            $category['isLogged'] = $this->isLogged;
            $category['currUserName'] = $this->getUsername;

            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('Prio', 'Prio', 'required|integer|max_length[11]'); 
            $this->form_validation->set_rules('Title', 'Title', 'required|min_length[5]|max_length[255]|is_unique[av_category_books.title]'); 
            $this->form_validation->set_rules('Keyword', 'Keyword', 'required|min_length[5]|max_length[255]');
        
            if ($this->form_validation->run() === FALSE)
            {

                $this->load->view('category/createCategory' , $category);
        
            }
            else
            {
                $this->category_model->set_category();
                $this->load->view('category/success' , $category);
            }

        }
        
}