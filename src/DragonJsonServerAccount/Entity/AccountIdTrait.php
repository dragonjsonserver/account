<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2013 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAccount
 */

namespace DragonJsonServerAccount\Entity;

/**
 * Trait für die AccountId mit der Beziehung zu einem Account
 */
trait AccountIdTrait
{
	/**
	 * @Doctrine\ORM\Mapping\Column(type="integer")
	 **/
	protected $account_id;
	
	/**
	 * Setzt die AccountID der Session
	 * @param integer $account_id
	 * @return Session
	 */
	public function setAccountId($account_id)
	{
		$this->account_id = $account_id;
		return $this;
	}
	
	/**
	 * Gibt die AccountID der Session zurück
	 * @return integer
	 */
	public function getAccountId()
	{
		return $this->account_id;
	}
}