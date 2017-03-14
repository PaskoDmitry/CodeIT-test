<?php
class Controller_Admin extends System_Controller
{
    public function indexAction()
    {
        $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN) {
            
        }
        else {
            header('Location: /');
        }
    
//        $userRole = $this->_getSessParam('userRole');
//        if($userRole == Model_User::ROLE_ADMIN) {
//            echo 'Вы успешно попали в админскую(секретную) часть сайта!';
//        }
//        else {
//            echo 'Вы не являетесь администратором и попали сюда случайно! Доступ закрыт!';
//        }
      }
      
      public function userAction()
    {
          $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN) {
            
        }
        else {
            header('Location: /');
        }
        
        
        try {
         $modelAdmin = Model_Admin :: getAllUser();
            
//        echo '<pre>';
//        print_r($modelAdmin);
//        echo '<pre>';
         $this->view->setParam('allUser', $modelAdmin);
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }
           
    public function goodsAction()
    {
         $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN) {
            
        }
        else {
            header('Location: /');
        }
    }
    
    public function orderAction()
    {
         $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN) {
            
        }
        else {
            header('Location: /');
        }
    }
    
    public function createUserAction()
    {
         $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN) {
            
        }
        else {
            header('Location: /');
        }
        
        
    }
}