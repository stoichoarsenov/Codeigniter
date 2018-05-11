<?php

class User_model extends CI_Model {

    public function __construct(){
        $this->load->database();
    }

    /**
     * Запазаване на информацията за потребителя
     * @return BOOLEAN взависимост дали е изпъленан заявката
     * 
     */
    public function setUserInfo($name, $familyName, $txtEmail, $number, $adress, $currentTime, $totalPrice, $comment = NULL, $office, $city){
        $error = false;

        if (empty($name) || empty($familyName) || empty($txtEmail) || empty($number) || empty($adress) || empty($currentTime || empty($totalPrice))){
            $error = true;
        }

        

        /**
         * Добавяне на информация за user ако не същестува
         */
        $insertNewUserSQL = array (
                        'Name'        => $name,
                        'FamilyName'  => $familyName,
                        'Mail'        => $txtEmail,
                        'PhoneNumber' => $number,
                        'Address'     => $adress,
                        'Comment'     => $comment,
                        'office'      => $office,                
                        'city'        => $city,      
                        'Time'        => $currentTime,
                        'totalPrice'  => $totalPrice
        );

        $this->db->insert('st_order_customer', $insertNewUserSQL);
        if($this->db->affected_rows() > 0)
        {
            $error = false;; // to the controller
        }
        else{
            $error = true;
        } 
        
        return $error;
    }


    public function setUserRegistration($username, $usrFamName, $password, $phoneNumber, $email){
        $success = true;
        $date = date("Y-m-d H:i:s");
        $insertUserAccInfoSql = array(
                                    'username'     => $username,
                                    'usrFamName'   => $usrFamName,
                                    'password'     => $password,
                                    'phoneNumber'  => $phoneNumber,
                                    'email'        => $email,
                                    'date_created' => $date
                                     );

                 $this->db->insert('st_user_acc', $insertUserAccInfoSql);
            
        if($this->db->affected_rows() > 0)
            {
                $success = true; // to the controller
            }else{
                $success = false;
            } 
            // var_dump($success);
            // echo 's';
        return $success;

    }

    public function checkMail($email){
         $checkMailSql = "SELECT COUNT(id) AS numberOfMails FROM st_user_acc WHERE email = '$email'";
        
            $sql = $this->db->query($checkMailSql);
            $total_row=$sql->result_array();
            foreach($total_row as $total_row_item)
            {
                $total_rows = $total_row_item; 
            }
            
        $maxResult = $total_rows['numberOfMails'];
      



            if($maxResult > 0){
                $success = false; // to the controller
            }else{
                $success = true;
            } 
        
        return $success;
        }


    public function userLogin($email,$password){
        $success = '';

        if(empty($email) || empty($password)){
            $success = false;
        }
        
        $getUserSql = "SELECT FROM st_user_acc WHERE st_user_acc.username = `?` AND st_user_acc.password = `?`";
        
    }
    


}