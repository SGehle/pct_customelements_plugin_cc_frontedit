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
 * Table tl_module
 */
$objDcaHelper = \PCT\CustomElements\Plugins\CustomCatalog\Helper\DcaHelper::getInstance()->setTable('tl_module');

/**
 * Config
 */
#$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = array('PCT\CustomElements\Plugins\CustomCatalog\Backend\TableModule', 'modifyDca');


/**
 * Palettes
 */
// customcataloglist
$arrPalettes = $objDcaHelper->getPalettesAsArray('customcataloglist');
$arrPalettes['frontedit_legend:hide'][] = 'customcatalog_edit_showUnpublished';
$GLOBALS['TL_DCA']['tl_module']['palettes']['customcataloglist'] = $objDcaHelper->generatePalettes($arrPalettes);
// customcatalogreader
$arrPalettes = $objDcaHelper->getPalettesAsArray('customcatalogreader');
#$GLOBALS['TL_DCA']['tl_module']['palettes']['customcatalogfrontedit'] = $objDcaHelper->generatePalettes($arrPalettes);

/**
 * Fields
 */
$objDcaHelper->addFields(array
(
	'customcatalog_edit_showUnpublished' => array
	(
		'label'           		=> &$GLOBALS['TL_LANG'][$objDcaHelper->getTable()]['customcatalog_edit_showUnpublished'],
		'exclude'         		=> true,
		'default'				=> 1,
		'inputType'       		=> 'checkbox',
		'eval'            		=> array('tl_class'=>''),
		'sql'			  		=> "char(1) NOT NULL default '1'",
	),
#	'customcatalog_edit_operations'	=> array
#	(
#		
#	),
));
