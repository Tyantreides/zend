<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */



if (isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == '127.0.0.1') {
    return array(
        'db' => array(
            'driver'         => 'Pdo',
            'dsn'            => 'mysql:dbname=db1705936;host=localhost',
            'adapters' => array(
                'smfdb' => array(
                    'driver'         => 'Pdo',
                    'dsn'            => 'mysql:dbname=db1705936;host=localhost',
                ),
            ),
        ),
        'service_manager' => array(
            'factories' => array(
                'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            ),
            'abstract_factories' => array(
                'Zend\Db\Adapter\AdapterAbstractServiceFactory',
            ),
        ),
    );
}
else {
    return array(
        'db' => array(
            'driver'         => 'Pdo',
            'dsn'            => 'mysql:dbname=DB1705936;host=rdbms.strato.de',
            'adapters' => array(
                'smfdb' => array(
                    'driver'         => 'Pdo',
                    'dsn'            => 'mysql:dbname=DB1714366;host=rdbms.strato.de',
                ),
            ),
        ),

        'service_manager' => array(
            'factories' => array(
                'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
            ),
            'abstract_factories' => array(
                'Zend\Db\Adapter\AdapterAbstractServiceFactory',
            ),
        ),
    );
}