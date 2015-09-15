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
		$data['type'] = "";

		if(isset($result['features'][0]['properties']['pits'])){
			foreach($result['features'][0]['properties']['pits'] as $pit){
				if(!isset($pit['id']) && isset($pit['uri'])){
					$pit['id'] = $pit['uri'];
				}
				if(!isset($pit['name'])){
					$pit['name'] = "";
				}
				if(!isset($pit['dataset'])){
					$pit['dataset'] = "";
				}
				$pit['sortyear'] = -100000; // should be safe even for dutch archeology
				$pit['startyear'] = "";
				$pit['endyear'] = "";
				if(isset($pit['validSince'])){
					if(is_array($pit['validSince'])){
						$pit['sortyear'] = (int)date("Y",strtotime($pit['validSince'][0]));
						$pit['startyear'] = date("Y",strtotime($pit['validSince'][0]));
						if($pit['startyear'] != date("Y",strtotime($pit['validSince'][1]))){
							$pit['startyear'] .= "/" . date("Y",strtotime($pit['validSince'][1]));
						}
					}else{
						$pit['sortyear'] = (int)date("Y",strtotime($pit['validSince']));
						$pit['startyear'] = date("Y",strtotime($pit['validSince']));
					}
				}
				if(isset($pit['validUntil'])){
					if(is_array($pit['validUntil'])){
						$pit['endyear'] = date("Y",strtotime($pit['validUntil'][0]));
						if($pit['endyear']!=date("Y",strtotime($pit['validUntil'][1]))){
							$pit['endyear'] .= "/" . date("Y",strtotime($pit['validUntil'][1]));
						}
					}else{
						$pit['endyear'] = date("Y",strtotime($pit['validUntil']));
					}
				}

				$data['pits'][] = $pit;

				if(isset($pit['type'])){
					$data['type'] = $pit['type'];
				}
			}
		}
		
		$calculatedConceptID = hgConceptID($data['pits']);
		if($calculatedConceptID!=$id){
			//echo $calculatedConceptID . " is niet " . $id;
			//header("Accept:text/html");
			//header("Location: " . $this->config->item('base_url') . "hgconcept/" . $calculatedConceptID);
		}

		// order pits by validSince
		$starts = array();
		foreach ($data['pits'] as $k => $v) {
			$starts[] = $v['sortyear'];
		}
		array_multisort($starts,SORT_ASC, $data['pits']);
		
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