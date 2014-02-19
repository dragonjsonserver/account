<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAccount
 */

namespace DragonJsonServerAccount\Event;

/**
 * Eventklasse für die Entfernung eines Accounts
 */
class RemoveAccount extends \Zend\EventManager\Event
{
	/**
	 * @var string
	 */
	protected $name = 'RemoveAccount';

    /**
     * Setzt den Account bevor er entfernt wird
     * @param \DragonJsonServerAccount\Entity\Account $account
     * @return RemoveAccount
     */
    public function setAccount(\DragonJsonServerAccount\Entity\Account $account)
    {
        $this->setParam('account', $account);
        return $this;
    }

    /**
     * Gibt den Account bevor er entfernt wird zurück
     * @return \DragonJsonServerAccount\Entity\Account
     */
    public function getAccount()
    {
        return $this->getParam('account');
    }
}
