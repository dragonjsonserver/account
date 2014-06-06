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
 * Serviceklasse zur Administration von Betakeys
 */
class BetakeyAdmin
{
	use \DragonJsonServer\ServiceManagerTrait;
	use \DragonJsonServerDoctrine\EntityManagerTrait;

    /**
     * Generiert die übergebene Menge an neuen Betakeys
     * @param integer $amount
     */
    public function generateBetakeys($amount = 1)
    {
        $serviceManager = $this->getServiceManager();
        $entityManager = $this->getEntityManager();

        $betakeys = [];
        $serviceRandom = $serviceManager->get('\DragonJsonServerRandom\Service\Random');
        for ($i = 0; $i < $amount; ++$i) {
            $betakey = (new \DragonJsonServerAccount\Entity\Betakey)
                ->setBetakey($serviceRandom->getString(32));
            $entityManager->persist($betakey);
            $entityManager->flush();
            $betakeys[] = $betakey;
        }
        return $betakeys;
    }
}