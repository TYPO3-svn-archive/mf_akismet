<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Michael Feinbier (typo3@feinbier.net)
*  (c) 2006 Bret Kuhns
*  All rights reserved
*
*  This script is part of the Typo3 project. The Typo3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once( t3lib_extMgm::extPath('mf_akismet').'akismet.class.php');

class tx_mfakismet {
	
	/** Extension Configuration */
	var $extConf;
	
	/**
	 * Hook called from ve_guest
	 *
	 * @param unknown_type $pObj
	 */
	function preEntryInsertProcessor($data,$pObj) {
		$this->extConf	=	unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['mf_akismet']);
		
		// Array to check
		$checkArray	=	array(
			'author'	=>	$data['firstname'].' '.$data['lastname'],
			'email'	=>	$data['email'],
			'website'	=>	$data['homepage'],
			'body'	=>	$data['entry'],
			'user_ip'	=>	$data['remote_addr']
		);
		
		$spamCheck = new Akismet($this->extConf['homepageUrl'], $this->extConf['apiKey'], $checkArray);

		//Error while talking to Akismet
		if($spamCheck->errorsExist()) {
			$data['tx_mfakismet_error']	=	serialize($spamCheck->getErrors());
		} else {
			//Spamcheck worked fine
			if($spamCheck->isSpam()) {
				//is Spam
				$data = $this->handleSpam($data);
				#$pObj->config['notify_mail'] = false;
			}
		}
		
		return $data;
	}
	
	/**
	 * Handles the Spam entry according to the setup
	 *
	 * @param uataArray
	 */
	function handleSpam($dataArray) {
		$dataArray['tx_mfakismet_isspam']	=	1;
		switch ($this->extConf['spamHandling']) {
					case 2:
						//delete
						$dataArray['deleted']	=	1;
						break;
					default:
						$dataArray['hidden']	=	1;
						break;
				}
				
		return $dataArray;		
	}
	
	/**
	 * Housekeeping  - if enabled in setup
	 * Hard delete of Spam entries...
	 *
	 * @param unknown_type $them
	 */
	function postEntryInsertedHook(&$them) {
		/* 	We fetch the last entry here - otherwise we 
			could simply delete all from database,
			but THAT could have unwanted consequences */
		
		if($this->extConf['spamHandling'] == '3') {
			$lastId	=	$GLOBALS['TYPO3_DB']->sql_insert_id();
			$GLOBALS['TYPO3_DB']->exec_DELETEquery(
				'tx_veguestbook_entries',
				'uid ='.$lastId.' AND tx_mfakismet_isspam = 1'
			);
		}
		
	}
	
	/**
	 * Hook for sending back informations to akismet if a entry is positive false
	 * or negative true 
	 *
	 * @param unknown_type $status
	 * @param unknown_type $table
	 * @param unknown_type $id
	 * @param unknown_type $fieldArray
	 * @param unknown_type $pObj
	 */
	function processDatamap_afterDatabaseOperations($status, $table, $id, $fieldArray, $pObj) {
		//only on change of the isspam icon 
		if($fieldArray['tx_mfakismet_isspam'] AND $table == 'tt_news') {
			//Get the original comment
			$data	=	t3lib_BEfunc::getRecord('tx_veguestbook_entries',$id);
			
			// Array to check
			$checkArray	=	array(
				'author'	=>	$data['firstname'].' '.$data['lastname'],
				'email'	=>	$data['email'],
				'website'	=>	$data['homepage'],
				'body'	=>	$data['entry'],
				'user_ip'	=>	$data['remote_addr']
			);
			
			$spamCheck = new Akismet($this->extConf['homepageUrl'], $this->extConf['apiKey'], $checkArray);
			
			
			if(!$spamCheck->errorsExist()) {
				//Is a positive false
				if($fieldArray['tx_mfakismet_isspam'] == 0)
					$spamCheck->submitHam();
				//is a negative true
				elseif($fieldArray['tx_mfakismet_isspam'] == 1)
					$spamCheck->submitSpam();
			}
		}
	}
}

if (defined("TYPO3_MODE") && $TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/mf_akismet/class.tx_mfakismet.php"])
{
	include_once ($TYPO3_CONF_VARS[TYPO3_MODE]["XCLASS"]["ext/mf_akismet/class.tx_mfakismet.php"]);
}
?>