<?php
class Category extends CI_controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('category_model');
        $this->load->helper('url_helper');

    }
        
    
    public function index(){
       // $data['category'] = $this->category_model->get_category();  
        // $category = $data['category'];
        // var_dump($data['category']);
        // foreach ($data['category'] as $data_item){
            // print_r($data_item['title']); exit();
        // }
        $category = $this->category_model->get_category();
        // print_r($category);exit();

        foreach($category as $category_item){
            echo 'Категория : '.$category_item['title'].'</br>';
        }

        $this->load->view('templates/header');
        $this->load->view('category/index', $category); 
        $this->load->view('templates/footer');
        }

        
        public function createCategory(){
        
            $this->load->helper('form');
            $this->load->library('form_validation');

            $this->form_validation->set_rules('Prio', 'Prio', 'required|integer|max_length[11]'); 
            $this->form_validation->set_rules('Title', 'Title', 'required|min_length[5]|max_length[255]|is_unique[av_category_books.title]'); 
            $this->form_validation->set_rules('Keyword', 'Keyword', 'required|min_length[5]|max_length[255]');
        
            if ($this->form_validation->run() === FALSE)
            {
                $this->load->view('templates/header');
                $this->load->view('category/createCategory');
                $this->load->view('templates/footer');
        
            }
            else
            {
                $this->category_model->set_category();
                $this->load->view('category/success');
            }

        }
        
}