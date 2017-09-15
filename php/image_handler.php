<?php

class ImageHandler{
	var $DIR;
	function __construct(){
		$this->DIR = "./";
	}
	//$post should have folder name and b64 data
	function save_image($post){
		//check if dir exists, if createe it
		if(!file_exists($this->DIR."/TESTING")){
			mkdir($this->DIR."/TESTING");
		}
		//create file 
		$file = fopen($this->DIR."/TESTING/test.txt", w) or die ("Unable to open file");
		fwrite($file," HELLO MYH NIGGUH");
		fclose($file);
	}
}
?>
