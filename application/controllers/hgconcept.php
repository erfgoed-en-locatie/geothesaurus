<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hgconcept extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}


	public function deliver($source,$id,$extId = false){

		if(!isset($_SERVER['HTTP_ACCEPT'])){ 							// they don't specify, serve html
			$this->html($source,$id,$extId);
		}elseif(preg_match("/rdf\+xml/",$_SERVER['HTTP_ACCEPT'])){ 		// rdf wanted?
			$this->rdfxml($source,$id,$extId);
		}elseif(preg_match("/json/",$_SERVER['HTTP_ACCEPT'])){ 			// json wanted?
			$this->json($source,$id,$extId);
		}elseif(preg_match("/text\/html/",$_SERVER['HTTP_ACCEPT'])){ 	// html wanted?
			$this->html($source,$id,$extId);
		}else{															// any other flavour is ok, as long as it's html
			$this->html($source,$id,$extId);
			
		}

	}

	public function html($source,$id,$extId){

		$data['source'] = $source;
		$data['id'] = $id;
		if($extId){
			$data['id'] .= "/" . $extId;
		}

		$apiurl = "http://api.histograph.io/search?";
		
		$searchstring = 'hgid=' . $source . '/' . $data['id'];
		$json = file_get_contents($apiurl . $searchstring );
		$result = json_decode($json,true);

		$data['pits'] = $result['features'][0]['properties']['pits'];
		
		//print_r($data);

		$this->load->view('header');
		$this->load->view('hgconcept', $data);
		$this->load->view('footer');

	}



	public function json($source,$id,$extId){

		$data['source'] = $source;
		$data['id'] = $id;
		if($extId){
			$data['id'] .= "/" . $extId;
		}

		$apiurl = "http://api.histograph.io/search?";
		
		$searchstring = 'hgid=' . $source . '/' . $data['id'];
		$json = file_get_contents($apiurl . $searchstring );


		header('Content-type: application/json; charset=utf-8');
		die($json);

	}


}


/* end of file */