<?php

class User extends CI_Controller{

private $cartItemCount;
private $totalPrice;
private $category;
private $isLogged;
private $getUsername;

public function __construct(){
    
    
    parent::__construct();
    
    $this->load->helper('url');
    $this->load->helper('form');
    $this->load->library('session');
    $this->load->model('cart_model');
    $this->load->model('user_model');
    $this->load->model('category_model');

    
    $this->cartItemCount = $this->cart_model->getSessionQuantityData();
    $this->totalPrice = $this ->cart_model->getTotalPrice();
    $this->category = $this->category_model->getCategories();
    $this->isLogged = $this->user_model->isLogged();
    $this->getUsername = $this->user_model->getUsername();
    
    
}

/**
 * А трябва ли ми и необходимо ли е да го има във всеки контролер?
 */
public function index(){
    redirect('books/page/33');
}

public function register(){
    $isLogged =  $this->isLogged;
    if($isLogged){
        redirect('user/info');
    }

    $data['totalPrice'] = $this->totalPrice;
    $data['category'] = $this->category;
    $data['count'] = $this->cartItemCount;
    $data['isLogged'] = $isLogged;
    $data['currUserName'] = $this->getUsername;
    $this->load->view('user/register/registerUser', $data);
}

/**
 * Регистрация на нов потребител
 */

    public function registerNewUser(){
        
        $success = true;
        $error = '';
        $passwordHashed ='';


        $username =     $this->input->post('username',          TRUE);
        $usrFamName =   $this->input->post('userFamName',       TRUE);
        
        
        $usrAddrArea   =     $this->input->post('addrArea',            TRUE);
        $usrAddrCity   =     $this->input->post('addrCity',            TRUE);
        $usrAddrNeibr  =     $this->input->post('addrNeibr',           TRUE);
        $usrAddr       =     $this->input->post('adress',              TRUE);


        $password =     $this->input->post('registerPassword',  TRUE);
        $phoneNumber =  $this->input->post('phoneNumber',       TRUE);
        $email =        $this->input->post('Email',             TRUE);
        
        $passwordHashed = md5($password);
        

        if(empty($username) || empty($usrFamName) || empty($password) || empty($phoneNumber) || empty($email) || empty($usrAddr) || empty($usrAddrArea) || empty($usrAddrCity) || empty($usrAddrNeibr)){
            $success = false;
            $error = 'нещо липсва';
        }else{
            $userInfo = 
                        ['username'         => $username,
                         'usrFamName'       => $usrFamName, 
                         'passwordHashed'   => $passwordHashed, 
                         'phoneNumber'      => $phoneNumber, 
                         'email'            => $email, 
                         'usrAddr'          => $usrAddr, 
                         'usrAddrArea'      => $usrAddrArea, 
                         'usrAddrCity'      => $usrAddrCity, 
                         'usrAddrNeibr'     => $usrAddrNeibr];
            $insertUserInformation = $this->user_model->setUserRegistration($userInfo);
        }
        if($insertUserInformation == false){
            $success = false;
            $error = 'не се запази';
        }
// var_dump($_POST);exit();

        $ajax_result = array(
            'success' => $success,
            'error' => $error,
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


    /**
     * проверка дали няма вече потребител с такава регистрация
     * 
     */
    public function checkMail($email){
        // $success = true;
        // var_dump($email);
        $checkMail = $this->user_model->checkmail($email);
        // var_dump($checkMail);
        if($checkMail){ 
            $success = true;
        }else{
            $success = false;
        }

        $ajax_result = array(
            'success' => $success
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


    public function login(){
    $isLogged =  $this->isLogged;
        if($isLogged){
            redirect('user/info');
        }
    $data['totalPrice'] = $this->totalPrice;
    $data['category'] = $this->category;
    $data['count'] = $this->cartItemCount;
    $data['isLogged'] = $isLogged;
    $data['currUserName'] = $this->getUsername;
    $this->load->view('user/login/loginUser', $data);
    }


    public function loginUser(){
        $success = '';
        $error = '';

        $email = $this->input->post('email',TRUE);
        $password = $this->input->post('password', TRUE); 

        if(empty($email)){
            $success = false;
            $error = 'Не е въведен mail';
        }else if(empty($password)){
            $success = false;
            $error = 'Не е въведена парола';
        }

        $checkIfUserExists = $this->user_model->userLogin($email,$password);
            if($checkIfUserExists == false){
                $success = false;
                $error = 'Не съществува такъв потребител';       
            }else{
                $success = true;
            }

            // var_dump($success);

        $ajax_result = array(
            'error' => $error,
            'success' => $success,
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



    public function changePassword(){
        $isLogged =  $this->isLogged;
        if(!$isLogged){
            redirect('user/login/loginUser');
        }


        $data['totalPrice'] = $this->totalPrice;
        $data['category'] = $this->category;
        $data['count'] = $this->cartItemCount;
        $data['isLogged'] = $isLogged;
        $data['currUserName'] = $this->getUsername;
        $this->load->view('user/profile/changepassword', $data);
    }

    public function changePwd(){
        $success = '';
        $error = '';

        $pwd = $this->input->post('pwd', TRUE);
        $newPwd = $this->input->post('newPwd', TRUE);
        $user = $_SESSION['userInfo']['userId'];

        if(empty($pwd) || empty($newPwd)){
            $success = false;
            $error = 'Липсва парола';
        }
       
        if($this->user_model->changeUserPassword($user,$pwd, $newPwd)){
            $success = true;
            $error = '';
        }
        else{
            $success = false;
            $error = 'Проблем в записването';
        }
        
        $ajax_result = array(
            'error' => $error,
            'success' => $success,
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

    public function adress(){
        $isLogged =  $this->isLogged;
        if(!$isLogged){
            redirect('user/login/loginUser');
        }

        $userId = $_SESSION['userInfo']['userId'];
        $userAdresses = $this->user_model->getUserAdress($userId);


        $data['adress'] = $userAdresses;
        $data['totalPrice'] = $this->totalPrice;
        $data['category'] = $this->category;
        $data['count'] = $this->cartItemCount;
        $data['isLogged'] = $isLogged;
        $data['currUserName'] = $this->getUsername;
        $this->load->view('user/profile/adress', $data);
    }

    public function setActiveAdress($address_id){
        $success = false;
        $error = '';
        $userId = $_SESSION['userInfo']['userId'];
        
        
        $setAsActive = $this->user_model->setActiveAdress($userId, $address_id);
            if($setAsActive){
                $error = '';
                $success = true;
            }
            else{
                $error = 'Не е променен записа';
                $success = false;
            }


        $ajax_result = array(
            'error' => $error,
            'success' => $success,
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

    /**
     * Ajax request to change adress
     * @param Success Boolean
     * @param error error mesage 
     * 
     * @return Ajax_Result
     */
    public function changeAdress(){
        $isLogged =  $this->isLogged;
        if(!$isLogged){
            redirect('user/login/loginUser');
        }

        $success = false;
        $error = '';
        
        if(!$_POST){
            $error = 'няма заявка';
            $success = false;
        }

        $adrrId = $this->input->post('id', true);
        $area = $this->input->post('area', true);
        $city = $this->input->post('city', true);
        $neibr = $this->input->post('neibr', true);
        $adress = $this->input->post('adress', true);
        
        $adressInfo = [
                        'adrrId'    =>   $adrrId,      
                        'area'      =>   $area,  
                        'city'      =>   $city,  
                        'neibr'     =>   $neibr,  
                        'adress'    =>   $adress 
                        ];

        $changeAdressResult = $this->user_model->changeAdress($adressInfo);    
        if ($changeAdressResult > 0){
            $success = true;
            $error = '';
        }

        $ajax_result = array(
            'error' => $error,
            'success' => $success,
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
     /**
     * Ajax request to delete adress
     * @param Success Boolean
     * @param error error mesage 
     * @param UserId The id of user who wants to delete the adress
     * @param AdressId The id of adress that is gonna be deleted
     * @return Ajax_Result
     */
    public function deleteAdress($adressId){
        $success = false;
        $error = '';


        //проверка дали потребителят е влязъл в ситемата

        $isLogged =  $this->isLogged;
        if(!$isLogged){
            redirect('user/login/loginUser');
        }
        //
        if(!empty($_SESSION['userInfo']['userId'])){
            $userId = $_SESSION['userInfo']['userId'];
        }else{
            $success = false;
            $error = 'няма коректно въведен потребител';
        }


        if(!$_POST || $adressId < 1 ){
            $success = false;
            $error = 'няма заявка';
        }

        
        /*
         * Викане на функция от модела за изтриване на адреса 
         * подават се два параметъра id на потребителя и id на адреса, който ще се трие 
         * Връща стойност true ако изтриване е успешно
         */
        
        $deleteResult =  $this->user_model->deleteAdress($userId, $adressId);
        if($deleteResult == false){
            $success = false;
            $error = 'записа гръмна';
        }
        else{
            $success = true;
            $error = '';
        }

        $ajax_result = array(
            'error'   => $error,
            'success' => $success,
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


    public function addAdres(){
        $isLogged =  $this->isLogged;
        if(!$isLogged){
            redirect('user/login/loginUser');
        }

        $success = false;
        $error = '';
        
        if(!$_POST){
            $error = 'няма заявка';
            $success = false;
        }

        if(!empty($_SESSION['userInfo']['userId'])){
            $userId = $_SESSION['userInfo']['userId'];
        }else{
            $success = false;
            $error = 'няма коректно въведен потребител';
        }

    //    var_dump($_POST);exit();
        $area = $this->input->post('newArea', true);
        $city = $this->input->post('newCity', true);
        $neibr = $this->input->post('newNeibr', true);
        $adress = $this->input->post('newAadress', true);
        // var_dump($_POST);
 
        $adressInfo = [    
                        'userId'    =>   $userId,
                        'area'      =>   $area,  
                        'city'      =>   $city,  
                        'neibr'     =>   $neibr,  
                        'adress'    =>   $adress 
                        ];
                        
        // var_dump($_POST);
        $addAdressResult = $this->user_model->addAdress($adressInfo);

        if($addAdressResult == true){
            $success = true;
        }

        $ajax_result = array(
            'error'   => $error,
            'success' => $success,
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


    public function logout(){
        $isLogged =  $this->isLogged;
        if(!$isLogged){
            redirect('user/login');
        }

            $this->session->sess_destroy();
            redirect('user/login');
            
    }
    

    public function photo(){

        /**
         * Редиректва ако има някакъв проблем с оторизацията на потребител
         */
        $isLogged =  $this->isLogged;
        if(!$isLogged){
            redirect('user/info');
        }
        
        /**
         * Ако има зададен файл (снкмка)
         * взима информация за снимката от метода addPhoto
         * той връща масив с информация за
         * потребителя (id)
         * оригиналното име на снимката
         * и кропнатото (originalName_Cropped)
         * като тези параметри се подават на модел за добавянето им към база от дани
         */
        if(!empty($_FILES))
        {
            $photoInfo = $this->addPhoto();
            $setUserPhoto = $this->user_model->addPhoto($photoInfo);
        }
        
        if(!empty($_SESSION['userInfo']['userId'])){
            $userId = $_SESSION['userInfo']['userId'];
        }

        $getPhotoInfo = $this->user_model->getProfilePhotos($userId);
        $data['userId'] = $_SESSION['userInfo']['userId'];
        $data['photos'] = $getPhotoInfo;
        $data['totalPrice'] = $this->totalPrice;
        $data['category'] = $this->category;
        $data['count'] = $this->cartItemCount;
        $data['isLogged'] = $isLogged;
        $data['currUserName'] = $this->getUsername;
        $this->load->view('user/profile/photo', $data);
    }



    /**
     * Създава папка с ID на потребителя ако не същестува
     * задават се основните правила за снимката която може да бъде добавена
     * @return Array
     */
    public function addPhoto(){

    /**
     * Създава се папка с ID за конкретния потребител
     */
    $id =  $_SESSION['userInfo']['userId'];
    if(!is_dir('./assets/images/'.$id)){
    mkdir('./assets/images/'.$id, 0777, true);
    }


    $originalName = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME );
    $originalNameExtension = $_FILES['file']['name'];
    $extension = pathinfo($originalNameExtension, PATHINFO_EXTENSION);

    // var_dump($extension);
        /**
         * Какво може да се добавя 
         * задават се лимитите
         */
        $config['upload_path']          = ("./assets/images/".$id);
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 2048 ;
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;
        $config['file_name']            = $originalNameExtension;
        


        
        $this->load->library('upload', $config);
        $this->upload->initialize($config);


        /**
         * Не запазва файла, а дава информация за файла, който ще се качва
         */
        $upload_data = $this->upload->data(); 
        // $_FILES['file']['name'];
    

        /**
         * Взимане на височината и дължината на картинката
         */
        $image_info = getimagesize($_FILES["file"]["tmp_name"]);
        $width = $image_info[0];
        $height = $image_info[1];
        
       


        // Качване на оригиналния файл
        $uploadFile = $this->upload->do_upload('file');

        /**
         * Проверка дали файла е качен (оригиналния и ако да )
         * прави проверка коя от страните е по - малка за да ресайзне по нея
         * библиотеката gd2 работи с resize и crop
         * ако реша в последствие да resize снимката просто мога да задам условие
         *  $this->image_lib->resize();
         * със същите параметри
         */
        if($uploadFile){
            $config['image_library'] = 'gd2';
            $config['source_image'] = "./assets/images/".$id."/".$originalNameExtension;
            $config['create_thumb'] = TRUE;
            $config['thumb_marker'] = '_cropped';
            $config['maintain_ratio'] = FALSE;

            if($width >= $height){
                $config['width']        = $height;
                $config['height']       = $height;
            }else{
                $config['width']        = $width;
                $config['height']       = $width;
            }
        

            $this->load->library('image_lib', $config);
            $isImageCropped = $this->image_lib->crop();
            
            if($isImageCropped){
                $croppedName = $originalName.'_cropped';
                $imageInfo = array(
                                    'userId'        => $id,
                                    'originalName'  => $originalName.'.'.$extension,
                                    'croppedImage'  => $croppedName.'.'.$extension,
                                );

                return $imageInfo;
            }
        }
    }

    /**
     * Функция за изтриване на снимката
     * на модела се подават два параметъра
     * ID на снимката и  ID на потребителя
     * спрямо тях се изтрива съответния фотос
     * 
     * @return Ajax
     */
    public function deletePhoto(){
        $success = false;
        $error = "";

            $photoId = $this->input->post('id', TRUE);
            $userId  = $_SESSION['userInfo']['userId'];
            
            $deletePhotoResult = $this->user_model->deletePhoto($photoId, $userId);

            // unlink("/assets/images/".$ $userId."/".$sadads)


            if($deletePhotoResult == true){
                $success = true;
                $error = "";
            }else{
                $error = "Грешка в записа";
            }

            $ajax_result = array(
                'error'   => $error,
                'success' => $success,
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
    

     /**
     * Функцията задава коя снимка да бъде активна
     * при актививирането на  дадена снимка, 
     * предишната активна става неактивна :D :D :D 
     * 
     * @return Ajax
     */
    public function setAsActivePhoto() {
        $success = false;
        $error = "";

        $photoId = $this->input->post('id', TRUE);
        $userId  = $_SESSION['userInfo']['userId'];
        
        $setAsActiveResult = $this->user_model->setAsActivePhoto($photoId, $userId);


        if($setAsActiveResult == true){
            $success = true;
            $error = "";
        }else{
            $error = "Грешка в записа";
        }

        $ajax_result = array(
            'error'   => $error,
            'success' => $success,
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


    /**
     * извеждане на цялостната информация за текущия потребител
     * 
     */
    public function info(){
        $isLogged =  $this->isLogged;
        if(!$isLogged){
            redirect('user/profile');
        }

        $userId  = $_SESSION['userInfo']['userId'];

        //Смяна на име фамилия статус и телефон
        //принтване на цялата информация за потребителя
        
        $userInfo = $this->user_model->getUserInfo($userId);
        // var_dump($userInfo);


        $data['userinfo'] = $userInfo[0];
        $data['totalPrice'] = $this->totalPrice;
        $data['category'] = $this->category;
        $data['count'] = $this->cartItemCount;
        $data['isLogged'] = $isLogged;
        $data['currUserName'] = $this->getUsername;
        $this->load->view('user/profile/userInfo', $data);

    }

    public function changeInfo(){
        $success = false;
        $error = '';
        $info[] = $this->input->post('info', TRUE);

        $name = $info[0][0]['value'];
        $famName = $info[0][1]['value'];
        $number = $info[0][2]['value'];
        $email = $info[0][3]['value'];
        $userId  = $_SESSION['userInfo']['userId'];



        $info = array(
            'id'          => $userId,
            'name'        => $name,
            'famName'     => $famName,
            'number'      => $number,
            'email'       => $email

        );
    
        $changeInfo = $this->user_model->changeInfo($info);

        if($changeInfo == true){
            $success = true;
        }else{
            $error = 'грешка при записа';
        }
        

        $ajax_result = array(
            'error'   => $error,
            'success' => $success,
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










?>