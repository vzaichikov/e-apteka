<?php
  
  define('SOCONFIG_VERSION', '1.0.2');
  define('SOCONFIG_CACHE_DIR', 'soconfig/data/cache/');
  
  require_once(DIR_SYSTEM . 'soconfig/classes/soconfig.php');
  $soconfig = new Soconfig($this->registry);
  $this->registry->set('soconfig', $soconfig);
  
  require_once(DIR_SYSTEM . 'soconfig/classes/soconfig_settings.php');
  $soconfig->config = new SoconfigSettings($this->registry);
  
  require_once(DIR_SYSTEM . 'soconfig/classes/soconfig_cache.php');
  $soconfig->cache = new SoconfigCache($this->registry);
  
  require_once(DIR_SYSTEM . 'soconfig/classes/soconfig_tools.php');
  $soconfig->tools = new SoconfigTools($this->registry);
  
  require_once(DIR_SYSTEM . 'soconfig/classes/soconfig_minifier.php');
  $soconfig->minifier = new SoconfigMinifier();
  
  
    
  
  
