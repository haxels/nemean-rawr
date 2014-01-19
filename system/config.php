<?php

    /**
     * !!!!!!!!!!!!!!!!!!!
     * DO NOT COMMIT!!!!!!
     * !!!!!!!!!!!!!!!!!!!
     */

    /**
     * Config file
     */

    /**
     * Database parameters
     */
    if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1')
    {
        define('DBHOST', 'localhost');
        define('DBUSER', 'root');
        define('DBPASS', '');
        define('DBNAME', 'nemean');
    }else
     {
        define('DBHOST', 'server.nemean.no');
        define('DBUSER', 'zebra');
        define('DBPASS', 'nemean12toft');
        define('DBNAME', 'nemean');
     }
/**
     * !!!!!!!!!!!!!!!!!!!
     * DO NOT COMMIT!!!!!!
     * !!!!!!!!!!!!!!!!!!!
     */
?>