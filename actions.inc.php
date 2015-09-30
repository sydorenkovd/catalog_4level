<?php
switch($_POST['action']){
	case 'order':
		$titles = $_POST['order'];
		foreach($titles as $title){
			$dvd = new DVD($title);
			$dvd->buy();
		}
		break;
	case 'anthology':
		$band = trim(strip_tags($_POST['band']));
		$type = (int)($_POST['bonus']) ? 'bonus' : '';
		$tracks = array_map(function($val){return (int)$val;}, $_POST['order']);
		// $dvd = new DVD();
		$dvd = DVDFactory::create($type);
		$dvd->setBand($band);
		foreach ($tracks as $track) {
			$dvd->addTrack($track);
		}
		break;
	case 'list':
		$id = abs((int)$_POST['id']);
		$type = (int)$_POST['format'];
		$band = trim(strip_tags($_POST['band']));
		$title = trim(strip_tags($_POST['title']));
		// $dvd = new DVD();
		$dvd = new DVDStrategy();
		if($type)
			$dvd->setStrategy(new DVDAsJSON($id));
		else
			$dvd->setStrategy(new DVDAsXML($id));
		$dvd->setTitle($title);
		$dvd->setBand($band);
		// $dvd->getXML($id);
		$dvd->get();
		break;
}
header('Location: catalog.php');
exit;
?>