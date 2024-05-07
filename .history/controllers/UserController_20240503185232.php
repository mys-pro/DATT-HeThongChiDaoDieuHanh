<?php
class UserController extends BaseController {
    public function login() {
        if(isset($_POST['login'])) {
            $this->view('statistical.show', [
                'pageTitle' => 'Thống kê',
                'active' => __FUNCTION__,
            ]);
            exit;
        }

        $this->view('users.login');
    }
}