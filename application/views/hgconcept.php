<?


?>


<h1><?= preferredName($pits) ?></h1>

<p>Dit concept van het type <em><?= $pits[0]['type'] ?></em> is samengesteld uit de volgende 'Plaatsen in Tijd' (PiT's)</p>


<h3>PiT's met een geometrie</h3>

<table class="table table-striped">
<tr>
<th style="width:25%;">naam</th>
<th style="width:20%;">datering</th>
<th>PiT</th>
<th style="width:20%;">bron</th>
</tr>
<? foreach ($pits as $pit) { ?>
	<? if($pit['geometryIndex']>-1){

		$datering = "";
		if(isset($pit['hasBeginning'])){
			$datering = date("Y",strtotime($pit['hasBeginning']));
		}

		 ?>
		<tr class="pit">
			<td><?= $pit['name'] ?></td>
			<td><?= $datering ?></td>
			<td><a href="<?= $this->config->item('base_url') ?>pit/<?= $pit['hgid'] ?>"><?= $pit['hgid'] ?></a></td>
			<td><a href="<?= $this->config->item('base_url') ?>bron/<?= $pit['source'] ?>"><?= $pit['source'] ?></a></td>
		</tr>
	<? } ?>
<? } ?>
</table>



<h3>PiT's zonder geometrie</h3>

<table class="table table-striped">
<tr>
<th style="width:25%;">naam</th>
<th style="width:20%;">datering</th>
<th>PiT</th>
<th style="width:20%;">bron</th>
</tr>
<? foreach ($pits as $pit) { ?>
	<? if($pit['geometryIndex']<0){

		$datering = "";
		if(isset($pit['hasBeginning'])){
			$datering = date("Y",strtotime($pit['hasBeginning']));
		}
		if(isset($pit['hasEnd'])){
			$datering .= ' - ' . date("Y",strtotime($pit['hasEnd']));
		}

		 ?>
		<tr class="pit">
			<td><?= $pit['name'] ?></td>
			<td><?= $datering ?></td>
			<td><a href="<?= $this->config->item('base_url') ?>pit/<?= $pit['hgid'] ?>"><?= $pit['hgid'] ?></a></td>
			<td><a href="<?= $this->config->item('base_url') ?>bron/<?= $pit['source'] ?>"><?= $pit['source'] ?></a></td>
		</tr>
	<? } ?>
<? } ?>
</table>

