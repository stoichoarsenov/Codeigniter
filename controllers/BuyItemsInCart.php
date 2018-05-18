<?php 

class BuyItemsInCart extends CI_Controller{

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
    public function index()
    {
        redirect('books/page/33');
    }

    /**
     * Добавяне на цялата информация към база от дани
     * 
     */
    
    public function saveInformation(){
       

        $isLogged =  $this->user_model->isLogged();
        if($isLogged == true){
            $userId = $_SESSION['userInfo']['userId'];
            $userInfo = $this->user_model->getUserInfo($userId);


            $name =  $userInfo[0]['username'];
            $familyName = $userInfo[0]['usrFamName'];
            $txtEmail = $userInfo[0]['email'];
            $number = $userInfo[0]['phoneNumber'];
            $userAdress = $this->user_model->getUserAdress($userId);
            foreach($userAdress as $adressItem){
                if($adressItem['is_active'] == 1){
                    $adress = $adressItem['Addr'];
                    $city = $adressItem['AddrCity'];
                    $office = $adressItem['AddrNeibr'];
                }
            }

        }else{
            $name = $this->input->post('name',TRUE);
            $familyName = $this->input->post('familyName',TRUE);
            $txtEmail = $this->input->post('txtEmail',TRUE);
            $number = $this->input->post('number',TRUE);
            $adress = $this->input->post('adress',TRUE);
            $office = $this->input->post('selectOffice',TRUE);
            $city = $this->input->post('chooseCity',TRUE);
        }



       
        $comment = $this->input->post('comment',TRUE);
        $currentTime = date("Y-m-d H:i:s");
        $totalPriceForUser = $this->totalPrice; 

        $error = 'Успешна покупка';
        $success = true;
        

        if(empty($name) || empty($familyName) || empty($txtEmail) || empty($number) || empty($adress) || empty($currentTime) || empty($office) || empty($city)){
            $success = false;
            $error = 'Не е попълнена формата за регистрация';
        }else if(empty($totalPriceForUser)){
            $success = false;
            $error = 'Количката е празна';
        }
        else{
        /**
         * запазване на информацията за user
         */
        $setUserInfoResult =  $this->user_model->setUserInfo($name, $familyName, $txtEmail, $number, $adress, $currentTime, $totalPriceForUser, $comment, $office, $city);
        
            if($setUserInfoResult == true){
                $success = false;
                $error = 'Нещо стана и не успях да запиша';
            }
            
        //  var_dump($success);exit();

        //Взима последното въведено ID, което в случая е на последния потребител въвел информация.
            $last_id = $this->db->insert_id();
            
        
        
        /**
         * Взима всички Id и количества от сесията
         */
            if(empty($_SESSION['addToCartItem'])){
            $success = false;
            $error = 'Количката е празна'; 
            }else{

                $item = $this->cart_model->getItemsFromSession();

                    foreach($item['items'] as $currItem){
                    
                        /**
                         * използвам за да добавя крайната цена за продукт 
                         * цена на книга * количество
                         */
                        $itemPrice = $this->books_model->getPriceById($currItem['id']);   
                        $totalItemPrice = $itemPrice[0]['price'] * $currItem['quantity']; 
                        
                        /**
                         * Добавяне на продуктите
                         * @param SetUserProduct -> връща булева стойност, която показва дали заявката е изпълнена успешно
                         */
                        $setInfo = $this->cart_model->setUserProduct($last_id,$currItem['id'],$currItem['quantity'],$totalItemPrice,$currentTime);

                        if($setInfo == false ){
                            $error = 'Записа на продуктите куца';
                            $success = false;
                        }

                    }
                }

            }
        if($success == true){
                                    
                        /**
                         * Изчистване на количката
                         */
                        $this->cart_model->clearCart();
        }    
        
        $ajax_result = array(
            'success' => $success,
            'error' => $error
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


    
    /**
     * Метод за изчистване на количката
     */
    public function clearCard(){

        $ajax_result = array(
            'status' => $this->cart_model->clearCart()
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
    
    public function registerOrderName(){
        // $userInfo = 
        $isLogged =  $this->user_model->isLogged();
        if($isLogged == true){
            $userId = $_SESSION['userInfo']['userId'];
            $userInfo = $this->user_model->getUserInfo($userId);
            $result['userInfo'] = $userInfo;
            $result['isLogged'] = $isLogged;
            

            $userAdress = $this->user_model->getUserAdress($userId);
            foreach($userAdress as $adressItem){
                if($adressItem['is_active'] == 1){
                    // var_dump($adressItem);
                    $result['adress'] = $adressItem['Addr'];
                    $result['city'] = $adressItem['AddrCity'];
                    $result['office'] = $adressItem['AddrNeibr'];
                }


            }
        }

        $result['category'] = $this->category;
        $result['count'] = $this->cartItemCount;
        $result['totalPrice'] = $this->totalPrice;
        $result['currUserName'] = $this->getUsername;
        $result['isLogged'] = $this->isLogged;
        $this->load->view('user/register/orderName', $result);

    }




    /**
     * Избор на град, от който да се изброят възможните офиси
     * @return Array с подходящите стойности
     */

     public function chooseShop($city){
        //  var_dump($city);
        $sucess = true;
        $shopArrCity = array();
        $shopArr = array();
            if($city == "choose"){ 
                $sucess = false;
            }

        // var_dump($city);

        $shopArrCity['Varna']        = ['Бул. Република №59', 'Западна промишлена зона','24/7 Еконтомат - МОЛ Варна','Аспарухово' ];
        $shopArrCity['Burgas']       = ['кв. Победа, ул. Индустриална', 'Братя Миладинови', 'Въстаническа', 'Дебелянов-Славейков' ];
        $shopArrCity['Sofia']        = ['Карго Планет', 'Палекс София - Пи Ел Си Транс', '24/7 Еконтомат - OMV 8-ми декември', 'кв. Горубляне, ул. Пионерска №5' ];
        $shopArrCity['StaraZagora']  = ['Площад Берое','ул. Георги Сава Раковски №59','кв. Голеш, ул. Хрищенско шосе №30','ул. Никола Икономов №5'];

        if(isset($shopArrCity[$city]))
        {
            foreach($shopArrCity[$city] as $shop){
                // echo $shop.'</br>';
                $shopArr[] = $shop;
            }
        }else{
            $success = false;
        }
        

        // var_dump($shopArr);
        $ajax_result = array(
            'success' => $sucess,
            'shopArr' => $shopArr
        );

        // var_dump($this->input->is_ajax_request());exit();
        if($this->input->is_ajax_request()){
           // error_reporting (0);
            echo json_encode($ajax_result);
        }
        
        else{
            echo 'NON AJAX MODE :<br /><br /><pre>';
            print_r($ajax_result);
            echo '</pre>';
        }
    }

}



?>