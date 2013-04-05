<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2013 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAccount
 */

namespace DragonJsonServerAccount\Event;

/**
 * Eventklasse für das Beenden einer Session
 */
class Logout extends \Zend\EventManager\Event
{
	use \DragonJsonServer\ServiceManagerTrait { 
		getServiceManager as public; 
	}
	
	/**
	 * @var string
	 */
	protected $name = 'logout';

    /**
     * Setzt die Session bevor sie beendet wurde
     * @param \DragonJsonServerAccount\Entity\Session $session
     * @return Logout
     */
    public function setSession(\DragonJsonServerAccount\Entity\Session $session)
    {
        $this->setParam('session', $session);
        return $this;
    }

    /**
     * Gibt die Session bevor sie beendet wurde zurück
     * @return \DragonJsonServerAccount\Entity\Session
     */
    public function getSession()
    {
        return $this->getParam('session');
    }
}
