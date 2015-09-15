<?

if(!function_exists('hgConceptID')){
	
	function hgConceptID($pits){
		
		//print_r($pits);
		$sources = array("tgn","geonames","gemeentegeschiedenis","nationaal-wegenbestand","dbpedia");

		foreach ($sources as $source) {
			foreach ($pits as $pit) {
				if(isset($pit['dataset']) && $pit['dataset']==$source){
					if(isset($pit['uri'])){
						return $pit['uri'];
					}else{
						return $pit['id'];
					}
				}
			}
		}
		
		// no preferred sources found?
		foreach ($pits as $pit) {
			if(isset($pit['dataset']) && $pit['dataset']!=""){
				if(isset($pit['uri'])){
					return $pit['uri'];
				}else{
					return $pit['id'];
				}
			}
		}

		if(isset($pits[0]['id'])){
			return $pits[0]['id'];
		}

		// if all else fails
			return "not found";
	
	}

}

if(!function_exists('preferredName')){
	
	function preferredName($pits){
		
		// first, get most used name
		$frequency = array();
		foreach ($pits as $key => $pit) {
			if(isset($pit['name'])){
				if(isset($frequency[$pit['name']]) && $pit['name']!=""){
					$frequency[$pit['name']]++;
				}elseif($pit['name']!=""){
					$frequency[$pit['name']]=1;
				}
			}
		}
		arsort($frequency);
		$usage = array();
		foreach ($frequency as $key => $value) {
			$usage[] = array($key,$value);
		}
		
		$sources = array("tgn","geonames","gemeentegeschiedenis","nationaal-wegenbestand","dbpedia");

		foreach ($sources as $source) {
			foreach ($pits as $pit) {
				if(isset($pit['dataset']) && $pit['dataset']==$source){
					if($usage[0][1] > $frequency[$pit['name']]){ 
						return $usage[0][0];						// most used name
					}else{
						return $pit['name'];						// fav dataset name
					}
				}
			}
		}
		
		// no preferred names found?
		if(isset($usage[0][0])){
			return $usage[0][0];
		}else{
			return "";
		}
		
	
	}

}


if(!function_exists('hrefUrl')){
	
	function hrefUrl($text){
		
		$sources = array("tgn","geonames","gemeentegeschiedenis","nwb","bag","dbpedia");

		$pattern = "/(https?:\/\/[^ ]+)/";
		$replacement = '<a href="$1" target="_blank">$1</a>';

		$text = preg_replace($pattern, $replacement, $text);
		
		return $text;
	
	}

}

if(!function_exists('getBroader')){
	
	function getBroader($pits){
		
		$broader = array();
		
		foreach ($pits as $pit) {
			if(isset($pit['relations']['hg:liesIn'])){

				$broaderIds = array();

				foreach($pit['relations']['hg:liesIn'] as $liesIn){
					$broaderIds[] = $liesIn['@id'];
				}

				foreach ($pit['hairs'] as $hair) {
					if(in_array($hair['@id'],$broaderIds)){
						if(isset($hair['name'])){
							$broader[] = $hair['name'];
						}
					}
				}
			}
		}
		
		if(count($broader)>0){
			return ", " . implode(" / ",$broader);
		}else{
			return "";
		}
	}

}

if(!function_exists('getHairs')){
	
	function getHairs($pit){
		
		if(isset($pit['hairs'])){

			$hairs = $pit['hairs'];

			for($i=0; $i<count($hairs); $i++) {
				foreach ($pit['relations'] as $relationkey => $relationvalue) {
					if(is_array($relationvalue)){
						foreach ($relationvalue as $key => $value) {
							if($hairs[$i]['@id']==$value['@id']){
								$hairs[$i]['relation'] = $relationkey;
							}
						}
					}
					
				}

				// if a relation exist to external uri we don't have a name
				if(!isset($hairs[$i]['name'])){
					$hairs[$i]['name'] = $hairs[$i]['@id'];
				}
			}
			
			return $hairs;
		}
		
		return array();
	}

}


?>