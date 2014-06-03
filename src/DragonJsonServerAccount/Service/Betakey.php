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
 * Serviceklasse zur Verwaltung eines Betakeys
 */
class Betakey
{
	use \DragonJsonServer\ServiceManagerTrait;
	use \DragonJsonServerDoctrine\EntityManagerTrait;
	
	/**
	 * Entfernt den übergebenen Betakey
	 * @param \DragonJsonServerAccount\Entity\Betakey $betakey
	 * @return Betakey
	 */
	public function removeBetakey(\DragonJsonServerAccount\Entity\Betakey $betakey)
	{
        $entityManager = $this->getEntityManager();

        $entityManager->remove($betakey);
        $entityManager->flush();
		return $this;
	}

    /**
     * Gibt den Betakey zurück
     * @param string $betakey
     * @return \DragonJsonServerAccount\Entity\Betakey
     * @throws \DragonJsonServer\Exception
     */
    public function getBetakeyByBetakey($betakey)
    {
        $entityManager = $this->getEntityManager();

        $conditions = ['betakey' => $betakey];
        $betakey = $entityManager->getRepository('\DragonJsonServerAccount\Entity\Betakey')
            ->findOneBy($conditions);
        if (null === $betakey) {
            throw new \DragonJsonServer\Exception('invalid betakey', $conditions);
        }
        return $betakey;
    }
}