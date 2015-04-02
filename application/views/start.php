<?

if($count==1){
	$resultaten = "resultaat";
}else{
	$resultaten = "resultaten";
}

?>


<h1>Geothesaurus</h1>

<p></p>

<form action="<?= $this->config->item('base_url') ?>">

<input style="width:50%;" value="<?= $q ?>" type="text" class="floatinput form-control" name="q" /> <button class="btn btn-primary">zoek</button>


</form>

<? if(isset($_GET['q'])){ ?><h2><?= $count ?> <?= $resultaten ?> gevonden</h2><? } ?>
<div id="results">

<? foreach ($results as $result) { 


	?>
	<div class="result">
		<h3><a href="<?= $this->config->item('base_url') ?>hgconcept/<?= hgConceptID($result['properties']['pits']) ?>"><?= preferredName($result['properties']['pits']) ?></a></h3>
	</div>
<? } ?>

</div>