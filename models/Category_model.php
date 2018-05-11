<?php

class Category_model extends CI_Model {

    public $prio;
    public $title;
    public $keyword;
      
    public function __construct(){
        $this->load->database();
    }
    
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

    public function get_category(){

        $query = $this->db->get('av_category_books');
        $queryResult = $query->result_array();
        foreach($queryResult as $key => $queryResult_item){
            $category[$key]['id'] = $queryResult_item['id'];
            $category[$key]['date'] = $queryResult_item['date'];
            $category[$key]['prio'] = $queryResult_item['prio'];
            $category[$key]['title'] = $queryResult_item['title'];      
            $category[$key]['keyword'] = $queryResult_item['keyword'];  
        }
        return $category;

    }

    public function set_category(){
        $data = array(
            'prio' => $this->input->post('Prio', true),
            'title' => $this->input->post('Title', true),
            'keyword' => $this->input->post('Keyword' ,true),
            'date' => date('Y-m-d H:i:s'),
        );
        
        return $this->db->insert('av_category_books', $data);
    }
}