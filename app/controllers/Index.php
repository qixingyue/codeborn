<?php

class IndexController extends AppController {

	protected $layoutFile = "layout.html";

	public function loginAction(){
		if($this->isPost()){
			$email = $this->getRequest()->getPost("email");	
			$password = $this->getRequest()->getPost("password");	
			$user = new UserModel();
			if($user->authLogin($email,$password)){
				return $this->getResponse()->setRedirect(URL::makeURL("index/user"));
			} 
			$this->getView()->assign("error","用户名密码错误!");
		}
		LayoutPlugin::disable();
	}

	public function indexAction(){
		LayoutPlugin::disable();
	}

	public function logoutAction(){
			$user = new UserModel();
			$user->forgetUser();
			LayoutPlugin::disable();
			Yaf_Dispatcher::getInstance()->disableView();
			$this->getResponse()->setRedirect(URL::makeURL("index/index"));
			return ;
	}

	public function userAction(){
		$this->setLayoutFile("admin.html");
	}

}
