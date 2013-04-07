<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2013 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAccount
 */

namespace DragonJsonServerAccount\Api;

/**
 * API Klasse zur Verwaltung eines Accounts
 */
class Account
{
	use \DragonJsonServer\ServiceManagerTrait;
	
    /**
	 * Erstellt einen neuen Account und gibt die dazugehörige Session zurück
	 * @return array
	 */
	public function createAccount()
	{
		$serviceManager = $this->getServiceManager();
		
		$account = $serviceManager->get('Account')->createAccount();
		$serviceSession = $serviceManager->get('Session');
		$session = $serviceSession->createSession($account);
		$serviceSession->setSession($session);
		return $session->toArray();
	}
	
    /**
	 * Meldet den Account ab und entfernt die dazugehörige Session
     * @session
	 */
	public function logoutAccount()
	{
    	$serviceManager = $this->getServiceManager();
    	
    	$serviceSession = $serviceManager->get('Session');
    	$session = $serviceSession->getSession();
    	$serviceSession->removeSession($session);
	}
}
