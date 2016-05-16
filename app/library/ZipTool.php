<?php

class ZipTool {

	public function __construct(){
	}

	public function zipFileList($fileListContents,$zipFile){
		$zipEntry = ZipArchive();	
		if($zipEntry->open($zipFile,ZipArchive::OVERWRITE)===TRUE){
			foreach($fileListContents as $fileName => $fileContent ){
				$zipEntry->addFromString($fileName,$fileContent);	
			}	
			$zipEntry->close();
		}
	}

}
