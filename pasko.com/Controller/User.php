<?php
class Controller_User extends System_Controller
{
    public function profileAction()
    {
        $userId  = $this->getArgs()['id'];
        $sessUserId = $this->_getSessParam('currentUser');
        $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN || $userId == $sessUserId) {
            
        }
        else {
            header('Location: /');
        }
        
        
       
        try {
            $modelUser = Model_User :: getById($userId);
            $this->view->setParam('user', $modelUser);
//            echo '<pre>';
//            print_r($this->view->getParam('user'));
//            echo '</pre>';
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
        
//        echo '<pre>';
//        var_dump($modelUser);
//        echo '</pre>';
//        
//        
//        
   
    }
    
    public function changePasswordAction()
    {
        $userId  = $this->getArgs()['id'];
        $sessUserId = $this->_getSessParam('currentUser');
        $userRole = $this->_getSessParam('userRole');
        if($userRole == Model_User::ROLE_ADMIN || $userId == $sessUserId) {
            
        }
        else {
            header('Location: /');
        }
         try {
            $modelUser = Model_User :: getById($userId);
            $this->view->setParam('user', $modelUser);
//            echo '<pre>';
//            print_r($this->view->getParam('user'));
//            echo '</pre>';
        }
        catch(Exception $e) {
            $this->view->setParam('error', $e->getMessage());
        }
    }
}