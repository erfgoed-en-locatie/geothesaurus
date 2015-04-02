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

		
		
		$data['source'] = $source;

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