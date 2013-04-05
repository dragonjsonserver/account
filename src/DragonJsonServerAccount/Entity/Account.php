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
 * Entityklasse eines Accounts
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="accounts")
 */
class Account
{
	use \DragonJsonServerDoctrine\Entity\CreatedTrait;
	
	/** 
	 * @Doctrine\ORM\Mapping\Id 
	 * @Doctrine\ORM\Mapping\Column(type="integer")
	 * @Doctrine\ORM\Mapping\GeneratedValue
	 **/
	protected $account_id;
	
	/**
	 * Gibt die ID des Accounts zurück
	 * @return integer
	 */
	public function getAccountId()
	{
		return $this->account_id;
	}
	
	/**
	 * Gibt die Attribute des Accounts als Array zurück
	 * @return array
	 */
	public function toArray()
	{
		return [
			'account_id' => $this->getAccountId(),
			'created' => $this->getCreated(),
		];
	}
}
