<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bron extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}


	public function deliver($source){

		if(!isset($_SERVER['HTTP_ACCEPT'])){ 							// they don't specify, serve html
			$this->html($source);
		}elseif(preg_match("/rdf\+xml/",$_SERVER['HTTP_ACCEPT'])){ 		// rdf wanted?
			$this->rdfxml($source);
		}elseif(preg_match("/json/",$_SERVER['HTTP_ACCEPT'])){ 			// json wanted?
			$this->json($source);
		}elseif(preg_match("/text\/html/",$_SERVER['HTTP_ACCEPT'])){ 	// html wanted?
			$this->html($source);
		}else{															// any other flavour is ok, as long as it's html
			$this->html($source);
			
		}

	}

	public function html($source){

		
		
		$apiurl = "https://api.histograph.io/";
		
		$searchstring = 'sources/' . $source;


		$json = file_get_contents($apiurl . $searchstring );
		$result = json_decode($json,true);

		$fields = array("title", 
						"description", 
						"edits", 
						"editor", 
						"license", 
						"author", 
						"website", 
						"sourceCreationDate"
						);
		foreach($fields as $field){
			
			if(isset($result[$field])){
				$data['source'][$field] = $result[$field];
			}else{
				$data['source'][$field] = "";
			}
			
		}

		$this->load->view('header');
		$this->load->view('bron', $data);
		$this->load->view('footer');

	}



	public function json($source){



		//header('Content-type: application/json; charset=utf-8');
		//die($json);

	}


}


/* end of file */