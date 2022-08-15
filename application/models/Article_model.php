<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Article_model extends CI_Model {
    
    public function __construct() {
        $this->table = 'articles';
        $this->table_id = 'id';
        parent::__construct();
    }
    
    public function exists_article($id) {
        $exists = FALSE;
        $sql = "SELECT * FROM $this->table 
            WHERE $this->table_id = ?
            ORDER BY $this->table_id ASC";
        $query = $this->db->query($sql, [$id]);
        if($query->num_rows() > 0) {
            $exists = TRUE;
        }
        return $exists;
    }
    
    public function get_articles() {
        $sql = "SELECT * FROM $this->table 
            ORDER BY $this->table_id ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function get_article($id) {
        $sql = "SELECT * FROM $this->table 
            WHERE $this->table_id = ?
            ORDER BY $this->table_id ASC";
        $query = $this->db->query($sql, [$id]);
        return $query->row();
    }
    
    public function save_article($data) {
        $result = ['status' => FALSE, 'id' => 0];
        $this->db->trans_begin();
        $this->db->insert($this->table, $data);
        $id = $this->db->insert_id();
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return $result;
        }else {
            $this->db->trans_commit();
            $result['status'] = TRUE;
            $result['id'] = $id;
            return $result;
        }
    }
    
    public function update_article($id, $data) {
        $this->db->trans_begin();
        $this->db->where($this->table_id, $id);
        $this->db->update($this->table, $data);
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function delete_article($id) {
        $this->db->trans_begin();
        $this->db->where($this->table_id, $id);
        $this->db->delete($this->table);
        if($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        }else {
            $this->db->trans_commit();
            return TRUE;
        }
    }
}
