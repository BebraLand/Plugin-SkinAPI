<?php

return [
    'not_found' => [
        'name' => 'Gestion des skins non trouvés',
        'default_skin' => 'Retourner le skin par défaut',
        '404' => 'Retourner une erreur HTTP 404 (Not Found)',
    ],

    'skins' => 'Skins',
    'capes' => 'Capes',

    'enable_default_cape' => 'Afficher une cape par defaut aux utilisateurs qui n\'ont pas choisi de cape',
    'default_cape_requirements' => 'Image PNG. Les dimensions de la cape par defaut ne sont pas limitees par celles des joueurs.',

    'enable_capes' => 'Activer les capes (les utilisateurs doivent avoir un rôle avec la permission des capes)',

    'fields' => [
        'default_cape' => 'Cape par defaut',
        'width' => 'Largeur',
        'height' => 'Hauteur',
        'scale' => 'Échelle maximum',
        'default' => 'Skin par défaut',
    ],

    'api' => [
        'title' => 'Informations',
        'info' => 'La documentation de l\'API est disponible ci-dessous.',
    ],

    'permissions' => [
        'skin' => 'Ajouter un skin',
        'cape' => 'Ajouter une cape',
        'hd_cape' => 'Ajouter des capes haute resolution (jusqu a 1024 x 512 px)',
        'manage' => 'Gérer les paramètres des skins et capes',
    ],
];
