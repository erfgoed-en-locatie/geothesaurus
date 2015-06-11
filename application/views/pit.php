<?

// format kenmerken
$props["naam"] = $pit['properties']['name'];
$props["bron"] = '<a href="' . $this->config->item('base_url') . 'bron/' . $pit['properties']['source'] . '">' . $pit['properties']['source'] . '</a>';
if(isset($pit['properties']['uri'])){
	$props['bron uri'] = '<a href="' . $pit['properties']['uri'] . '">' . $pit['properties']['uri'] . '</a>';
}
$props["type"] = $pit['properties']['type'];
$props["permalink"] = '<input class="form-control" type="text" value="' . $this->config->item('base_url') . 'pit/' . $pit['properties']['hgid'] . '" />';
if(isset($pit['properties']['hasBeginning'])){
	$props['startdatum'] = $pit['properties']['hasBeginning'];
}
if(isset($pit['properties']['hasEnd'])){
	$props['einddatum'] = $pit['properties']['hasEnd'];
}

// format relaties

?>


<h1><?= $pit['properties']['name'] ?></h1>



<div class="row">
	<div class="col-md-6">

		<h3>Onderdeel van hgconcept</h3>

		<p><a href="<?= $this->config->item('base_url') ?>hgconcept/<?= $hgconcept ?>"><?= $this->config->item('base_url') ?>hgconcept/<?= $hgconcept ?></a></p>

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
		<? if(isset($pit['properties']['data'])){ ?>
			<table class="table table-striped">
				<? foreach ($pit['properties']['data'] as $k => $v) { ?>
					<tr>
						<th><?= $k ?></th>
						<td><?= $v ?></td>
					</tr>
				<? } ?>
			</table>
		<? } ?>


		<h3>Uitgaande relaties</h3>
		<? if(isset($relations)){ ?>
			<table class="table table-striped">
				<? foreach ($relations as $relation) { ?>
					<? if($relation['from']==$pit['properties']['hgid']){ ?>
						<tr>
							<th><?= $relation['relation'] ?></th>
							<td>
							<a href="<?= $this->config->item('base_url') ?>pit/<?= $relation['to'] ?>"><?= $relation['to'] ?></a>
							</td>
						</tr>
					<? } ?>
				<? } ?>
			</table>
		<? } ?>

		<h3>Inkomende relaties</h3>
		<? if(isset($relations)){ ?>
			<table class="table table-striped">
				<? foreach ($relations as $relation) { ?>
					<? if($relation['to']==$pit['properties']['hgid']){ ?>
						<tr>
							<td>
							<a href="<?= $this->config->item('base_url') ?>pit/<?= $relation['from'] ?>"><?= $relation['from'] ?></a>
							</td>
							<th><?= $relation['relation'] ?></th>
						</tr>
					<? } ?>
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
        maxZoom: 14
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
            "name": "<?= $pit['properties']['name'] ?>"
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






