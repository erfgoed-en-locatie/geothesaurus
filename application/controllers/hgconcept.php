<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hgconcept extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}


	public function index(){

		$id = $_REQUEST['id'];

		if(!isset($_SERVER['HTTP_ACCEPT'])){ 							// they don't specify, serve html
			$this->html();
		}elseif(preg_match("/rdf\+xml/",$_SERVER['HTTP_ACCEPT'])){ 		// rdf wanted?
			$this->rdfxml();
		}elseif(preg_match("/json/",$_SERVER['HTTP_ACCEPT'])){ 			// json wanted?
			$this->json();
		}elseif(preg_match("/text\/html/",$_SERVER['HTTP_ACCEPT'])){ 	// html wanted?
			$this->html();
		}else{															// any other flavour is ok, as long as it's html
			$this->html();
		}

	}

	public function html(){

		$id = $_REQUEST['id'];

		
		
		$searchstring = 'search?id=' . $id;
		$json = file_get_contents($this->config->item('api_url') . $searchstring );
		$result = json_decode($json,true);
		
		$data['pits'] = array();

		foreach($result['features'][0]['properties']['pits'] as $pit){
			if(!isset($pit['id']) && isset($pit['uri'])){
				$pit['id'] = $pit['uri'];
			}
			$data['pits'][] = $pit;
		}
		
		$calculatedConceptID = hgConceptID($data['pits']);
		if($calculatedConceptID!=$id){
			echo $calculatedConceptID . " is niet " . $id;
			//header("Accept:text/html");
			//header("Location: " . $this->config->item('base_url') . "hgconcept/" . $calculatedConceptID);
		}
		
		$this->load->view('header');
		$this->load->view('hgconcept', $data);
		$this->load->view('footer');

	}



	public function json($id){

		$data['source'] = $source;
		$data['id'] = $id;
		if($extId){
			$data['id'] .= "/" . $extId;
		}

		$apiurl = "https://api.histograph.io/search?";
		
		$searchstring = 'hgid=' . $source . '/' . $data['id'];
		$json = file_get_contents($apiurl . $searchstring );

		$result = json_decode($json,true);
		$data['pits'] = $result['features'][0]['properties']['pits'];

		header('Content-type: application/json; charset=utf-8');
		die($json);

	}



	public function frompit($id){

		$data['source'] = $source;
		$data['id'] = $id;
		if($extId){
			$data['id'] .= "/" . $extId;
		}
		$hgid = $source . '/' . $data['id'];

		$apiurl = "https://api.histograph.io/search?";
		
		$searchstring = 'hgid=' . $hgid;
		$json = file_get_contents($apiurl . $searchstring );
		$result = json_decode($json,true);

		$data['pits'] = $result['features'][0]['properties']['pits'];
		
		$calculatedConceptID = hgConceptID($data['pits']);
		

		header("Accept:text/html");
		header("Location: " . $this->config->item('base_url') . "hgconcept/" . $calculatedConceptID);
	
	}


}


/* end of file */