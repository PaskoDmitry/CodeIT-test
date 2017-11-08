<?php
class Model_User
{
    /**
     * Register mode int
     */
    const MODE_REGISTER = 1;
    
    /**
     * Login mode 2
     */
    const MODE_LOGIN = 2;
    
    /**
     * Admin role id
     */
    const ROLE_ADMIN = 5;
    
    /**
     * Cookie lifetime;
     */
    const LIFETIME_USER_COOKIE = 3600;
     /**
     *
     * @var int 
     */
    public  $id;
    
    
    /**
     *
     * @var string 
     */
    public  $name;

    
    /**
     *
     * @var string 
     */
    public  $email;

    /**
     *
     * @var string
     */
    public  $login;

     /**
     *
     * @var int
     */
    public  $date;
    
    /**
     * 
     * @param int $userId
     * @return Model_User
     * @throws Exception
     */
    public static function getById($userId)
    {
        $dbUser     =  new Model_Db_Table_User();
        $userData = !empty($dbUser->getById($userId)[0]) ? $dbUser->getById($userId)[0] : '';

//        $userData   =  array_shift($dbUser->getById($userId));
        
        if(!empty($userData)) {
            $modelUser  = new self();
            $modelUser->id          = $userData->id;
            $modelUser->name        = $userData->name;
            $modelUser->email       = $userData->email;
            $modelUser->login       = $userData->login;
            $modelUser->date        = $userData->date;
//            echo '<pre>';
//            print_r($modelUser);
//            echo '</pre>';
            return $modelUser;
        }
        else {
            throw new Exception('User not found', /*System_Exception::NOT_FOUND*/23);
        }
    }

    public static function getCountry(){
        $country     =  new Model_Db_Table_User();
        $countryData = $country->getCountry();

        if(!empty($countryData)){
            return $countryData;
        }
        else {
            throw new Exception('Country not found', /*System_Exception::NOT_FOUND*/23);
        }
    }
    
    /**
     * 
     * @param array $params
     * @throws Exception
     * @return int userId
     */
    public function register($params)
    {
        if(!$this->_validate($params))
        {
            throw new Exception('The entered data is invalid', System_Exception::VALIDATE_ERROR);
        }
        
        $tableUser = new Model_Db_Table_User();
   
        $resIfExists = $tableUser->checkIfExists($params);
        
        if(!empty($resIfExists)) {
            throw new Exception('Such account is already exists.', System_Exception :: ALREADY_EXISTS);
        }
        else {
            $resCreate = $tableUser->create($params);

            if(!$resCreate) {
                throw new Exception('Can\'t create new user. Try later.', System_Exception :: ERROR_CREATE_USER);
            }
            return $resCreate;
        }
    }
    
     /**
     * 
     * @param array $params
     * @return int userId
     * @throws Exception
     */
    public function login($params)
    {
        if(!$this->_loginValidate($params))
        {
            throw new Exception('The entered data is invalid', System_Exception::VALIDATE_ERROR);
        }
        $tableUser = new Model_Db_Table_User();
        
        $res = $tableUser->checkIfExists($params, Model_User::MODE_LOGIN);
        
        if(!empty($res[0])) {
            return $res[0]; 
        }else {
            throw new Exception('Invalid user or password.', System_Exception::INVALID_LOGIN);
        }
    }
    
    
    /**
     * 
     * @param array $params
     * @return boolean
     */
    private function _validate($params)
    {
        $email     = !empty($params['email']) ? $params['email'] : '';
        $password   = !empty($params['password']) ? $params['password'] : '';

        
        if(!$password || !$email) {
            return false;
        }

        if(strlen($email > 20)) {
            return false;
        }
        if(strlen($password) < 8 || strlen($password) > 20) {
            return false;
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }

    private function _loginValidate($params)
    {
        $emailOrLogin     = !empty($params['emailOrLogin']) ? $params['emailOrLogin'] : '';
        $password   = !empty($params['password']) ? $params['password'] : '';


        if(!$password || !$emailOrLogin) {
            return false;
        }

        if(strlen($emailOrLogin > 20)) {
            return false;
        }
        if(strlen($password) < 8 || strlen($password) > 20) {
            return false;
        }
        return true;
    }
}