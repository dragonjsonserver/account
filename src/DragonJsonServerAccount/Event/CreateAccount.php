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
 * Eventklasse für die Erstellung eines Accounts
 */
class CreateAccount extends \Zend\EventManager\Event
{
	/**
	 * @var string
	 */
	protected $name = 'createaccount';

    /**
     * Setzt den Account der erstellt wurde
     * @param \DragonJsonServerAccount\Entity\Account $account
     * @return CreateAccount
     */
    public function setAccount(\DragonJsonServerAccount\Entity\Account $account)
    {
        $this->setParam('account', $account);
        return $this;
    }

    /**
     * Gibt den Account der erstellt wurde zurück
     * @return \DragonJsonServerAccount\Entity\Account
     */
    public function getAccount()
    {
        return $this->getParam('account');
    }
}
