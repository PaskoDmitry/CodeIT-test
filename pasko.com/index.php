<?php
error_reporting(E_ALL);
define('DS', DIRECTORY_SEPARATOR);
// Find the path to the file of site
$site_path = realpath(dirname(__FILE__) . DS) . DS;

define('SITE_PATH', $site_path);

$config = file_get_contents(SITE_PATH . DS . 'config.xml');
$configXML = new SimpleXMLElement($config);

$host     = (string) $configXML->db->host;
$dbname   = (string) $configXML->db->dbname;
$username = (string) $configXML->db->username;
$password = (string) $configXML->db->password;


try{
    $db = new PDO('mysql:host='.$host.';dbname='.$dbname, $username, $password);
} catch (PDOException $e) {
    echo 'Error!' . $e->getMessege();
}



spl_autoload_register('loadClass');

/**
 * 
 * Function that implements autoloading a file with the desired class,
 * By the principle: the class name is the path of the file where it is stored.
 * 
 * @param string $className
 * @throws Exception
 */
function loadClass($className){
    $path = explode('_', $className);
    $file = '';
    // создаем путь к файлу(по имени класса)
    foreach ($path as $item){
        $file .= $item.DS;
    }
   
   $file = substr($file,0,-1).'.php';
   
   if(file_exists($file)){
       include_once $file;
   }
   else {
       throw new Exception('File '.$file.' not fount', 1);
   }
}


try {
    System_Registry :: set('connection', $db);
    $router = new System_Router();
    
    $router->setPath(SITE_PATH . 'Controller');
    $router->start();
}
catch(Exception $e) {
    echo $e->getMessage();
}