<?php

class Parser {

	public function parseVars($content){
		$not_vars = array(
			'{endfor}'	
		);
		$reg = '/\{[A-Za-z_]+?\}/';	
		preg_match_all($reg,$content,$matches);
		$matches = $matches[0];
		foreach($matches as $index => $match){
			if(in_array($match,$not_vars))	{
				unset($matches[$index]);	
			} else {
				$real_var_name = trim($match,"{}");					
				$if_var_values_name = '{' . $real_var_name . '_values}' ;
				if(in_array($if_var_values_name,$matches)){
					unset($matches[$index]);
				}
			}
		}	
		foreach($matches as $k=>$v){
			$matches[$k] = trim($v,"{}");
		}
		return $matches;	
	}

	public function parse($tplStr,$params){
		$reg = "/(\{for\s([A-Za-z]+)\s+in\s+\"([^\"]+)\"\})([\s\S]+?)(\{endfor\})/";
		$content = $tplStr;
		foreach($params as $k=>$v){
			if(is_array($v)){
				$n = '{'.$k.'_values}';
				$content = str_replace($n,'"' . implode(",",$v) . '"',$content);	
			} else {
				$content = str_replace("{" . $k . "}",$v,$content);	
			}
		}
		$content = preg_replace_callback($reg,array($this,"replaceCallBack"),$content);
		return $content;
	}

	private function replaceCallBack($matches){
		$r = "";
		$var_name = $matches[2];
		$values = explode(",",$matches[3]);
		$t = $matches[4];
		$t = ltrim($t);

		foreach($values as $value){
			$r .= str_replace('{'.$var_name.'}',$value,$t); 
		}



		return $r;
	}

}
