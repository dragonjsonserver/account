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
 * API Klasse zur Administration von Betakeys
 */
class BetakeyAdmin
{
    use \DragonJsonServer\ServiceManagerTrait;

    /**
     * Generiert die übergebene Menge an neuen Betakeys
     * @param integer $amount
     * @return array
     */
    public function generateBetakeys($amount = 1)
    {
        $serviceManager = $this->getServiceManager();

        $betakeys = $serviceManager->get('\DragonJsonServerAccount\Service\BetakeyAdmin')
            ->generateBetakeys($amount);
        return $serviceManager->get('\DragonJsonServerDoctrine\Service\Doctrine')->toArray($betakeys);
    }
}
