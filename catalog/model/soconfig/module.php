<?php
/**
 * @author Nick M. <webdev.nick@gmail.com>
 * @package welldone_opencart 
 */
 
class ModelSoconfigModule extends Model {
  public function getModule($module_id) 
  {
    $query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'welldone_modules WHERE id = ' . (int)$module_id);
    if (isset($query->row['module_data'])) 
    {
        $query->row['module_data'] = unserialize($query->row['module_data']);
    }
    return $query->row;
  }
  
  public function getModuleName($module_id)
  {
    $query = $this->db->query('SELECT * FROM ' . DB_PREFIX . 'welldone_modules WHERE id = ' . (int)$module_id);
    if (isset($query->row['id'])) 
    {
        return $query->row['module_type']; 
    }
    return '';
  }
  
  public function getModulesByType($module_type)
  {
    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "welldone_modules WHERE module_type = '".$this->db->escape($module_type)."' order by id asc");
    if (count($query->rows)) 
    {
      $modules = array();
      foreach($query->rows as $row)
      {
        $modules[] = unserialize($row['module_data']);
      }
     return $modules; 
    }
    return array();
  }
    
}