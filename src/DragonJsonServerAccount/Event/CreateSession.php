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
 * Eventklasse für das Erstellen einer Session
 */
class CreateSession extends \Zend\EventManager\Event
{
	/**
	 * @var string
	 */
	protected $name = 'createsession';

    /**
     * Setzt den Account für den die Session erstellt wurde
     * @param \DragonJsonServerAccount\Entity\Account $account
     * @return CreateSession
     */
    public function setAccount(\DragonJsonServerAccount\Entity\Account $account)
    {
        $this->setParam('account', $account);
        return $this;
    }

    /**
     * Gibt den Account für den die Session erstellt wurde zurück
     * @return \DragonJsonServerAccount\Entity\Account
     */
    public function getAccount()
    {
        return $this->getParam('account');
    }

    /**
     * Setzt die Session nachdem sie erstellt wurde
     * @param \DragonJsonServerAccount\Entity\Session $session
     * @return CreateSession
     */
    public function setSession(\DragonJsonServerAccount\Entity\Session $session)
    {
        $this->setParam('session', $session);
        return $this;
    }

    /**
     * Gibt die Session nachdem sie erstellt wurde zurück
     * @return \DragonJsonServerAccount\Entity\Session
     */
    public function getSession()
    {
        return $this->getParam('session');
    }
}