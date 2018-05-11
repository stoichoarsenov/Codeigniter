<?php

class User extends CI_Controller{

private $cartItemCount;
private $totalPrice;
private $category;

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
    
}

/**
 * А трябва ли ми и необходимо ли е да го има във всеки контролер?
 */
public function index(){
    redirect('books/page/33');
}

public function register(){
    

    $data['totalPrice'] = $this->totalPrice;
    $data['category'] = $this->category;
    $data['count'] = $this->cartItemCount;
    $this->load->view('register/registerUser', $data);
}

/**
 * Регистрация на нов потребител
 */

    public function registerNewUser(){
        
        $success = true;
        $error = '';
        $passwordHashed ='';


        $username = $this->input->post('username', TRUE);
        $usrFamName = $this->input->post('userFamName', TRUE);
        $password = $this->input->post('registerPassword', TRUE);
        $phoneNumber = $this->input->post('phoneNumber', TRUE);
        $email = $this->input->post('Email', TRUE);
        $passwordHashed = md5($password);
        

        if(empty($username) || empty($usrFamName) || empty($password) || empty($phoneNumber) || empty($email)){
            $success = false;
            $error = 'нещо липсва';
        }else{
        $insertUserInformation = $this->user_model->setUserRegistration($username, $usrFamName, $passwordHashed, $phoneNumber, $email);
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

    $data['totalPrice'] = $this->totalPrice;
    $data['category'] = $this->category;
    $data['count'] = $this->cartItemCount;
    $this->load->view('register/loginUser', $data);
    }


    public function loginUser(){
        $email = $this->input->post('email',TRUE);
        $password = $this->input->post('password', TRUE); 

        $checkIfUserExists = $this->user_model->userLogin($email,$password);
    }

}










?>