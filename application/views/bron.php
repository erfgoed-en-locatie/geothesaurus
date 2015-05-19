<?



?>


<h1><?= $source['title'] ?></h1>



<div class="row">
	<div class="col-md-6">

		<p><?= nl2br(hrefUrl($source['description'])) ?></p>

		
		<h3>Bewerkingen</h3>

		<p><?= nl2br($source['edits']) ?></p>


	</div>
	<div class="col-md-6">

		<h3>Auteur</h3>

		<p><?= $source['author'] ?></p>

		<h3>Licentie</h3>

		<p><?= $source['license'] ?></p>

		<h3>Website</h3>

		<p><?= hrefUrl($source['website']) ?></p>

		<h3>Bewerker</h3>

		<p><?= $source['editor'] ?></p>


	</div>
</div>


