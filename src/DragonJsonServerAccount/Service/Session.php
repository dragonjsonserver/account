<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2013 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAccount
 */

namespace DragonJsonServerAccount\Service;

/**
 * Serviceklasse zur Verwaltung einer Session
 */
class Session
{
    use \DragonJsonServer\ServiceManagerTrait;
	use \DragonJsonServer\EventManagerTrait;
	use \DragonJsonServerDoctrine\EntityManagerTrait;
	
	/**
	 * @var \DragonJsonServerAccount\Entity\Session 
	 */
	protected $session;
	
    /**
	 * Erstellt eine neue Session für den übergebenen Account
	 * @param \DragonJsonServerAccount\Entity\Account $account
	 * @param array $data
	 * @return \DragonJsonServerAccount\Entity\Session
	 */
	public function createSession(\DragonJsonServerAccount\Entity\Account $account, array $data = [])
	{
		$entityManager = $this->getEntityManager();
		
		$account_id = $account->getAccountId();
		$session = (new \DragonJsonServerAccount\Entity\Session())
			->setAccountId($account_id)
			->setSessionhash(md5($account_id . microtime(true)))
			->setData($data);
		$entityManager->persist($session);
		$entityManager->flush();
		return $session;
	}
	
	/**
	 * Prüft den Sessionhash und setzt die Session
	 * @param string $sessionhash
	 * @return \DragonJsonServerAccount\Entity\Session
     * @throws \DragonJsonServer\Exception
	 */
	public function verifySession($sessionhash)
	{
		$entityManager = $this->getEntityManager();
		
		$conditions = ['sessionhash' => $sessionhash];
		$session = $entityManager->getRepository('\DragonJsonServerAccount\Entity\Session')
                                 ->findOneBy($conditions);
		if (null === $session) {
			throw new \DragonJsonServer\Exception('invalid sessionhash', $conditions);
		}
		return $session;
	}
	
	/**
	 * Setzt die aktuelle Session
	 * @param \DragonJsonServerAccount\Entity\Session $session
	 * @return Session
	 */
	public function setSession(\DragonJsonServerAccount\Entity\Session $session)
	{
		$this->session = $session;
		return $this;
	}
	
	/**
	 * Gibt die aktuelle Session zurück
	 * @return \DragonJsonServerAccount\Entity\Session
	 */
	public function getSession()
	{
		return $this->session;
	}
	
	/**
	 * Aktualisiert die übergebene Session in der Datenbank
	 * @param \DragonJsonServerAccount\Entity\Session $session
	 * @return Session
	 */
	public function updateSession(\DragonJsonServerAccount\Entity\Session $session)
	{
		$entityManager = $this->getEntityManager();
		
		$entityManager->persist($session);
		$entityManager->flush();
		return $this;
	}
	
	/**
	 * Entfernt die übergebene Session aus der Datenbank
	 * @param \DragonJsonServerAccount\Entity\Session $session
	 * @return Session
	 */
	public function removeSession(\DragonJsonServerAccount\Entity\Session $session)
	{
		$entityManager = $this->getEntityManager();

		$this->getEventManager()->trigger(
			(new \DragonJsonServerAccount\Event\LogoutAccount())
				->setTarget($this)
				->setSession($session)
		);
		$entityManager->remove($session);
		$entityManager->flush();
		return $this;
	}
}
