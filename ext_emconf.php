<?php

########################################################################
# Extension Manager/Repository config file for ext: "mf_akismet"
#
# Auto generated 08-09-2008 16:47
#
# Manual updates:
# Only the data in the array - anything else is removed by next write.
# "version" and "dependencies" must not be touched!
########################################################################

$EM_CONF[$_EXTKEY] = array(
	'title' => 'Akismet for ve_guestbook',
	'description' => 'Provides an Akismet Antispam integration for Modern Guestbook (ve_guestbook)',
	'category' => 'misc',
	'shy' => 0,
	'version' => '0.2.0',
	'dependencies' => '',
	'conflicts' => '',
	'priority' => '',
	'loadOrder' => '',
	'module' => '',
	'state' => 'beta',
	'uploadfolder' => 0,
	'createDirs' => '',
	'modify_tables' => 'tx_veguestbook_entries',
	'clearcacheonload' => 0,
	'lockType' => '',
	'author' => 'Michael Feinbier',
	'author_email' => 'typo3@feinbier.net',
	'author_company' => '',
	'CGLcompliance' => '',
	'CGLcompliance_note' => '',
	'constraints' => array(
		'depends' => array(
		),
		'conflicts' => array(
		),
		'suggests' => array(
		),
	),
	'_md5_values_when_last_written' => 'a:15:{s:9:"ChangeLog";s:4:"ca1f";s:10:"README.txt";s:4:"ee2d";s:17:"akismet.class.php";s:4:"459e";s:22:"class.tx_mfakismet.php";s:4:"1bef";s:28:"class.ux_localRecordList.php";s:4:"684c";s:21:"ext_conf_template.txt";s:4:"7354";s:12:"ext_icon.gif";s:4:"d813";s:17:"ext_localconf.php";s:4:"4477";s:14:"ext_tables.php";s:4:"5125";s:14:"ext_tables.sql";s:4:"075f";s:16:"locallang_db.xml";s:4:"9eac";s:19:"doc/wizard_form.dat";s:4:"53f5";s:20:"doc/wizard_form.html";s:4:"378f";s:14:"gfx/nospam.gif";s:4:"b5b6";s:12:"gfx/spam.gif";s:4:"9127";}',
);

?>