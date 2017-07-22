<?php
$sMetadataVersion = '1.1';
$aModule = array(
    'id'          => 'pl_delpic',
    'title'       => 'AUXILIARY TOOLS / Check Images',
    'description' => array(
        'en' => 'delpic',
        'de' => 'delpic'
    ),
    'thumbnail' => 'picture.png',
    'version' => '2.0',
    'author' => 'jonas.hess@revier.de, Foxido.de',
    'url' => 'https://github.com/re4jh/oxidimagecheck',
    'email' => 'jonas.hess@revier.de;info@foxido.de',
    'extend' => array(),
    'files' => array(
        'delpic' => 'imagecheck/application/controllers/admin/delpic.php',
    ),
    'blocks' => array(),
    'templates' => array(
        'delpic.tpl' => 'imagecheck/application/views/admin/tpl/delpic.tpl'
    )

);
