<?php
class Model_Db_Table_User extends System_Db_Table
{
    protected $_name = 'user';
    
    /**
     * 
     * @param int $id
     * @return array id
     */
    public function getById($id)
    {
        $sql    = 'select * from ' . $this->getName() . ' where id = ?';
        
        $sth    = $this->getConnection()->prepare($sql);
        
        $sth->execute([$id]);
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        
        
        return $result;
    }
   
    /**
     * @param array $params
     * @return int 
     */
    public function create($params)
    {
        $login      = trim($params['email']);
        $password   = trim($params['password']);
        
        $sql = 'INSERT INTO ' . $this->getName() . ' (email,password) VALUES(?,?)';
        $sth = $this->getConnection()->prepare($sql);
        
        $result = $sth->execute([$login, sha1($password)]);
       
        if($result) {
            return $this->getConnection()->lastInsertId();
        }
    }
    
    public function createUser($params)
    {
        $login       = trim($params['email']);
        $first_name  = (!empty($params['first_name'])) ? trim($params['first_name']) : ' ';
        $last_name   = (!empty($params['last_name'])) ? trim($params['last_name']) : ' ';
        $skills      = (!empty($params['skills'])) ? trim($params['skills']) : 'HTML';
        $year        = (!empty($params['year'])) ? trim($params['year']) : ' ';
        $role_id     = (!empty($params['role_id'])) ? trim($params['role_id']) : '2';
        $password    = trim($params['password']);
//        $password1    = trim($params['password1']);
        
        $sql = 'INSERT INTO ' . $this->getName() . ' (email, first_name, last_name, skills, year, role_id, password) VALUES(?,?,?,?,?,?,?)';
        $requestParams = [$login, $first_name, $last_name, $skills, $year, $role_id, sha1($password)];
        
        
        $sth = $this->getConnection()->prepare($sql);
        
        $result = $sth->execute($requestParams);
        
         
        if($result) {
            return $this->getConnection()->lastInsertId();
        }
    }
    
    /**
     * 
     * @param array $params
     * @param int $mode
     * @return array
     */
    public function checkIfExists($params, $mode = Model_User::MODE_REGISTER)
    {
        $login      = trim($params['email']);
        $password   = trim($params['password']);
        
        $requestParams = [$login];
        
        $sql = 'select * from ' . $this->getName() . ' where email = ?';
        
        if($mode == Model_User::MODE_LOGIN) {
            $sql .= ' AND password = ?';
            array_push($requestParams, sha1($password));
        }
        
        /**
         * @var PDOStatement $sth 
         */
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute($requestParams);
        $result = $sth->fetchAll(PDO::FETCH_OBJ);        
         
        
//        echo '<pre>';
//        print_r($result);
//        echo '</pre>';
//        die;
        return $result;
    }

}
