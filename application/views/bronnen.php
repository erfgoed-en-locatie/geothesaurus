<?



?>


<h1>Bronnen</h1>




<div class="row">
	<div class="col-md-6">

		<? foreach($sources as $source){ ?>

			<div class="source">
				<h3><a href="<?= $this->config->item('base_url') ?>bron/<?= $source['id'] ?>"><?= $source['title'] ?></a></h3>
				<? if(isset($types[$source['id']])){ ?>
					<div class="sourceinfo">
					<? foreach($types[$source['id']] as $type => $number){ ?>
						<?= $type ?> <strong><?= number_format($number,0,",",".") ?></strong>
					<? } ?>
					</div>
				<? } ?>
			</div>

		<? } ?>


	</div>
	<div class="col-md-6">

		
	</div>
</div>


