<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Geothesaurus</title>

<link href="<?= $this->config->item('base_url') ?>assets/css/bootstrap.min.css" rel="stylesheet" media="all">

<script src="<?= $this->config->item('base_url') ?>assets/js/codemirror-5.2/lib/codemirror.js"></script>
<link rel="stylesheet" href="<?= $this->config->item('base_url') ?>assets/js/codemirror-5.2/lib/codemirror.css">
<script src="<?= $this->config->item('base_url') ?>assets/js/codemirror-5.2/mode/javascript/javascript.js"></script>


<link href="<?= $this->config->item('base_url') ?>assets/css/style.css" rel="stylesheet" media="all" />

<script src="<?= $this->config->item('base_url') ?>assets/js/jquery-1.11.0.min.js"></script>


<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>

<script src="<?= $this->config->item('base_url') ?>assets/js/sorttables.js"></script>
</head>

<body>

<div id="headerbg">
	<div id="header" class="container">
		<div id="mainmenu">
			<a href="http://erfgeo.nl/thesaurus/">Thesaurus</a> <span class="delimiter"></span>
			<a href="http://erfgeo.nl/nieuws/">Blog</a><span class="delimiter"></span>
			<a href="http://erfgeo.nl/wat-hoe/">Wat? Hoe?</a><span class="delimiter"></span>
			<a href="http://erfgeo.nl/tools/">Tools</a>
		</div>
	    <h1><a href="http://erfgeo.nl/"><span>Erf</span>Geo</a></h1>
	</div>
</div>




<div id="wrap">
    <div id="main" class="container">

		<div id="search">
			<? if($this->router->fetch_method() != "index" || $this->router->fetch_class() != "start"){ ?>
		    <form action="<?= $this->config->item('base_url') ?>" onsubmit="toViewer(); return false;">
		    <input style="width:200px;" value="" type="text" class="floatinput form-control" name="q" id="q" /> <button class="btn btn-primary">zoek</button>
			</form>

			<script type="text/javascript">

				function toViewer(){
					window.location.href = 'http://erfgeo.nl/thesaurus/#search=' + $('#q').val();
				}

			</script>
			<? } ?>
		</div>
 	