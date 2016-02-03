<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @copyright	Tim Gatzky 2015
 * @author		Tim Gatzky <info@tim-gatzky.de>
 * @package		pct_customelements
 * @subpackage	pct_customelements_plugin_customcatalog
 * @subpackage	pct_customelements_plugin_cc_frontedit
 * @link		http://contao.org
 */

/**
 * Constants
 */ 
define(PCT_CUSTOMELEMENTS_PLUGIN_CC_FRONTEDIT_PATH,'system/modules/pct_customelements_plugin_cc_frontedit');
define(PCT_CUSTOMELEMENTS_PLUGIN_CC_FRONTEDIT_VERSION,'1.0.0-beta');

/**
 * Globals
 */
$GLOBALS['PCT_CUSTOMCATALOG_FRONTEDIT']['multipleOperations'] 						= array('fe_editAll','fe_overrideAll');
$GLOBALS['PCT_CUSTOMCATALOG_FRONTEDIT']['ignoreButtons']							= array('show'); // operations to be ignored
$GLOBALS['PCT_CUSTOMCATALOG_FRONTEDIT']['methodsRequireBackendLogin'] 				= array('openModalWindow','openModalBrowser');
$GLOBALS['PCT_CUSTOMCATALOG_FRONTEDIT']['SETTINGS']['allowAll'] 					= false; // if set to true, editing is allowed without being logged on to the front end
$GLOBALS['PCT_CUSTOMCATALOG_FRONTEDIT']['SETTINGS']['showWidgetsOnlyInEditModes'] 	= true;
$GLOBALS['PCT_CUSTOMCATALOG_FRONTEDIT']['sessionName']								= 'CC_FRONTEDIT';

/**
 * Register plugin
 */
$GLOBALS['PCT_CUSTOMELEMENTS']['PLUGINS']['cc_frontedit'] = array
(
	'tables' 	=> array('tl_pct_customelement','tl_pct_customelement_group','tl_pct_customelement_attribute'),
	'requires'	=> array('pct_customelements'=>'1.6.0'),
);


/**
 * Check if plugin is active
 */
$blnInitialize = true;
if( TL_MODE == 'BE' && count(\Session::getInstance()->getData()) > 0 )
{
	if(!in_array('cc_frontedit',\PCT\CustomElements\Core\PluginFactory::getActivePlugins()) && !in_array(\Input::get('do'), array('repository_manager','composer')) )
	{
		$blnInitialize = false;
	}
}

if($blnInitialize)
{
	/**
	 * Front end modules
	 */
	// new customcataloglist class
	$GLOBALS['FE_MOD']['pct_customcatalog_node']['customcataloglist'] 		= 'PCT\CustomElements\Plugins\FrontEdit\Frontend\ModuleList';
	// new customcatalogreader class
	$GLOBALS['FE_MOD']['pct_customcatalog_node']['customcatalogreader'] 	= 'PCT\CustomElements\Plugins\FrontEdit\Frontend\ModuleReader';
}


/**
 * Hooks
 */
if($blnInitialize)
{
	$GLOBALS['CUSTOMCATALOG_HOOKS']['getEntries'][] 		= array('PCT\CustomCatalog\FrontEdit\TemplateAttribute','__override');
	$GLOBALS['CUSTOMCATALOG_HOOKS']['getEntries'][] 		= array('PCT\CustomCatalog\FrontEdit\RowTemplate','__override');
	$GLOBALS['CUSTOMCATALOG_HOOKS']['prepareCatalog'][] 	= array('PCT\CustomCatalog\FrontEdit\Callbacks','bypassPublishedSettings');
	$GLOBALS['CUSTOMCATALOG_HOOKS']['prepareCatalog'][] 	= array('PCT\CustomCatalog\FrontEdit\Callbacks','showSelectedEntriesOnly');
	$GLOBALS['TL_HOOKS']['generatePage'][] 					= array('PCT\CustomCatalog\FrontEdit\Controller','applyOperationsOnGeneratePage');
	$GLOBALS['TL_HOOKS']['generatePage'][] 					= array('PCT\CustomCatalog\FrontEdit\Callbacks','ajaxListener');	
#	$GLOBALS['TL_HOOKS']['initializeSystem'][] 				= array('PCT\CustomCatalog\FrontEdit','hasBackendSession');
	$GLOBALS['TL_HOOKS']['initializeSystem'][] 				= array('PCT\CustomCatalog\FrontEdit\Controller','simulateSwitchToEdit');
	
}