<?

if($count==1){
	$resultaten = "resultaat";
}else{
	$resultaten = "resultaten";
}

?>


<h1>Doorzoek de Geothesaurus</h1>



<form action="<?= $this->config->item('base_url') ?>">

<input style="width:50%;" value="<?= $q ?>" type="text" class="floatinput form-control" name="q" /> <button class="btn btn-primary">zoek</button>


</form>

<? if(isset($_GET['q'])){ ?>
	<h2><?= $count ?> <?= $resultaten ?> gevonden</h2>
<? }else{ ?>
	<p>De Geothesaurus bevat geografische plaatsaanduidingen en hun historische benamingen voor dat al uit tal van bronnen. Een PiT (Plaats in Tijd) is de representatie van een plaats, gemeente, straat, etc. uit één zo'n bron. Een hgconcept is een verzameling PiTs die dezelfde plaats, gemeente, straat, etc. betreffen.</p>

	<p>De Geothesaurus maakt gebruik van de Histograph API en is eveneens ontwikkeld binnen het project Erfgoed &amp; Locatie. Let op: zowel de Geothesaurus als de onderliggende data bevinden zich nog in een pril stadium en zijn aan verandering onderhevig!</p>

	<p>Mocht u onvolkomenheden bespeuren of vragen hebben, dan kunt u zich per mail richten tot erfgoedenlocatie@den.nl</p>
<? } ?>
<div id="results">

<? foreach ($results as $result) { 


	?>
	<div class="result">
		<h3><a href="<?= $this->config->item('base_url') ?>hgconcept/?id=<?= hgConceptID($result['properties']['pits']) ?>"><?= preferredName($result['properties']['pits']) ?><?= getBroader($result['properties']['pits']) ?></a><span class="light">, <?= $result['properties']['type'] ?></span></h3>
	</div>
<? } ?>

</div>