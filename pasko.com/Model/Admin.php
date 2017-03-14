<?php
class Model_Admin
{
    
   public static function getAllUser ()
    {
       
        $dbUser     =  new Model_Db_Table_Admin();
        $userData   =  !empty($dbUser->getAllUser()) ? $dbUser->getAllUser() : '';
       
        if(!empty($userData)) {
            return $userData;
        }
        else {
            throw new Exception('User not found', /*System_Exception::NOT_FOUND*/263);
        }
        
    }
    
     public function update($params)
    {
//        if(!$this->_validate($params))
//        {
//            throw new Exception('The entered data is invalid', System_Exception::VALIDATE_ERROR);
//        }
        
        $tableUser = new Model_Db_Table_Admin();
   
        
        
        
        $resCreate = $tableUser->update($params);
        
            if(!$resCreate) {
                throw new Exception('Can\'t update user. Try later.', System_Exception :: ERROR_UPDATE_USER);
            }
//            print_r($params);
            return $resCreate;
        
    }
    
    public function changePassword($params)
    {
        $tableUser = new Model_Db_Table_Admin();
   
        $resCreate = $tableUser->changePassword($params);
        
            if(!$resCreate) {
                throw new Exception('Can\'t update password. Try later.', System_Exception :: ERROR_UPDATE_USER);
            }
//           print_r($params);
            return $resCreate;
    }
    
    public function delete($params)
    {
        $tableUser = new Model_Db_Table_Admin();
   
        $resCreate = $tableUser->delete($params);
    }


//    private function _validate($params)
//    {
//        $login      = !empty($params['email']) ? $params['email'] : '';
//        $password   = !empty($params['password']) ? $params['password'] : '';
//        
//        
//        if(!$password || !$login) {
//            return false;
//        }
//        
//        if(strlen($login > 20)) {
//            return false;
//        }
//        if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
//            return false;
//        }
//        return true;
//    }
}
