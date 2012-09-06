<?php
	if(isset($_POST['title'], $_POST['description'], $_POST['gplus_id'], $_POST['api_key'], $_POST['max_age'], $_POST['max_post']) && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['gplus_id']) && !empty($_POST['api_key']) && !empty($_POST['max_age']) && !empty($_POST['max_post']) && $_POST['max_post'] > 0 && $_POST['max_post'] < 101 && $_POST['max_age'] > -1){
		file_put_contents('config.php','<?php
    $config[\'title\'] = \'' . $_POST['title'] . '\'; // Un titre pour votre flux
    $config[\'description\'] = \'' . $_POST['description'] . '\'; // Une description de ce que vous aimez bien poster sur Google+
    $config[\'gplus_id\'] = \'' . $_POST['gplus_id'] . '\'; // Votre identifiant Google+. Il est contenu dans l\'URL de votre profil (ex: https://plus.google.com/0123456789/posts -> 0123456789)
    $config[\'api_key\'] = \'' . $_POST['api_key'] . '\'; // Votre clé d\'API. Voir https://code.google.com/apis/console/
    $config[\'max_age\'] = ' . $_POST['max_age'] . '; // L\'âge maximal du cache (en seconde). Sachez que vous êtes limité à 10 000 requêtes par jour
    $config[\'max_post\'] = ' . $_POST['max_post'] . '; // Le nombre de post à récupérer. Doit se situer dans l\'intervale [1;100].
?>');
		header('Location: install.php?ok');
	}
	else{
		$msg = null;
		if(isset($_GET['ok'])) $msg = '<div id="ok">Rocket Cat a été installé avec succès! Supprimez install.php pour continuer</div><style>strong,h1,form{display:none}</style>';
		elseif(file_exists('config.php')) $msg = '<strong>Attention: config.php existe déjà! Impossible de continuer</strong><style>h1,form{display:none}</style>';
		echo '<!DOCTYPE html><html><head><title>Installation de Rocket-Cat</title><meta charset="utf-8"><style>body{background:#f5f5f5;font-family:sans-serif;font-size:small}section{width:500px;margin:0 auto}form{background:#fefefe;border:1px solid #ddd;line-height:20px;text-align:justify;padding:10px 25px}label{display:block;width:220px;float:left}input{display:block;width:220px;float:right}input[type=submit]{cursor:pointer}strong{font-size:11px;background:#D85656;border:1px solid #962424;display:block;margin-bottom:5px;color:#fafafa;padding:5px 10px}#ok{font-weight:bold;font-size:11px;background:#B9D15C;border:1px solid #689323;margin-bottom:5px;color:#111;padding:5px 10px}h1{font-size:18px}</style></head><body><section>' . $msg . '<strong>Ce script doit pouvoir écrire dans le répertoire courant</strong><strong>Pensez à supprimer install.php après avoir effectué l\'installation</strong><h1>Installation</h1><form method="post" action="install.php"><label>Titre du flux:</label><input name="title" required=""><br><br><label>Description du flux:</label><input name="description" required=""><br><br><label>Votre ID Google+:</label><input name="gplus_id" required=""><br><br><label>Votre <a href="https://code.google.com/apis/console/" target="_blank">clé d\'API</a> Google+:</label><input name="api_key" required=""><br><br><label>L\'âge maximal du cache (sec):</label><input type="number" name="max_age" value="60" required=""><br><br><label>Le nombre de post à récupérer:</label><input type="number" name="max_post" value="50" min="1" max="100" required=""><br><br><input type="submit" value="Installer"><div style="clear: both"></div></form></section></body></html>';
	}
?>