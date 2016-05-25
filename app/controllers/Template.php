<?php

class TemplateController extends AppController {

	public function indexAction(){
			$templateModel = new TemplateModel(); 
			$offset = $this->getRequest()->getQuery("offset");
			$limit = $this->getRequest()->getQuery("limit");
			if($offset == NULL) {
				$offset = 0;	
			}

			if( NULL == $limit) {
				$limit = 20;	
			}

			$data = $templateModel->userTemplates(cUid(),$offset,$limit);
			$howmany = $templateModel->userHowmany(cUid());
			$this->getView()->assign("data",$data);
			$this->getView()->assign("howmany",$howmany);

	}

	public function createAction(){
		if($this->isPost()){
			$name = $this->getRequest()->getPost("name");	
			$en_name = $this->getRequest()->getPost("en_name");	
			$content = $this->getRequest()->getPost("content");
			$tag = $this->getRequest()->getPost("tag");
			$templateModel = new TemplateModel(); 
			$res = $templateModel->createNew($name,$en_name,$content,$tag);
			if($res) {
				return $this->getResponse()->setRedirect(URL::makeURL("template/index"));
			}
			$this->getView()->assign("error","创建新模板失败!");
		}
	}

	public function delAction(){
			$id = $this->getRequest()->getPost('id');	
			$model = new TemplateModel();
			$this->baseDelById($id);
	}

	public function editAction($id){
		$model = new TemplateModel();
		$item = $model->findById($id);
		if(false === $item) {
			$this->jsonMessage(false,"不存在请求的数据!");
			return ;
		}
		$this->getView()->assign('item',$item);
		if($this->isPost()){
			$name = $this->getRequest()->getPost("name");	
			$en_name = $this->getRequest()->getPost("en_name");	
			$content = $this->getRequest()->getPost("content");
			$tag = $this->getRequest()->getPost("tag");
			$templateModel = new TemplateModel(); 
			$res = $templateModel->updateItem($id,$name,$en_name,$content,$tag);
			if($res){
				return $this->getResponse()->setRedirect(URL::makeURL('template/index'));	
			}
			$this->getView()->assign("error","修改模板失败!");
		}
	}

}
