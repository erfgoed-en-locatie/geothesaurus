# geothesaurus

De GeoThesaurus laat je door de Histograph data bladeren, waarbij elk hgconcept, elke pit en elke bron haar eigen URI heeft.

Wijzig na installatie in [application/config/config.php](application/config/config.php) de variabele `$config['base_url']` in de webroot van je applicatie.

##hgConceptId

De niet weinig complexe vraag hoe id's (en daarmee URI's) te creëren voor hgconcepten is in deze versie opgelost door een lijstje preferred sources aan te maken en het PiTid van de eerste bron te gebruiken die je tegenkomt. Het lijstje preferred sources is te vinden in [application/helpers/erfgeo_helper.php](application/helpers/erfgeo_helper.php)

##features

- Je wil naar concept linken maar je beschikt alleen over een pitid? Link naar `http://geothesaurus.nl/hgconcept/frompit/bronid/itemid`, bijv. [http://geothesaurus.nl/hgconcept/frompit/ilvb/115](http://geothesaurus.nl/hgconcept/frompit/ilvb/115)
