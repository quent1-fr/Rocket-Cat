<?php
    $config['title'] = ''; // Un titre pour votre flux
    $config['description'] = ''; // Une description de ce que vous aimez bien poster sur Google+
    $config['gplus_id'] = ''; // Votre identifiant Google+. Il est contenu dans l'URL de votre profil (ex: https://plus.google.com/0123456789/posts -> 0123456789)
    $config['api_key'] = ''; // Votre clé d'API. Voir https://code.google.com/apis/console/
    $config['max_age'] = 60; // L'âge maximal du cache (en seconde). Sachez que vous êtes limité à 10 000 requêtes par jour
    $config['max_post'] = 50; // Le nombre de post à récupérer. Doit se situer dans l'intervale [1;100].
?>