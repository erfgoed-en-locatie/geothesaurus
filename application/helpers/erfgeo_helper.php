<?

if(!function_exists('hgConceptID')){
	
	function hgConceptID($pits){
		
		$sources = array("tgn","geonames","gemeentegeschiedenis","nationaal-wegenbestand","dbpedia");

		foreach ($sources as $source) {
			foreach ($pits as $pit) {
				if($pit['source']==$source){
					return $pit['hgid'];
				}
			}
		}

		// no preferred sources found?
		return $pits[0]['hgid'];
	
	}

}

if(!function_exists('preferredName')){
	
	function preferredName($pits){
		
		$sources = array("tgn","geonames","gemeentegeschiedenis","nationaal-wegenbestand","dbpedia");

		foreach ($sources as $source) {
			foreach ($pits as $pit) {
				if($pit['source']==$source){
					return $pit['name'];
				}
			}
		}

		// no preferred names found?
		return $pits[0]['hgid'];
	
	}

}


?>