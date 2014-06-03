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
 * API Klasse zur Verwaltung eines Betakeys
 */
class Betakey
{
	use \DragonJsonServer\ServiceManagerTrait;

    /**
     * Validiert den übergebenen Betakey
     * @param string $betakey
     * @throws \DragonJsonServer\Exception
     */
    public function validateBetakey($betakey)
    {
        $serviceManager = $this->getServiceManager();

        if ($serviceManager->get('Config')['dragonjsonserveraccount']['betakeys']) {
            $serviceManager->get('\DragonJsonServerAccount\Service\Betakey')
                ->getBetakeyByBetakey($betakey);
        }
    }
}
