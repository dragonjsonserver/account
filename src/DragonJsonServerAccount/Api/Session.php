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
 * API Klasse zur Verwaltung einer Session
 */
class Session
{
	use \DragonJsonServer\ServiceManagerTrait;

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

    /**
     * Gibt die Daten der aktuellen Session zurück
     * @return array
     * @DragonJsonServerAccount\Annotation\Session
     */
    public function getSession()
    {
        return $this->getServiceManager()->get('\DragonJsonServerAccount\Service\Session')
            ->getSession()->toArray();
    }
}
