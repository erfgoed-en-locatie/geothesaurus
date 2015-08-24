<?


?>


<h1><?= preferredName($pits) ?></h1>

<p>Dit concept van het type <em><?= $pits[0]['type'] ?></em> is samengesteld uit de volgende 'Plaatsen in Tijd' (PiT's)</p>


<h3>PiT's met een geometrie</h3>

<table class="table table-striped sortable">
	<thead>
		<tr>
			<th style="width:20%;">naam</th>
			<th style="width:12%;">begin</th>
			<th style="width:12%;">eind</th>
			<th>PiT</th>
			<th style="width:20%;">bron</th>
		</tr>
	</thead>
	<tbody>
	<? foreach ($pits as $pit) { ?>
		<? if($pit['geometryIndex']>-1){

			$validSince = "";
			if(isset($pit['validSince'])){
				if(is_array($pit['validSince'])){
					$pit['validSince'] = implode(", ", $pit['validSince']);
				}
				$validSince = $pit['validSince'];
			}
			$validUntil = "";
			if(isset($pit['validUntil'])){
				if(is_array($pit['validUntil'])){
					$pit['validUntil'] = implode(", ", $pit['validUntil']);
				}
				$validUntil = $pit['validUntil'];
			}


			 ?>
			<tr class="pit">
				<td><?= $pit['name'] ?></td>
				<td><?= $validSince ?></td>
				<td><?= $validUntil ?></td>
				<td><a href="<?= $this->config->item('base_url') ?>pit/?id=<?= $pit['id'] ?>"><?= $pit['id'] ?></a></td>
				<td><a href="<?= $this->config->item('base_url') ?>bron/<?= $pit['dataset'] ?>"><?= $pit['dataset'] ?></a></td>
			</tr>
		<? } ?>
	<? } ?>
	</tbody>
</table>



<h3>PiT's zonder geometrie</h3>

<table class="table table-striped sortable">
	<thead>
		<tr>
			<th style="width:20%;">naam</th>
			<th style="width:12%;">begin</th>
			<th style="width:12%;">eind</th>
			<th>PiT</th>
			<th style="width:20%;">bron</th>
		</tr>
	</thead>
	<tbody>
	<? foreach ($pits as $pit) { ?>
		<? if($pit['geometryIndex']<0){

			$validSince = "";
			if(isset($pit['validSince'])){
				if(is_array($pit['validSince'])){
					$pit['validSince'] = implode(", ", $pit['validSince']);
				}
				$validSince = $pit['validSince'];
			}
			$validUntil = "";
			if(isset($pit['validUntil'])){
				if(is_array($pit['validUntil'])){
					$pit['validUntil'] = implode(", ", $pit['validUntil']);
				}
				$validUntil = $pit['validUntil'];
			}


			 ?>
			<tr class="pit">
				<td><?= $pit['name'] ?></td>
				<td><?= $validSince ?></td>
				<td><?= $validUntil ?></td>
				<td><a href="<?= $this->config->item('base_url') ?>pit/?id=<?= $pit['id'] ?>"><?= $pit['id'] ?></a></td>
				<td><a href="<?= $this->config->item('base_url') ?>bron/<?= $pit['dataset'] ?>"><?= $pit['dataset'] ?></a></td>
			</tr>
		<? } ?>
	<? } ?>
	</tbody>
</table>

