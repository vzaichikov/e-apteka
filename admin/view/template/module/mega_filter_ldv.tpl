<?php

	if( $type == 'base_attribs' ) {
		$_baseName		= $name;
		$_baseValues	= $base_attribs;

		require DIR_TEMPLATE . 'module/' . $_name . '-base-attribs.tpl';
	} else if( $type == 'attribs' ) {
		$_attribsName	= $name;
		$_attribsValues	= $attribs;

		require DIR_TEMPLATE . 'module/' . $_name . '-attribs.tpl';
	} else if( $type == 'options' ) {
		$_optionsName	= $name;
		$_optionsValues	= $options;

		require DIR_TEMPLATE . 'module/' . $_name . '-options.tpl';
	} else if( $type == 'filters' ) {
		$_filtersName	= $name;
		$_filtersValues	= $filters;

		require DIR_TEMPLATE . 'module/' . $_name . '-filters.tpl';
	} else if( $type == 'configuration' ) {
		$_configurationName = $name;
		$_configurationValues = $configuration;
		
		require DIR_TEMPLATE . 'module/' . $_name . '-configuration.tpl';
	} else if( $type == 'vehicles' ) {
		$_configurationName = $name;
		$_configurationValues = $vehicles;
		
		require DIR_TEMPLATE . 'module/mfilter_vehicle/ldv.tpl';
	} else if( $type == 'levels' ) {
		$_configurationName = $name;
		$_configurationValues = $levels;
		
		require DIR_TEMPLATE . 'module/mfilter_level/ldv.tpl';
	}

?>