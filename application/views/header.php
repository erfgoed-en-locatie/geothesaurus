<!DOCTYPE HTML>
<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Erfgeo</title>

<link href="<?= $this->config->item('base_url') ?>assets/css/bootstrap.min.css" rel="stylesheet" media="all">
<link href="<?= $this->config->item('base_url') ?>assets/css/style.css" rel="stylesheet" media="all" />

<script src="<?= $this->config->item('base_url') ?>assets/js/jquery-1.11.0.min.js"></script>

<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>

</head>

<body>

<div id="headerbg">
<div id="header" class="container">
    <div id="usernav">
        <form action="<?= $this->config->item('base_url') ?>">
        <input style="width:200px;" value="" type="text" class="floatinput form-control" name="q" /> <button class="btn btn-primary">zoek</button>
		</form>
    </div>

    <h1><a href="<?= $this->config->item('base_url') ?>">GeoThesaurus</a></h1>
    
</div>
</div>



<div id="wrap">
    <div id="main" class="container">
 	