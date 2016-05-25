<?php

class TestController extends AppController {

	public function indexAction(){
		parent::indexAction();
		$tpl = <<<EOF
{name}
{for newname in {newname_values}}
{newname} Is A Big World . 

{endfor}
EOF
;

$params = array(
	"name" 		=> 	"world",
	"newname" => 	array("Red","Green","Blue")
);
		$p = new Parser();
		$content = $p->parse($tpl,$params);
		$vars = $p->parseVars($tpl);

		var_dump($vars);

		//echo $content;
	}

}
