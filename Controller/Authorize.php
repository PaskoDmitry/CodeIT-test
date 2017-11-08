<?php
class Controller_Authorize extends System_Controller
{

    public function __construct()
    {
        if (!isset($_COOKIE[session_name()])) {
            session_set_cookie_params(Model_User::LIFETIME_USER_COOKIE);
        }

        parent::__construct();
    }

    public function registerAction()
    {
        header('Content-Type: application/json');

        $params = $this->getParams();

        $userModel = new Model_User();
        try {
            $userId = $userModel->register($params['registerdata']);
            $this->_setSessParam('currentUser', $userId);

            $userData = [
                'id' => $userId,
                'email' => trim($params['registerdata']['email'])
            ];

            echo json_encode($userData);
            die();
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }

    }

    public function loginAction()
    {
        $params = $this->getParams();
        $userModel = new Model_User();
        try {
            $user = $userModel->login($params['logindata']);
            $this->_setSessParam('currentUser', $user->id);
            $this->_setSessParam('userRole', $user->role_id);
            if ($this->getParamByKey('save') == 'true') {
                $this->_setSessParam('is_save', 1);
            }

            $userData = [
                'id' => $user->id,
                'email' => $user->email
            ];

            echo json_encode($userData);
            die();
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
            die();
        }
    }

    public function exitAction()
    {
        $_SESSION = [];

        if (!empty($_COOKIE[session_name()])) {
            unset($_COOKIE[session_name()]);
        }

        session_destroy();
        setcookie(session_name(), '', time(), '/');
        die();
    }

}