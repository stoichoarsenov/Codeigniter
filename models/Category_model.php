<?php

class Category_model extends CI_Model {

    public $prio;
    public $title;
    public $keyword;
      
    public function __construct(){
        $this->load->database();
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
        // var_dump($category);exit();
        
        // var_dump($category);exit();
        
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