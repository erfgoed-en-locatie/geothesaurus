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
		return $pits[0]['name'];
	
	}

}


if(!function_exists('hrefUrl')){
	
	function hrefUrl($text){
		
		$sources = array("tgn","geonames","gemeentegeschiedenis","nationaal-wegenbestand","dbpedia");

		$pattern = "/(https?:\/\/[^ ]+)/";
		$replacement = '<a href="$1" target="_blank">$1</a>';

		$text = preg_replace($pattern, $replacement, $text);
		
		return $text;
	
	}

}


?>