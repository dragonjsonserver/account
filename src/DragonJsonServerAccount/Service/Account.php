<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAccount
 */

namespace DragonJsonServerAccount\Service;

/**
 * Serviceklasse zur Verwaltung eines Accounts
 */
class Account
{
	use \DragonJsonServer\ServiceManagerTrait;
	use \DragonJsonServer\EventManagerTrait;
	use \DragonJsonServerDoctrine\EntityManagerTrait;

	/**
	 * Erstellt einen neuen Account und gibt ihn zurück
	 * @return \DragonJsonServerAccount\Entity\Account
	 */
	public function createAccount()
	{
		$account = new \DragonJsonServerAccount\Entity\Account();
		$this->getServiceManager()->get('\DragonJsonServerDoctrine\Service\Doctrine')->transactional(function ($entityManager) use ($account) {
			$entityManager->persist($account);
			$entityManager->flush();
			$this->getEventManager()->trigger(
				(new \DragonJsonServerAccount\Event\CreateAccount())
					->setTarget($this)
					->setAccount($account)
			);
		});
		return $account;
	}
	
	/**
	 * Entfernt den übergebenen Account
	 * @param \DragonJsonServerAccount\Entity\Account $account
	 * @return Account
	 */
	public function removeAccount(\DragonJsonServerAccount\Entity\Account $account)
	{
		$this->getServiceManager()->get('\DragonJsonServerDoctrine\Service\Doctrine')->transactional(function ($entityManager) use ($account) {
			$this->getEventManager()->trigger(
					(new \DragonJsonServerAccount\Event\RemoveAccount())
					->setTarget($this)
					->setAccount($account)
			);
			$this->getServiceManager()->get('\DragonJsonServerAccount\Service\Session')->removeSessionsByAccountId($account->getAccountId());
			$entityManager->remove($account);
			$entityManager->flush();
		});
		return $this;
	}
	
    /**
	 * Gibt den Account zur übergebenen AccountID zurück
	 * @param integer $account_id
	 * @return \DragonJsonServerAccount\Entity\Account
     * @throws \DragonJsonServer\Exception
	 */
	public function getAccountByAccountId($account_id)
	{
		$entityManager = $this->getEntityManager();
		
		$account = $entityManager->find('\DragonJsonServerAccount\Entity\Account', $account_id);
		if (null === $account) {
			throw new \DragonJsonServer\Exception('invalid account_id', ['account_id' => $account_id]);
		}
		return $account;
	}
}