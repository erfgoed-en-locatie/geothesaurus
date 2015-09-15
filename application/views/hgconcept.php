<?

$pvflabels = array("existence" => "bestaan", "geometry" => "geometrie", "toponym" => "toponiem");

?>


<h1><?= preferredName($pits) ?></h1>

<? if(count($pits)==0){ ?>
	<p>De door u gevolgde url heeft geen resultaat opgeleverd.</p>
<? }else{ ?>
<p>Dit concept van het type <em><?= $type ?></em> is samengesteld uit de volgende 'Plaatsen in Tijd' (PiT's)</p>


<table class="table table-striped sortable">
	
	<thead>
		<tr><th colspan="6"><h3>PiT's met een geometrie</h3></th></tr>
		<tr>
			<th>naam</th>
			<th>tijd-begin</th>
			<th>tijd-eind</th>
			<th>tijd-van</th>
			<th>PiT</th>
			<th>bron</th>
		</tr>
	</thead>
	<tbody>
	<? foreach ($pits as $pit) { ?>
		<? if($pit['geometryIndex']>-1){ ?>
			<tr class="pit">
				<td><?= $pit['name'] ?></td>
				<td><?= $pit['startyear'] ?></td>
				<td><?= $pit['endyear'] ?></td>
				<td>
					<? if(isset($pit['data']['periodValidFor'])){ ?>
					<img class="pvf-icon" src="<?= $this->config->item('base_url') ?>assets/imgs/<?= $pit['data']['periodValidFor'] ?>.png" title="periode geldig voor <?= $pvflabels[$pit['data']['periodValidFor']] ?>" />
					<? } ?>
				</td>
				<td>
					<? if($pit['dataset'] != ""){ ?>
						<a href="<?= $this->config->item('base_url') ?>pit/?id=<?= $pit['id'] ?>"><?= $pit['id'] ?></a>
					<? }else{ ?>
						<?= $pit['id'] ?>
					<? } ?>
				</td>
				<td><a href="<?= $this->config->item('base_url') ?>bron/<?= $pit['dataset'] ?>"><?= $pit['dataset'] ?></a></td>
			</tr>
		<? } ?>
	<? } ?>
	

	<tr><th colspan="6"><h3>PiT's zonder geometrie</h3></th></tr>


	<? foreach ($pits as $pit) { ?>
		<? if($pit['geometryIndex']<0){ ?>
			<tr class="pit">
				<td><?= $pit['name'] ?></td>
				<td><?= $pit['startyear'] ?></td>
				<td><?= $pit['endyear'] ?></td>
				<td>
					<? if(isset($pit['data']['periodValidFor'])){ ?>
					<img class="pvf-icon" src="<?= $this->config->item('base_url') ?>assets/imgs/<?= $pit['data']['periodValidFor'] ?>.png" title="periode geldig voor <?= $pvflabels[$pit['data']['periodValidFor']] ?>" />
					<? } ?>
				</td>
				<td>
					<? if($pit['dataset'] != ""){ ?>
						<a href="<?= $this->config->item('base_url') ?>pit/?id=<?= $pit['id'] ?>"><?= $pit['id'] ?></a>
					<? }else{ ?>
						<?= $pit['id'] ?>
					<? } ?>
				</td>
				<td><a href="<?= $this->config->item('base_url') ?>bron/<?= $pit['dataset'] ?>"><?= $pit['dataset'] ?></a></td>
			</tr>
		<? } ?>
	<? } ?>
	</tbody>
</table>

<? } ?>

