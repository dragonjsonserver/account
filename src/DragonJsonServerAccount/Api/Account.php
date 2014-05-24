<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
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
     * Methode zur Verbindungsprüfung
     * @DragonJsonServerAccount\Annotation\Session
     */
    public function ping()
    {}

    /**
     * Validiert den übergebenen Namen
     * @param string $name
     * @throws \DragonJsonServer\Exception
     */
    public function validateName($name)
    {
        $serviceManager = $this->getServiceManager();

        $serviceAccount = $serviceManager->get('\DragonJsonServerAccount\Service\Account');
        $serviceAccount->validateName($name);
        $account = $serviceAccount->getAccountByName($name, false);
        if (null !== $account) {
            throw new \DragonJsonServer\Exception(
                'name not unique',
                ['name' => $name, 'account' => $account->toArray()]
            );
        }
    }
	
    /**
	 * Erstellt einen neuen Account und gibt die dazugehörige Session zurück
     * @param string $name
     * @param string $language
	 * @return array
	 */
	public function createAccount($name, $language)
	{
        $this->validateName($name);
		$serviceManager = $this->getServiceManager();
		
		$account = $serviceManager->get('\DragonJsonServerAccount\Service\Account')
            ->createAccount($name, $language);
		$serviceSession = $serviceManager->get('\DragonJsonServerAccount\Service\Session');
		$session = $serviceSession->createSession($account);
		$serviceSession->setSession($session);
		return $session->toArray();
	}
	
	/**
	 * Entfernt den aktuellen Account
	 * @DragonJsonServerAccount\Annotation\Session
	 */
	public function removeAccount()
	{
		$serviceManager = $this->getServiceManager();

		$session = $serviceManager->get('\DragonJsonServerAccount\Service\Session')->getSession();
		$serviceAccount = $serviceManager->get('\DragonJsonServerAccount\Service\Account');
		$account = $serviceAccount->getAccountByAccountId($session->getAccountId());
		$serviceAccount->removeAccount($account);
	}
	
    /**
	 * Entfernt die aktuelle Session und meldet den Account somit ab
     * @DragonJsonServerAccount\Annotation\Session
	 */
	public function removeSession()
	{
    	$serviceManager = $this->getServiceManager();
    	
    	$serviceSession = $serviceManager->get('\DragonJsonServerAccount\Service\Session');
    	$serviceSession->removeSession($serviceSession->getSession());
	}
}
