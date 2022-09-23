<?php

function isRange($string) {
  return preg_match('/^(-|)(\d+\.)?\d+?\-(-|)(\d+\.)?\d+?$/', $string);
}

function getRangeParts($string) {
  preg_match('/^((-|)(\d+\.)?\d+?)\-((-|)(\d+\.)?\d+?)$/', $string, $output);

  if (isset($output[1]) && isset($output[4])) {
  	return array(
      'from' => $output[1],
      'to' => $output[4]
    );
  }
}

function isID($string) {
  return preg_match('/^[0-9]+?$/', $string);
}

function declOfNum($number, $cases) {

  if ($number % 10 == 1 && $number % 100 != 11) {
    $key = 0;
  } elseif ($number % 10 >= 2 && $number % 10 <= 4 && ($number % 100 < 10 || $number % 100 >= 20)) {
    $key = 1;
  } else {
    $key = 2;
  }

  return sprintf($cases[$key], $number);
}

function cleanParamsString($params, $config) {
  $matches = array();

  if ($params) {
    foreach (explode($config->get('ocfilter_part_separator'), (string)$params) as $part) {
      $option = explode($config->get('ocfilter_option_separator'), $part);

      $values = array();

      if (isset($option[1])) {
        // If slider
        if (isRange($option[1])) {
          $range = getRangeParts($option[1]);

          if (isset($range['from']) && isset($range['to'])) {
            $matches[] = $option[0] . $config->get('ocfilter_option_separator') . (float)$range['from'] . '-' . (float)$range['to'];
          }
        } elseif ($option[0] == 'm' || ($option[0] == 's' && $config->get('ocfilter_stock_status_method') == 'stock_status_id')) {
          foreach (explode($config->get('ocfilter_option_value_separator'), $option[1]) as $value_id) {
            $values[] = (int)$value_id;
          }

          if ($values) {
            $matches[] = $option[0] . $config->get('ocfilter_option_separator') . implode($config->get('ocfilter_option_value_separator'), $values);
          }
        } elseif ($option[0] == 's' && $config->get('ocfilter_stock_status_method') == 'quantity') {
					if ($option[1] == 'in' || $option[1] == 'out') {
						$matches[] = 's' . $config->get('ocfilter_option_separator') . $option[1];
					}
        } elseif (isID($option[0])) {
          foreach (explode($config->get('ocfilter_option_value_separator'), $option[1]) as $value_id) {
            $values[] = (string)$value_id;
          }

          if ($values) {
            $matches[] = (int)$option[0] . $config->get('ocfilter_option_separator') . implode($config->get('ocfilter_option_value_separator'), $values);
          }
        }
      }
    }
  }

  return implode($config->get('ocfilter_part_separator'), $matches);
}

// From params string to array
function decodeParamsFromString($params, $config) {
	$decode = array();

  if ($params = cleanParamsString($params, $config)) {
    foreach (explode($config->get('ocfilter_part_separator'), $params) as $part) {
      $option = explode($config->get('ocfilter_option_separator'), $part);

      $values = explode($config->get('ocfilter_option_value_separator'), $option[1]);

      sort($values);

      $decode[$option[0]] = $values;
    }
  }

  ksort($decode);

  return $decode;
}

// From params array to string
function encodeParamsToString($params, $config) {
	$encode = array();

  if ($params) {
    ksort($params);

    foreach ($params as $option_id => $values) {
      sort($values);

      if ($values) $encode[] = $option_id . $config->get('ocfilter_option_separator') . implode($config->get('ocfilter_option_value_separator'), $values);
    }
  }

  return cleanParamsString(implode($config->get('ocfilter_part_separator'), $encode), $config);
}
?>