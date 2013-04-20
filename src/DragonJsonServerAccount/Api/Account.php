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
	 * Entfernt den aktuellen Account
	 * @session
	 */
	public function removeAccount()
	{
		$serviceManager = $this->getServiceManager();

		$session = $serviceManager->get('Session')->getSession();
		$serviceAccount = $serviceManager->get('Account');
		$account = $serviceAccount->getAccountByAccountId($session->getAccountId());
		$serviceAccount->removeAccount($account);
	}
	
    /**
	 * Entfernt die aktuelle Session und meldet den Account somit ab
     * @session
	 */
	public function removeSession()
	{
    	$serviceManager = $this->getServiceManager();
    	
    	$serviceSession = $serviceManager->get('Session');
    	$serviceSession->removeSession($serviceSession->getSession());
	}
}
