<?php
class Controller_Authorize extends System_Controller
{
    
    public function __construct()
    {
        if( $this->getParamByKey('save') == 'true' ) {
            if(!isset($_COOKIE[session_name()])) {    
                session_set_cookie_params(Model_User::LIFETIME_USER_COOKIE);
            }
        }
        parent::__construct();
    }
    
     public function registerAction()
    {
        header('Content-Type: application/json');
      
        $params = $this->getParams();
//        print_r($params);
        
        $userModel  = new Model_User();
        try {
            $userId     = $userModel->register($params);
           $this->_setSessParam('currentUser', $userId); 
            if($this->getParamByKey('save') == 'true') {
                $this->_setSessParam('is_save', 1);   
            }
            $userData = [
                'id'    =>  $userId,
                'email' =>  trim($params['email'])
            ];
           
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }
       
    }
    
    public function loginAction()
    {
        $params     = $this->getParams();
        $userModel  = new Model_User();
        try {
            $user = $userModel->login($params);
            $this->_setSessParam('currentUser', $user->id);
            $this->_setSessParam('userRole', $user->role_id);
            if($this->getParamByKey('save') == 'true') {
                $this->_setSessParam('is_save', 1);   
            }
            
            $userData = [
                'id'        =>  $user->id,
                'email'     =>  trim($params['email']),
                'role_id'   =>  $user->role_id
            ];
            
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }
    }
    
    public function exitAction()
    {
        $_SESSION = [];
        
        if(!empty($_COOKIE[session_name()])){
           unset($_COOKIE[session_name()]); 
        }
        
        session_destroy();
        setcookie(session_name(), '', time(), '/');
        die();
    }
    
    public function updateAction()
    {
        header('Content-Type: application/json');
        
        $params = $this->getParams();
//      print_r($params);
        
        $adminModel  = new Model_Admin();
        
         try {
           $updateUser     = $adminModel->update($params);

            $userData = [
                'true'    =>  $updateUser
            ];
           
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }
    }
    
    public function changePasswordAction()
    {
        header('Content-Type: application/json');
        
        $params = $this->getParams();
//      print_r($params);
        
        $adminModel  = new Model_Admin();
        
         try {
           $updateUser     = $adminModel->changePassword($params);

            $userData = [
                'true'    =>  $updateUser
            ];
           
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }
    }
    
    public function deleteAction()
    {
        header('Content-Type: application/json');
        
        $params = $this->getParams();
//        print_r($params);
        
        $adminModel  = new Model_Admin();
        $deleteUser     = $adminModel->delete($params);
    }
    
    public function createUserAction()
    {
        header('Content-Type: application/json');
      
        $params = $this->getParams();
//        print_r($params);
        
        $userModel  = new Model_User();
        try {
            $userId     = $userModel->createUser($params);
            
            
            $userData = [
                'id'    =>  $userId,
                'email' =>  trim($params['email'])
            ];
           
            echo json_encode($userData);
            die();
        }
        catch(Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
       }
    }
}