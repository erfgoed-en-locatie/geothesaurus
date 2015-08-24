<?

// format kenmerken
$props["naam"] = $pit['name'];
$props["bron"] = '<a href="' . $this->config->item('base_url') . 'bron/' . $pit['dataset'] . '">' . $pit['dataset'] . '</a>';
if(isset($pit['uri'])){
	$props['bron uri'] = '<a href="' . $pit['uri'] . '">' . $pit['uri'] . '</a>';
	$pitid = $pit['uri'];
}else{
	$pitid = $pit['id'];
}
$props["type"] = $pit['type'];
$props["permalink"] = '<input class="form-control" type="text" value="' . $this->config->item('base_url') . 'pit/?id=' . $pitid . '" />';
if(isset($pit['validSince'])){
	if(is_array($pit['validSince'])){
		$pit['validSince'] = implode(" - ", $pit['validSince']);
	}
	$props['startdatum'] = $pit['validSince'];
}
if(isset($pit['validUntil'])){
	if(is_array($pit['validUntil'])){
		$pit['validUntil'] = implode(" - ", $pit['validUntil']);
	}
	$props['einddatum'] = $pit['validUntil'];
}

?>


<h1><?= $pit['name'] ?></h1>



<div class="row">
	<div class="col-md-6">

		<h3>Onderdeel van hgconcept</h3>

		<p><a href="<?= $this->config->item('base_url') ?>hgconcept/?id=<?= $hgconcept ?>"><?= $this->config->item('base_url') ?>hgconcept/?id=<?= $hgconcept ?></a></p>

		<h3>Kenmerken</h3>

		<table class="table table-striped">
		<? foreach($props as $fieldname => $prop){ ?>
			<tr>
			<th><?= $fieldname ?></th>
			<td><?= $prop ?></td>
			</tr>
		<? } ?>
		</table>


		<h3>Additionele data uit bron</h3>
		<? if(isset($pit['data'])){ ?>
			<table class="table table-striped">
				<? foreach ($pit['data'] as $k => $v) { ?>
					<tr>
						<th><?= $k ?></th>
						<td>
							<? if(is_array($v)) { ?>
								<?=  implode(', ', $v) ?>
							<? } else { ?>
								<?= $v ?>
							<? } ?>
						</td>
					</tr>
				<? } ?>
			</table>
		<? } ?>


		<h3>Uitgaande relaties</h3>
		<? if(isset($hairs)){ ?>
			<table class="table table-striped">
				<? foreach ($hairs as $hair) { ?>
					<tr>
						<th><?= $hair['relation'] ?></th>
						<td>
						<a href="<?= $this->config->item('base_url') ?>pit/?id=<?= $hair['@id'] ?>"><?= $hair['name'] ?></a>
						</td>
					</tr>
				<? } ?>
			</table>
		<? } ?>

		



	</div>
	<div class="col-md-6">

		<? if(isset($pit['geometry'])){ ?>

			<div style="height:300px; background-color:#eee;" id="map"></div>

			<h3>GeoJSON</h3>

			<textarea rows="6" class="form-control" id="geojson"></textarea>

		<? } ?>
	</div>
</div>


<? if(isset($pit['geometry'])){ ?>
<script>

	var southWest = L.latLng(51.175, 3.001), northEast = L.latLng(53.549, 7.483), bounds = L.latLngBounds(southWest, northEast);
    var map = L.map('map').fitBounds(bounds);

	L.tileLayer('//{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    var mapIcon = L.icon({
        iconUrl: '/images/map-marker-128x128.png',
        iconSize:     [32, 32], // size of the icon
        shadowSize:   [50, 64], // size of the shadow
        iconAnchor:   [16, 32], // point of the icon which will correspond to marker's location
        shadowAnchor: [4, 62],  // the same for the shadow
        popupAnchor:  [-3, -26] // point from which the popup should open relative to the iconAnchor
    });

    var geojsonFeature = {
        "type": "Feature",
        "properties": {
            "name": "<?= $pit['name'] ?>"
        },
        "geometry": <?= json_encode($pit['geometry']) ?>
    };

    var placesLayer = L.geoJson().addTo(map);
    var geom = placesLayer.addData(geojsonFeature);

    map.fitBounds(placesLayer);

    var geojsonString = JSON.stringify(geojsonFeature, null, 2);
    jQuery('#geojson').html(geojsonString);




    // beautify geojson
    var myCodeMirror = CodeMirror.fromTextArea(document.getElementById('geojson'));
    
</script>
<? } ?>






