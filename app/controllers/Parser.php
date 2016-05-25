<?php

class ParserController extends AppController {

	public function doAction(){
		$this->onlyText();
		if($this->isPost()) {
			$tplName = $this->getRequest()->getPost("tpl");
			$templateModel = new TemplateModel();
			$templateInfo = $templateModel->findTemplateByName($tplName);
			if(false == $templateInfo || empty($templateInfo)) {
				echo "NO TEMPLATE FOUND . ";	
			}
			$templateInfo = $templateInfo[0];
			$params = array();
			$p = new Parser();	
			$expectVars = $p->parseVars($templateInfo['content']);
			foreach($expectVars as $varName){
				$params[$varName]	= $this->getRequest()->getPost($varName);
			}
			echo $p->parse($templateInfo['content'],$params);
		} else {
			echo "ONLY POST METHOD \n";
		}
	}

}
