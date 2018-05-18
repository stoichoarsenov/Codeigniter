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


/**
 * Регистрация на потребители 
 * @param Array
 * @return Bool
 */

    public function setUserRegistration($userInfo){
        // var_dump($userInfo);
        $success = true;
        $date = date("Y-m-d H:i:s");
        $insertUserAccInfoSql = array(
                                    'username'     => $userInfo['username'],
                                    'usrFamName'   => $userInfo['usrFamName'],
                                    'password'     => $userInfo['passwordHashed'],
                                    'phoneNumber'  => $userInfo['phoneNumber'],
                                    'email'        => $userInfo['email'],
                                    'date_created' => $date,
                                    'is_active'    => '1'
                                     );

                 $this->db->insert('st_user_acc', $insertUserAccInfoSql);
                 
                    
        if($this->db->affected_rows() > 0)
            {
                $id = $this->db->insert_id();
               $success = $this->insertUserAdress($id , $userInfo['usrAddr'], $userInfo['usrAddrArea'], $userInfo['usrAddrCity'], $userInfo['usrAddrNeibr']);

            }else{
                $success = false;
            } 

        return $success;

    }





    public function insertUserAdress($id , $usrAddr, $usrAddrArea, $usrAddrCity, $usrAddrNeibr){
        $success = '';
        $insertUserAdressSQL = array(
                                    'user_id'      => $id,
                                    'AddrArea'     => $usrAddrArea,
                                    'AddrCity'     => $usrAddrCity,
                                    'AddrNeibr'    => $usrAddrNeibr,
                                    'Addr'         => $usrAddr,
                                    'is_active'    => '1'
                                    );

            $this->db->insert('st_user_adress', $insertUserAdressSQL);

            if($this->db->affected_rows() > 0){
                $success = true;
            }else{
                $success = false;
            }
        
       return $success;
    }

    public function checkMail($email){
         $checkMailSql = "SELECT COUNT(id) AS numberOfMails FROM st_user_acc WHERE email = ?";
        
            $sql = $this->db->query($checkMailSql, array($email));
            $total_row = $sql->result_array();
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

    /**
     * Изтиване на адреса по подадени данни за потребителя( id ) и данни за адреса (adressId)
     * @param userId integer              
     * @param adressId integer
     * @return BOOLEAN
     */

    public function deleteAdress($userId, $adressId){
        $success = false;
        
        $deleteSQL = "DELETE FROM `st_user_adress` WHERE `st_user_adress`.`user_id` = ? AND `st_user_adress`.`id` = ?";
        $deleteQuery = $this->db->query($deleteSQL,array($userId,$adressId));
        
            if($deleteQuery == true){
                $success = true;
            }

        return $success;
    }










/**
 * Проверява дали съществува подобен потребител
 * при login вдига сесия за потребителя
 */
    public function userLogin($email,$password){
        // $success = '';
        // $error = '';

        
        if(empty($email) || empty($password)){
            $success = false;
            $error = true;
        }else{
            
            $passwordHashed = md5($password);
            
            $sqlQuerry = $this->db->get_where(
                                    'st_user_acc', array(
                                        'email' => $email ,
                                        'password' => $passwordHashed,
                                        'is_active' => '1'));

            $userInfo = $sqlQuerry->result_array();
                //Вдигане на сесия за потребителя
                //Ако съответния съществува
            if(!empty($userInfo)){
                $userId = $userInfo[0]['id'];
                $username = $userInfo[0]['username'];
                

                $userSessionData = array(
                    'userId'  => $userId,
                    'username'     => $username,
                    'logged_in' => TRUE
                    );

                $this->session->set_userdata('userInfo',$userSessionData);
                $success = TRUE;
            }else{
                $success = false;
            }

            
        }
        
        return $success;
    }

    /**
     * Проверява дали потребителя е логнат
     */

    public function isLogged(){
        
        if(isset($_SESSION['userInfo'])){
            return true; 
        }
        else{
            return false;
        }
    
    }
    /**
     * Взема името на текущия потребител
     */
    public function getUsername(){ 
        
        if(!isset($_SESSION['userInfo'])){
            $userName = ''; 
        }
        else{
            $userName = $_SESSION['userInfo']['username'];
        }
    return $userName;
    }



    
    public function changeUserPassword($user, $password, $newPassword){
        $success = '';
        $passwordHashed = md5($password);
        $newPasswordHashed = md5($newPassword);

        $checkUserPwdSql = "SELECT password FROM `st_user_acc` WHERE id = ?";
        $checkUsrPwdQuerry = $this->db->query($checkUserPwdSql, array($user));
            $userPWD = $checkUsrPwdQuerry->result_array();
        if(empty($userPWD)){
            $success = false;
        }else{
            if($passwordHashed == $userPWD[0]['password']){
                $setNewPwdSql = "UPDATE `st_user_acc` SET `password` = ? WHERE `st_user_acc`.`id` = ?";
                $setNewPwdQuerry = $this->db->query($setNewPwdSql,array($newPasswordHashed, $user));
                $success = true;

            }else{
                $success = false;
            }
        }
            return $success;
    }
    

    public function getUserInfo($id){
        if(!isset($id)){
            return false;
        }
        $userInfoSQL = "SELECT * FROM `st_user_acc` WHERE id = ?";
        $userInfoQuery = $this->db->query($userInfoSQL, array($id));
        $userInfo = $userInfoQuery->result_array();
        
        return $userInfo;
    }


    public function getUserAdress($id){
        if(!isset($id)){
            return false;
        }
        $allAdresses = "SELECT id, AddrArea, AddrCity, AddrNeibr, Addr, is_active FROM `st_user_adress` WHERE `st_user_adress`.`user_id` = ?";
        $allAdressesQuery = $this->db->query($allAdresses, array($id));
        $userAdres = $allAdressesQuery->result_array();

        // var_dump($id);

        return $userAdres;
    }

    public function setActiveAdress($userId, $adressId){
        $success = false;   

        if(empty($userId) || empty($adressId)){
            $success = false;
        }
        
        $getActiveAdressSQL = "SELECT id FROM `st_user_adress` WHERE `st_user_adress`.`is_active` = '1' AND `st_user_adress`.`user_id` = ?";
        $getActiveAdressQuerry = $this->db->query($getActiveAdressSQL, $userId);
        $ActiveAdress = $getActiveAdressQuerry->result_array();

    
        foreach($ActiveAdress as $activeAdressItem){
            // var_dump($activeAdressItem['id']);
        }


        $updateActiveAdressSQL = "UPDATE `st_user_adress` SET `is_active` = '1' WHERE `st_user_adress`.`user_id` = ? AND `st_user_adress`.`id` = ?";           
        $updateActiveAdressQuerry = $this->db->query($updateActiveAdressSQL, array($userId, $adressId));

        
            if($updateActiveAdressQuerry){
                $setInactiveSQL = "UPDATE `st_user_adress` SET `is_active` = '0' WHERE `st_user_adress`.`user_id` = ? AND `st_user_adress`.`id` = ?";
                $setInactiveQuery = $this->db->query($setInactiveSQL, array($userId, $activeAdressItem['id']));
                    
                    if($setInactiveQuery){
                        $success = true;
                    }
            }else{
                $success = false;
            }

        return $success;

    }


    public function changeAdress($adressInfo){
        $success = false;

        if(empty($adressInfo)){
            $success = false;
        }

        $changeAdressSQL = "UPDATE `st_user_adress` SET `AddrArea` = ?, AddrCity = ?, AddrNeibr = ? , Addr =?  WHERE `st_user_adress`.`id` = ? ";
        $changeAdressQuery = $this->db->query($changeAdressSQL, array($adressInfo['area'], $adressInfo['city'], $adressInfo['neibr'], $adressInfo['adress'], $adressInfo['adrrId']));
        
        if($changeAdressQuery == true){
                $success = $changeAdressQuery;
            }
        return $success;
    }



    public function addAdress($adressInfo){
        
        $success = false;

        $insertAdrSql = "INSERT INTO `st_user_adress` ( `user_id`, 
                                                        `AddrArea`, 
                                                        `AddrCity`, 
                                                        `AddrNeibr`, 
                                                        `Addr`, 
                                                        `is_active`) 
                        VALUES (?, ?, ?, ?, ?, ?); ";
        $setNewAddrQuery = $this->db->query($insertAdrSql,array(
                                                                $adressInfo['userId'],
                                                                $adressInfo['area'],
                                                                $adressInfo['city'],
                                                                $adressInfo['neibr'],
                                                                $adressInfo['adress'],
                                                                '0' 
                                                            ));
        // var_dump($adressInfo);
        if($setNewAddrQuery == true){
                $success = $setNewAddrQuery;
            }

        return $success;

    }

    /**
     * Добавяне на снимката към база от дани
     * @return BOOLEAN 
     */
    public function addPhoto($userInfo){
    $success      = false;
    $userId       = $userInfo['userId'];
    $originalName = $userInfo['originalName'];
    $croppedName  = $userInfo['croppedImage'];

    $isThereActiveRecordSql = "SELECT * FROM st_user_photos WHERE is_active = 1";
    $isThereActiveRecordQuery = $this->db->query($isThereActiveRecordSql);
    $afftectedRows = $isThereActiveRecordQuery->num_rows();
    
        if($afftectedRows > 0){
        $is_active = 0;
        }else{
        $is_active = 1;
        }

    $addImageSql = "INSERT INTO `st_user_photos` (`user_id`, `original_photo`, `cropped_photo`, `is_active`) VALUES (?, ?, ?, ?);";
    $setImageQuery =  $this->db->query($addImageSql,array($userId, $originalName, $croppedName, $is_active));

        if($setImageQuery){
            $success = true;
        }
    
    return $success;
    }

    /**
     * Връща информация за кропнатите снимки
     * @return Array
     * 
     */
    public function getProfilePhotos($id){
        
        $getPhotosSQL = "SELECT id,cropped_photo, is_active FROM st_user_photos WHERE user_id = ?";
        $getPhotosQuery = $this->db->query($getPhotosSQL,array($id));

        $photosInfo = $getPhotosQuery->result_array();
        // var_dump($photosInfo);
        // foreach($photosInfo as $photosInfo_item)
        // {
        //     $photos['croppedPhoto'][] = $photosInfo_item['cropped_photo']; 
        //     $photos['isActive'][]     = $photosInfo_item['is_active']; 
        // }
        // var_dump($photos['isActive']);
        return $photosInfo;
    
    }

    /**
     * @param Integer photoId - ID на снимката  
     * @param Integer userId - ID на потребителя
     * 
     * @return Array 
     */

     public function deletePhoto($photoId, $userId){
         $success = false;
         $error = '';


        //Вземан на името на снимката, която ще се трие, за да може да се изтрие и от папката
        

        $getPhotoSQL = "SELECT `st_user_photos`.`original_photo`, `st_user_photos`.`cropped_photo` FROM `st_user_photos` WHERE `st_user_photos`.`id` = ? AND `st_user_photos`.`user_id` = ?";
        $getPhotoQuery = $this->db->query($getPhotoSQL, array($photoId, $userId));
        $photoArray = $getPhotoQuery->result_array();
        
        $originalPhoto = $photoArray[0]['original_photo'];
        $croppedPhoto = $photoArray[0]['cropped_photo'];

            $deleteOriginalPhoto = unlink('assets/images/'.$userId.'/'.$originalPhoto);
            $deleteCroppedPhoto = unlink('assets/images/'.$userId.'/'.$croppedPhoto);



         $deletePhotoSQL = "DELETE FROM `st_user_photos` WHERE `st_user_photos`.`id` = ? AND `st_user_photos`.`user_id` = ?";
         $deletePhotoQuery = $this->db->query($deletePhotoSQL,array($photoId, $userId));
        
            if($deletePhotoQuery == true && $deleteOriginalPhoto == true && $deleteCroppedPhoto == true){
                $success = true;
            }

        return $success;


     }

   /**
     * @param Integer photoId - ID на снимката  
     * @param Integer userId - ID на потребителя
     * 
     * @return BOOLEAN 
     */
     public function setAsActivePhoto($photoId, $userId){
        $success = false;
        $error = '';

        //Вземан на текущата активна снимка
        //с цел, правенето й на неактивна

        $getActivePhotoSQL = "SELECT id FROM `st_user_photos` WHERE `st_user_photos`.`is_active` = 1 AND `st_user_photos`.`user_id` = ?";
        $getActivePhotoQuery = $this->db->query($getActivePhotoSQL, array($userId));
        $activePhotoArray = $getActivePhotoQuery->result_array();
       
        if(!empty($activePhotoArray)){
            $activePhoto = $activePhotoArray[0]['id'];
            $success = true;
        }else{ 
            $success = false; 
        }

        //Промяна на статуса на текущата активна снимка
        //
        $setInActivePhotoSQL = "UPDATE `st_user_photos` SET `is_active` = '0' WHERE `st_user_photos`.`id` = ? AND `st_user_photos`.`user_id` = ?";
        $setInActivePhotoQuery = $this->db->query($setInActivePhotoSQL, array($activePhoto, $userId));
        $setInactiveQueryResult = $setInActivePhotoQuery;
        

        if($setInactiveQueryResult == true){
            $success = true;
        }else{ 
            $success = false; 
        }
    

        // Промяна на активната снимка
        $setAsActivePhotoSQL = "UPDATE `st_user_photos` SET `is_active` = '1' WHERE `st_user_photos`.`id` = ? AND `st_user_photos`.`user_id` = ?";
        $setAsActivePhotoQuery = $this->db->query($setAsActivePhotoSQL,array($photoId, $userId));
       
           if($setAsActivePhotoQuery == true){
               $success = true;
            }else{ 
                $success = false;
            }    

       return $success;


    }


    /**
     * @param Array $info - user information
     * @return Boolean
     */
    public function changeInfo($info){
        $success = false;
        
        if(empty($info)){
            $success = false;
            $error = 'Няма информация за потребителя';
        }
        

        $changeInfoSQL = "UPDATE `st_user_acc` SET `username` = ?, `usrFamName` = ?, `phoneNumber` = ?, `email` = ? WHERE `st_user_acc`.`id` = ?";
        $changeInfoQuery = $this->db->query($changeInfoSQL,array($info['name'], $info['famName'], $info['number'], $info['email'], $info['id']) );
        
        if($changeInfoQuery == true){
            $success = true;
        }

        return $success;
        


    }



     


}