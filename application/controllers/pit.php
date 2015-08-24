<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pit extends CI_Controller {

	public function __construct(){
		parent::__construct();
		
	}


	public function index(){
		
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

		$pitid = $_REQUEST['id'];

		$searchstring = 'search?id=' . $pitid;
		$json = file_get_contents($this->config->item('api_url') . $searchstring );
		$result = json_decode($json,true);

		if(isset($result['features'][0]['properties']['pits'])){
			
			$pits = $result['features'][0]['properties']['pits'];
			$data['relations'] = array();

			foreach ($pits as $pit) {
				if(isset($pit['uri']) && $pit['uri']==$pitid){
					$data['pit'] = $pit;
				}elseif(isset($pit['id']) && $pit['id']==$pitid){
					$data['pit'] = $pit;
				}
			}

			$gindex = $data['pit']['geometryIndex'];
			if($gindex>-1){
				$data['pit']['geometry'] = $result['features'][0]['geometry']['geometries'][$gindex];
			}
			
			$data['hgconcept'] = hgConceptID($pits);
			$data['hairs'] = getHairs($data['pit']);



			$this->load->view('header');
			$this->load->view('pit', $data);
			$this->load->view('footer');

			
		}else{

			$data['message']['title'] = "Geen PiT gevonden!";
			$data['message']['text'] = 'De api heeft geen pits gevonden op <a href="' . $this->config->item('api_url') . $searchstring . '">' . $this->config->item('api_url') . $searchstring . '</a>';
			$data['message']['text'] .= '<br /><br />Wellicht betreft het een verwijzing naar de externe uri <a href="' . $pitid . '">' . $pitid . '</a>';
	

			$this->load->view('header');
			$this->load->view('notfound', $data);
			$this->load->view('footer');
		}

		

	}



	public function json($source,$id,$extId = false){

		$data['source'] = $source;
		$data['id'] = $id;
		if($extId){
			$data['id'] .= "/" . $extId;
		}

		$apiurl = "https://api.histograph.io/search?";
		$hgid = $source . '/' . $data['id'];
		$searchstring = 'hgid=' . $hgid;
		$json = file_get_contents($apiurl . $searchstring );

		$result = json_decode($json,true);

		$pits = $result['features'][0]['properties']['pits'];
		$hgconcept = hgConceptID($pits);
		
		foreach ($pits as $pit) {
			if($pit['hgid']==$source . '/' . $data['id']){
				$data['pit']['properties'] = $pit;
			}
		}

		//$returndata = array("uri" => "http://geothesaurus/pit/" . $hgid, "hgconcept" => "http://geothesaurus/hgconcept/" . $hgconcept);

		$geometryIndex = $data['pit']['properties']['geometryIndex'];


		$returndata['geojson']['type'] = "Feature";
		$returndata['geojson']['properties'] = $data['pit']['properties'];
		$returndata['geojson']['properties']['uri'] = "http://geothesaurus.nl/pit/" . $hgid;
		$returndata['geojson']['properties']['hgconcept'] = "http://geothesaurus.nl/hgconcept/" . $hgconcept;

		if($geometryIndex<0){
			$returndata['geojson']['geometry'] = null;
		}else{
			$returndata['geojson']['geometry'] = $result['features'][0]['geometry']['geometries'][$geometryIndex];
		}
		
		//print_r($returndata);


		//print_r($result);
		header('Content-type: application/json; charset=utf-8');
		die(json_encode($returndata['geojson']));

	}


}


/* end of file */