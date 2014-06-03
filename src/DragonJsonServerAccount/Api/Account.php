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
     * @param string $betakey
	 * @return array
	 */
	public function createAccount($name, $language, $betakey = null)
	{
        $this->validateName($name);
		$serviceManager = $this->getServiceManager();

        if ($serviceManager->get('Config')['dragonjsonserveraccount']['betakeys']) {
            $serviceBetakey = $serviceManager->get('\DragonJsonServerAccount\Service\Betakey');
            $serviceBetakey->removeBetakey($serviceBetakey->getBetakeyByBetakey($betakey));
        }
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
     * Ändert die Sprache des aktuellen Accounts
     * @param string $language
     * @DragonJsonServerAccount\Annotation\Session
     */
    public function changeLanguage($language)
    {
        $serviceManager = $this->getServiceManager();

        $serviceSession = $serviceManager->get('\DragonJsonServerAccount\Service\Session');
        $session = $serviceSession->getSession();
        $account = $serviceManager->get('\DragonJsonServerAccount\Service\Account')
            ->changeLanguage($session->getAccountId(), $language);
        $data = $session->getData();
        $data['account'] = $account->toArray();
        $serviceSession->changeData($session, $data);
    }
}
