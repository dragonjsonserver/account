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
	 * @param integer $account_id
	 * @param array $data
	 * @return \DragonJsonServerAccount\Entity\Session
	 */
	public function createSession($account_id, array $data = [])
	{
		$session = (new \DragonJsonServerAccount\Entity\Session())
			->setAccountId($account_id)
			->setSessionhash(md5($account_id . microtime(true)))
			->setData($data);
		$this->getServiceManager()->get('\DragonJsonServerDoctrine\Service\Doctrine')->transactional(function ($entityManager) use ($session) {
			$entityManager->persist($session);
			$entityManager->flush();
			$this->getEventManager()->trigger(
				(new \DragonJsonServerAccount\Event\CreateSession())
					->setTarget($this)
					->setSession($session)
			);
		});
		return $session;
	}
	
	/**
	 * Entfernt die übergebene Session aus der Datenbank
	 * @param \DragonJsonServerAccount\Entity\Session $session
	 * @return Session
	 */
	public function removeSession(\DragonJsonServerAccount\Entity\Session $session)
	{
		$this->getServiceManager()->get('\DragonJsonServerDoctrine\Service\Doctrine')->transactional(function ($entityManager) use ($session) {
			$this->getEventManager()->trigger(
				(new \DragonJsonServerAccount\Event\RemoveSession())
					->setTarget($this)
					->setSession($session)
			);
			$entityManager->remove($session);
			$entityManager->flush();			
		});
		return $this;
	}
	
	/**
	 * Entfernt die Sessions mit der AccountID
	 * @param integer $account_id
	 * @return Session
	 */
	public function removeSessionsByAccountId($account_id)
	{
		$entityManager = $this->getEntityManager();
		
		$sessions = $this->getSessionsByAccountId($account_id);
		foreach ($sessions as $session) {
			$this->removeSession($session);
		}
		return $this;
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
	 * @return \DragonJsonServerAccount\Entity\Session|null
	 */
	public function getSession()
	{
		return $this->session;
	}
	
	/**
	 * Gibt die Session mit dem Sessionhash zurück
	 * @param string $sessionhash
	 * @return \DragonJsonServerAccount\Entity\Session
     * @throws \DragonJsonServer\Exception
	 */
	public function getSessionBySessionhash($sessionhash)
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
	 * Gibt die Sessions mit der AccountID zurück
	 * @param integer $account_id
	 * @return array
	 */
	public function getSessionsByAccountId($account_id)
	{
		$entityManager = $this->getEntityManager();
		
		return $entityManager->getRepository('\DragonJsonServerAccount\Entity\Session')
			->findBy(['account_id' => $account_id]);
	}
	
	/**
	 * Aktualisiert die Daten der Session
	 * @param \DragonJsonServerAccount\Entity\Session $session
	 * @param array $data
	 * @return Session
	 */
	public function changeData(\DragonJsonServerAccount\Entity\Session $session, array $data)
	{
		$entityManager = $this->getEntityManager();
		
		$session->setData($data);
		$entityManager->persist($session);
		$entityManager->flush();
		return $this;
	}
}
