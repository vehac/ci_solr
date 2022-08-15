<?php  defined('BASEPATH') OR exit('No direct script access allowed');

$config['ci_solr'] = array(
    'endpoint' => array(
        'gettingstarted' => array(
            'scheme' => 'http', # or https
            'host' => '14.25.22.20',
            'port' => 8983,
            'path' => '/',
            // 'context' => 'solr', # only necessary to set if not the default 'solr'
            'core' => 'gettingstarted'
        ),
        'articles' => array(
            'scheme' => 'http', # or https
            'host' => '14.25.22.20',
            'port' => 8983,
            'path' => '/',
            // 'context' => 'solr', # only necessary to set if not the default 'solr'
            'core' => 'articles'
        )
    )
);