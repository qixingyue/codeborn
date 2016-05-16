<?php

class ErrorController extends Yaf_Controller_Abstract{

	public function errorAction($exception){
		Yaf_Dispatcher::getInstance()->disableView();
		switch ($exception->getCode()) {
		case YAF_ERR_NOTFOUND_MODULE:
			echo  'MODULE was not found' . "\n";
			break;
		case YAF_ERR_NOTFOUND_CONTROLLER:
			echo  'CONTROLLER was not found' . "\n";
			break;
		case YAF_ERR_NOTFOUND_ACTION:
			echo  'ACTION was not found' . "\n";
			break;
		case YAF_ERR_NOTFOUND_VIEW:
			//header('HTTP/1.1 404 Not Found');
			echo  'VIEW was not found' . "\n";
			print_r($exception);
			break;
		default :
			header('HTTP/1.1 500 Internal Server Error');
			echo 'Application Error' . "\n";
			echo json_encode($exception);
			break;
		}   
	}

}
