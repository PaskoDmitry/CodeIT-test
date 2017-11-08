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
     *
     * @return array
     */
    public function getCountry()
    {
        $sql    = 'select * from country';

        $sth    = $this->getConnection()->prepare($sql);

        $sth->execute();

        $result = $sth->fetchAll(PDO::FETCH_OBJ);


        return $result;
    }

    /**
     * @param array $params
     * @return int
     */
    public function create($params)
    {
        $email      = trim($params['email']);
        $login      = trim($params['login']);
        $name       = trim($params['real name']);
        $password   = trim($params['password']);
        $birthDate  = trim($params['date']);
        $country    = trim($params['country']);
        
        $sql = 'INSERT INTO ' . $this->getName() . ' (email,login,`real name`,password,`birth date`,country) VALUES(?,?,?,?,?,?)';
        $sth = $this->getConnection()->prepare($sql);

        $result = $sth->execute([$email, $login, $name, sha1($password),date("Y-m-d", strtotime($birthDate)), $country]);

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
        if(!empty($params['email'])){
            $email = trim($params['email']);
        }elseif (!empty($params['emailOrLogin']) && filter_var($params['emailOrLogin'], FILTER_VALIDATE_EMAIL)){
            $email = $params['emailOrLogin'];
        }else{
            $login = $params['emailOrLogin'];
        }

        $password   = trim($params['password']);

        if(isset($email) && !empty($email)){

            $requestParams = [$email];
            $sql = 'select * from ' . $this->getName() . ' where email = ?';
        }elseif (isset($login) && !empty($login)){

            $requestParams = [$login];
            $sql = 'select * from ' . $this->getName() . ' where login = ?';
        }

        
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
