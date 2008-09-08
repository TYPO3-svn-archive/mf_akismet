<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

require_once(t3lib_extMgm::extPath('mf_akismet').'class.tx_mfakismet.php');

//registering for  hooks
	$CONF	=	unserialize($TYPO3_CONF_VARS['EXT']['extConf']['mf_akismet']);
	if($CONF['xclass']	==	'1')
		$TYPO3_CONF_VARS['BE']['XCLASS']['typo3/class.db_list_extra.inc'] = t3lib_extMgm::extPath('mf_akismet').'class.ux_localRecordList.php';

$TYPO3_CONF_VARS['EXTCONF']['ve_guestbook']['preEntryInsertHook'][] = 'tx_mfakismet';
$TYPO3_CONF_VARS['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass'][] = 'tx_mfakismet'; 



?>