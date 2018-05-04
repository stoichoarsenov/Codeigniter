<?php

class Books_model extends CI_Model {
    //Limit on page
    private $limit=2; //private $var $limit

    public function __construct(){
        $this->load->database();
    }

    //Get book 
    //Example
    //Page 3
    //Begin at 15 - 20
    public function get_books($cat_id,$page){
        $start=($page*$this->limit)-1;
        return  $start; //$this->getBooksByCategory($cat_id,$start,$this->limit);
    }

     //Как да взема стойността на limit 
     //Взима всички Имена на книги, автори, описание, цена
     // category = 33
     //page = 1 
     //cnt = 1 
     public function getBooksByCategory($cat_id,$page,$limit,$order_by, $order_type, $get_total=true){     
        // echo $limit;  
        // var_dump($limit);
        if($page == 1)
        {
            $start = 0;
        }
        else
        {
            $start=($page*$limit)-$limit; 
            // var_dump($start);
        }

        $sql = "SELECT av_books.id, av_books.title, av_books.author, av_books.description, av_books.price ";
        $crit = "FROM av_books 
        LEFT JOIN av_category_book_links 
        ON av_category_book_links.object_id = av_books.id 
        WHERE av_category_book_links.external_id = ?";            
        // GROUP BY av_books.id "; ще го добавя в последствие
        
        $sql .= $crit;

        if(!empty($order_by) && !empty($order_type)){
            
            // $order_by = $this->db->escape_str($order_by);
            // $order_type = $this->db->escape_str($order_type);
            $orderSQl = ' ORDER BY av_books.'.mysqli_real_escape_string($this->db->conn_id,$order_by).' '.mysqli_real_escape_string($this->db->conn_id,$order_type).'';
            // var_dump($order_by);
            $sql .= $orderSQl;
        }
        $sql .= ' LIMIT ?, ? ';
        // избери всичко от av_books където av_category_book_links.object_id = av_books.id
        //                                  av_category_book_links.external_id = av_books_category_id

        //SQL -> Взима тайтъла Автора описанието и цената
        //crit -> Взима само тези, за които е изпълнено да са от дадена категория
        $maxPages=0;
        if($get_total){
            $sql_total = "SELECT COUNT(av_books.id) as cnt "; //select COUNT(id) as cnt 
            $sql_total .= $crit;
            $query_total =  $this->db->query($sql_total, array($cat_id));     
            // var_dump($sql_total);             
            $total_row=$query_total->result_array();
            
            foreach($total_row as $total_row_item)
            {
                $total_rows = $total_row_item;
            }
        }
        $maxPages = $total_rows['cnt'] / $limit;
        $limit = (int)$limit;
        
        $query =  $this->db->query  ($sql, array(
                                                    $cat_id,
                                                    $start,
                                                    $limit)
                                        ); // Да избере само тези, които отговарят на категорията
            
            $result=array();
            $result['maxPages']=$maxPages;
            $result['records']=$query->result_array();          
            return $result;
            
    }



    /*
    * Nai nakraq trqbva da dobavq ajax validaciq s jSon za unikalnost na imeto
    *
    *
    *
    *
    */


    
    public function set_book($insert_arr){
        $data = array(
            'title' => $insert_arr['title'],
            'author' =>  $insert_arr['author'],
            'description' =>  $insert_arr['description'],
            'price' =>  $insert_arr['price'],
            'date' => $insert_arr['date'],
        );
        $sqlInsert = "INSERT INTO av_books (title,author,description,price,date) VALUES (?,?,?,?,?);";
        $query =  $this->db->insert('av_books',$data);         
    }

    public function get_exact_book($id = NULL){
        $sql = "SELECT id, title, author, description, price FROM av_books where id = ?";
        $query_total =  $this->db->query($sql, array($id));
        $allBooks = $query_total->result_array();

        $getCategorySql = "SELECT external_id FROM av_category_book_links WHERE object_id=".$id."";
        $getCategoryQuerry =  $this->db->query($getCategorySql);
        $currentCategory = $getCategoryQuerry->result_array();
        $allBooks['currentCategory'] = $currentCategory[0]['external_id'];
        
        return $allBooks;
    }


    public function set_book_category($bookId,$categoryId){
        $data = array(
            'object_id' => $bookId,
            'external_id' => $categoryId,
        );
        return $this->db->insert('av_category_book_links',$data);
    }

    public function get_categories(){
        // $getCategoryItems
        $getCategoryQuerry = $this->db->get('av_category_books');
        $getCategory['category'] = $getCategoryQuerry->result_array();
        // var_dump($getCategory['category']);exit();
        foreach ($getCategory['category'] as $category_item_id_array){
            // $getCategory['category_item_id']  = $category_item_id_array['id'];
            $sqlId = $category_item_id_array['id'];
            $sql = "SELECT COUNT(av_books.id) AS TotalRows FROM av_books LEFT JOIN av_category_book_links ON av_category_book_links.object_id = av_books.id WHERE av_category_book_links.external_id = '$sqlId'";
            // echo $sql.'</br>';
            $sqlQuerry =  $this->db->query($sql);
            $itemsPercategory = $sqlQuerry->result_array();
            // var_dump($itemsPercategory[0]['TotalRows']);
            $getCategory['category_item_id'][] = $itemsPercategory[0]['TotalRows'];
            // var_dump($getCategory['category_item_id']);
       } 
        // var_dump($getCategory['category'][2]['title']);
        return  $getCategory;
    }


    public function get_total_records(){
        $totalRecordsSql = "SELECT COUNT(id) FROM av_books";
        $query = $this->db->query($totalRecordsSql);

        if($query->result_array() > 0 ){
            return $query->result_array();
        }
        else{
            echo 'asd';
        }
    }
    
    public function getPriceById($id){
        if(empty($id)){
           echo 'DIDNT FIDNT ID IN getPriceById </br>';
        }
        $itemPriceSql = "SELECT price from av_books where id = ?";
        $itemPrice = $this->db->query($itemPriceSql, $id);
        $price = $itemPrice->result_array();
        return $price;
    }
}