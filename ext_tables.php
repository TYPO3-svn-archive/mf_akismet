<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$tempColumns = Array (
	"tx_mfakismet_isspam" => Array (		
		"exclude" => 0,		
		"label" => "LLL:EXT:mf_akismet/locallang_db.xml:tx_veguestbook_entries.tx_mfakismet_isspam",		
		"config" => Array (
			"type" => "check",
		)
	),
	"tx_mfakismet_error" => Array (		
		"exclude" => 0,		
		"label" => "LLL:EXT:mf_akismet/locallang_db.xml:tx_veguestbook_entries.tx_mfakismet_error",		
		"config" => Array (
			"type" => "none",
		)
	),
);


t3lib_div::loadTCA("tx_veguestbook_entries");
t3lib_extMgm::addTCAcolumns("tx_veguestbook_entries",$tempColumns,1);
t3lib_extMgm::addToAllTCAtypes("tx_veguestbook_entries","tx_mfakismet_isspam;;;;1-1-1, tx_mfakismet_error");
?>