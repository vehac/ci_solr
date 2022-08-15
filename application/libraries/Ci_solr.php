<?php  defined('BASEPATH') OR exit('No direct script access allowed');

use Solarium\Core\Client\Adapter\Curl;
use Symfony\Component\EventDispatcher\EventDispatcher;

class Ci_solr {
    
    private $adapter;
    private $eventDispatcher;
    private $config;
    
    private $client;

    public function __construct($config = array()) {
        $this->CI =& get_instance();
        
        $config_global = (!empty($config)) ? $config : array();
        try {
            $this->initialize($config_global);
            $this->adapter = new Curl();
            $this->eventDispatcher = new EventDispatcher();
            $this->client = new Solarium\Client($this->adapter, $this->eventDispatcher, $this->config);
        }catch(Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
    
    public function initialize($config = array()) {
        if(empty($config)) {
            throw new \Exception("Config para solr no existe.");
        }
        $this->config = $config['ci_solr'];
    }
    
    public function get_info($core) {
        $response = [
            'version' => Solarium\Client::VERSION
        ];
        $this->client->setDefaultEndPoint($core);
        $ping = $this->client->createPing();
        try {
            $result = $this->client->ping($ping);
            $response['data'] = $result->getData();
        }catch(\Exception $e) {
            echo $e->getMessage();
        }
        return $response;
    }

    public function exists_core($core) {
        $status = FALSE;
        try {
            if($core) {
                $this->client->setDefaultEndPoint($core);
                $ping = $this->client->createPing();
                $response = $this->client->ping($ping);
                if(isset($response->getData()["status"]) && $response->getData()["status"] == "OK") {
                    $status = TRUE;
                }
            }
        }catch(\Exception $e) {}
        return $status;
    }
    
    public function create_document($core, $body) {
        $this->client->setDefaultEndPoint($core);
        $update = $this->client->createUpdate();
        $doc = $update->createDocument();
        foreach ($body as $key => $value) {
            $doc->$key = $value;
        }
        $update->addDocument($doc);
        $update->addCommit();
        $response = $this->client->update($update);
        return $response->getStatus();
    }
    
    public function update_all_document($core, $id, $body) {
        $this->client->setDefaultEndPoint($core);
        $update = $this->client->createUpdate();
        $doc = $update->createDocument();
        $doc->id = $id;
        foreach ($body as $key => $value) {
            $doc->$key = $value;
        }
        $update->addDocument($doc);
        $update->addCommit();
        $response = $this->client->update($update);
        return $response->getStatus();
    }
    
    public function update_document($core, $id, $body) {
        $this->client->setDefaultEndPoint($core);
        $update = $this->client->createUpdate();
        $doc = $update->createDocument();
        $doc->setKey('id', $id);
        foreach ($body as $key => $value) {
            $doc->setField($key, $value);
            $doc->setFieldModifier($key, $doc::MODIFIER_SET);
        }
        $update->addDocument($doc);
        $update->addCommit();
        $response = $this->client->update($update);
        return $response->getStatus();
    }
    
    public function delete_document($core, $id) {
        $this->client->setDefaultEndPoint($core);
        $update = $this->client->createUpdate();
        $update->addDeleteById($id);
        $update->addCommit();
        $response = $this->client->update($update);
        return $response->getStatus();
    }
    
    public function delete_query_document($core, $key, $value) {
        $this->client->setDefaultEndPoint($core);
        $update = $this->client->createUpdate();
        $update->addDeleteQuery($key.':"'.$value.'"');
        $update->addCommit();
        $response = $this->client->update($update);
        return $response->getStatus();
    }
    
    public function search_document($core, $page, $num_results, $query_search) {
        try {
            $this->client->setDefaultEndPoint($core);
            if(isset($query_search['query']) && $query_search['query'] != "" && $query_search['query'] != NULL) {
                $query = $this->client->createSelect();
                $query->setQuery('description:\"'.$query_search['query'].'\" OR title:\"'.$query_search['query'].'\"');
                $resultsPerPage = $num_results;
                $currentPage = $page;
                $query->setRows($resultsPerPage);
                $query->setStart(($currentPage - 1) * $resultsPerPage);
                $query->setFields(array('id','title','description', 'created_at'));
                $query->addSort('id', $query::SORT_ASC);
                $response = $this->client->select($query);
            }else {
                $query = $this->client->createQuery($this->client::QUERY_SELECT);
                $resultsPerPage = $num_results;
                $currentPage = $page;
                $query->setRows($resultsPerPage);
                $query->setStart(($currentPage - 1) * $resultsPerPage);
                $response = $this->client->execute($query);
            }
        }catch(\Exception $e) {
            $response = [];
            echo $e->getMessage();
        }
        return $response;
    }
    
    public function count_documents($core, $query_search) {
        try {
            $this->client->setDefaultEndPoint($core);
            if(isset($query_search['query']) && $query_search['query'] != "" && $query_search['query'] != NULL) {
                $query = $this->client->createSelect();
                $query->setQuery('description:\"'.$query_search['query'].'\" OR title:\"'.$query_search['query'].'\"');
                $resultset = $this->client->select($query);
                $response = $resultset->getNumFound();
            }else {
                $query = $this->client->createQuery($this->client::QUERY_SELECT);
                $resultset = $this->client->execute($query);
                $response = $resultset->getNumFound();
            }
        }catch(\Exception $e) {
            $response = 0;
            echo $e->getMessage();
        }
        return $response;
    }
}
