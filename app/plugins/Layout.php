<?php
class LayoutPlugin extends Yaf_Plugin_Abstract {

    private $_layoutDir;
    private $_layoutFile;
    private $_layoutVars =array();
		private $_disabled = false;

		public static function getInstance(){
			return Yaf_Registry::get("layout");	
		}

		public static function setLayoutFile($layoutFile){
			$lp = Yaf_Registry::get("layout");	
			$lp->_setLayoutFile($layoutFile);
		}

		public static function setVars($name,$value){
			$lp = Yaf_Registry::get("layout");	
			$lp->__set($name,$value);
		}

		public static function disable(){
			$lp = Yaf_Registry::get("layout");	
			$lp->_disable();
		}

		public function _setLayoutFile($layoutFile){
        $this->_layoutFile = $layoutFile;
		}

    public function __construct($layoutFile, $layoutDir=null){
        $this->_layoutFile = $layoutFile;
        $this->_layoutDir = ($layoutDir) ? $layoutDir : APP_PATH.'/views/layouts/';
    }

    public function  __set($name, $value) {
        $this->_layoutVars[$name] = $value;
    }

		public function _disable($flag = true){
			$this->_disabled = $flag;	
		}

    public function dispatchLoopShutdown ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

    }

    public function dispatchLoopStartup ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

    }

    public function postDispatch ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

			if($this->_disabled){
				return ;	
			}

			/* get the body of the response */
			$body = $response->getBody();

			if(false === strpos($body,'<!--THIS IS LAYOUT-->')){
				/*clear existing response*/
				$response->clearBody();
				/* wrap it in the layout */
				$layout = new Yaf_View_Simple($this->_layoutDir);
				$layout->content = $body;
				$layout->assign('layout', $this->_layoutVars);

				/* set the response to use the wrapped version of the content */
				$response->setBody($layout->render($this->_layoutFile));
			}
		}

    public function preDispatch ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){
 
    }

    public function preResponse ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){
			
    }

    public function routerShutdown ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

    }

    public function routerStartup ( Yaf_Request_Abstract $request , Yaf_Response_Abstract $response ){

    }
}

