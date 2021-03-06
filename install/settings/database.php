<?php

/* settings/database.php */

return array(
    'mysql' => array(
        'dbdriver' => 'mysql',
        'username' => 'root',
        'password' => '',
        'dbname' => 'eoffice',
        'prefix' => 'eoffice',
    ),
    'tables' => array(
        'category' => 'category',
        'edocument' => 'edocument',
        'edocument_download' => 'edocument_download',
        'inventory' => 'inventory',
        'inventory_meta' => 'inventory_meta',
        'inventory_user' => 'inventory_user',
        'language' => 'language',
        'line' => 'line',
        'repair' => 'repair',
        'repair_status' => 'repair_status',
        'reservation' => 'reservation',
        'reservation_data' => 'reservation_data',
        'rooms' => 'rooms',
        'rooms_meta' => 'rooms_meta',
        'user' => 'user',
        'user_category' => 'user_category',
    ),
);
