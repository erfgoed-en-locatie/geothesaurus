<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pit extends CI_Controller {

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

	public function html($source,$id,$extId = false){

		$data['source'] = $source;
		$data['id'] = $id;
		if($extId){
			$data['id'] .= "/" . $extId;
		}

		$apiurl = "https://api.erfgeo.nl/search?";
		
		$pitid = $source . '/' . $data['id'];
		$searchstring = 'hgid=' . $pitid;
		$json = file_get_contents($apiurl . $searchstring );
		$result = json_decode($json,true);

		
		if(isset($result['features'][0]['properties']['pits'])){
			
			$pits = $result['features'][0]['properties']['pits'];
			$data['relations'] = array();

			foreach ($pits as $pit) {
				if($pit['hgid']==$source . '/' . $data['id']){
					$data['pit']['properties'] = $pit;
				}

				if(isset($pit['relations'])){

					foreach ($pit['relations'] as $rType => $relation) {
						if(is_array($relation)){
							foreach ($relation as $k => $toHgId) {
								if($pit['hgid']==$pitid || $toHgId['@id']==$pitid){ // only incoming or outgoing relations of current pit
									$data['relations'][] = array("from" => $pit['hgid'],
														"to" => $toHgId['@id'],
														"relation" => $rType);
								}
							}
						}
						
					}

				}
			}

			$gindex = $data['pit']['properties']['geometryIndex'];
			if($gindex>-1){
				$data['pit']['geometry'] = $result['features'][0]['geometry']['geometries'][$gindex];
			}
			
			$data['hgconcept'] = hgConceptID($pits);

			$this->load->view('header');
			$this->load->view('pit', $data);
			$this->load->view('footer');

			
		}else{
			$data['message']['title'] = "Niet gevonden!";
			$data['message']['text'] = 'De api heeft geen pits gevonden op <a href="' . $apiurl . $searchstring . '">' . $apiurl . $searchstring . '</a>';


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