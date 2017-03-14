<?php
class Model_Db_Table_Admin extends System_Db_Table
{
    protected $_name = 'user';

    /**
     * 
     * @param int $id
     * @return array
     */
    public function getAllUser()
    {
        $sql    = 'select * from ' . $this->getName() ;
        
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute(['']);
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        
        return $result;
    }
    
    
     public function update($params)
    {
//        print_r($params);
        $userId      = trim($params['userId']);
//        $login       = trim($params['email']);
        $first_name  = trim($params['first_name']);
        $last_name   = trim($params['last_name']);
        $skills      = trim($params['skills']);
        $year        = trim($params['year']);
        $role_id     = trim($params['role_id']);
        
        $sql = 'UPDATE ' . $this->getName() . ' SET first_name = ?, last_name = ?, skills = ?, year = ?, role_id = ? WHERE id = ?' ;
        $requestParams = [$first_name, $last_name, $skills, $year, $role_id, $userId];
        

        
        $sth = $this->getConnection()->prepare($sql);
        
        $sth->execute($requestParams);
       
        
        
        return true;
    }
    
    public function changePassword($params)
    {
        $userId      = trim($params['userId']);
        $password    = trim($params['password']);
        $newPassword = trim($params['newPassword']);
        
        if($this->checkIfCorrect($userId, $password))
        {
            $sql = 'UPDATE ' . $this->getName() . ' SET password = ? WHERE id = ?' ;
            $requestParams = [sha1($newPassword), $userId];
            
            $sth = $this->getConnection()->prepare($sql);
        
            $sth->execute($requestParams);
        }
        else{
            throw new Exception('Entered password is invalide', /*System_Exception::NOT_FOUND*/113);
        }
        return true;
    }


    public function checkIfCorrect($id, $password)
    {
        $sql = 'SELECT password from '. $this->getName() . ' WHERE id = ?';
        
        $sth = $this->getConnection()->prepare($sql);
        $sth->execute([$id]);
        
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        
        
//    return $result;
        $pass = $result[0]->password;
        $newPass = sha1($password);
        if($pass == $newPass){
            return true;
        }
        else{
            return false;
        }
        
    }
    
    public function delete($params)
    {
        $userId      = trim($params['userId']);
        
//        if($this->checkIfCorrect($userId, $password))
//        {
            $sql = 'DELETE from ' . $this->getName() . ' WHERE id = ?' ;
            $requestParams = [$userId];
            
            $sth = $this->getConnection()->prepare($sql);
        
            $sth->execute($requestParams);
//        }
//        else{
//            throw new Exception('Entered password is invalide', /*System_Exception::NOT_FOUND*/113);
//        }
    }
    
    
}