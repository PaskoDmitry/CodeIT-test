<?php
abstract class System_Controller
{
    
   
    /**
     *
     * @var System_view $view 
     */
    public $view;
    
    /**
     *
     * @var int 
     */
    protected $_userId;
    
    
    /**
     *
     * @var array 
     */
    public $args;
    /**
     *connect to db
     * @var PDO
     */
    


    /**
     * 
     * @param array $args
     */
    public function setArgs($args)
    {
        $this->args = $args;
    }
    
    /*
     * return array
     */
    public function getArgs()
    {
        $count = count($this->args);
        $arguments = [];
        
        for($i= 0; $i < $count -1; $i +=2){
            $arguments[$this->args[$i]]= $this->args[$i+1];
        }
       return $arguments;
    }
    
    public function __construct() {
        session_start();
        
        //        if( isset($_COOKIE[session_name()]) && $this->_getSessParam('is_save')) {
//            setcookie(session_name(), session_id(), time() + Model_User::LIFETIME_USER_COOKIE, '/');
//        }
        
        $this->view = new System_View();
        $this->_userId = $this->_getSessParam('currentUser');
    }
       
    public function getParams()
    {
        return $_REQUEST;
    }
    
    /**
     * Save session's data
     * 
     * @param STRING $key
     * @param mixed $value
     */
    protected function _setSessParam($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    
    /**
     * Retrieve data from session
     * 
     * @param string $key
     * @return mixed
     */
    protected function _getSessParam($key)
    {   
        if(!empty($_SESSION)) {
            return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : NULL;
        }
        return NULL;
    }

/**
     * 
     * @param type $key
     * @return mixed
     */
    public function getParamByKey($key)
    {
        return !empty($_REQUEST[$key]) ? $_REQUEST[$key] : NULL;
    }
    
    /**
     * 
     * @return int
     */
    public function getUserId()
    {
        return $this->_userId;
    }
}

