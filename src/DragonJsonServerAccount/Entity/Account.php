<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2014 DragonProjects (http://dragonprojects.de/)
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
     * @Doctrine\ORM\Mapping\Column(type="string")
     **/
    protected $name;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string")
     **/
    protected $language;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string")
     **/
    protected $betakey;
	
	/**
	 * Setzt die ID des Accounts
	 * @param integer $account_id
	 * @return Account
	 */
	protected function setAccountId($account_id)
	{
		$this->account_id = $account_id;
		return $this;
	}
	
	/**
	 * Gibt die ID des Accounts zurück
	 * @return integer
	 */
	public function getAccountId()
	{
		return $this->account_id;
	}

    /**
     * Setzt den Namen des Accounts
     * @param string $name
     * @return Account
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Gibt den Namen des Accounts zurück
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setzt die Sprache des Accounts
     * @param string $language
     * @return Account
     */
    public function setLanguage($language)
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Gibt die Sprache des Accounts zurück
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Setzt den Betakey des Accounts
     * @param string $betakey
     * @return Betakey
     */
    public function setBetakey($betakey)
    {
        $this->betakey = $betakey;
        return $this;
    }

    /**
     * Gibt den Betakey des Accounts zurück
     * @return string
     */
    public function getBetakey()
    {
        return $this->betakey;
    }
	
	/**
	 * Setzt die Attribute des Accounts aus dem Array
	 * @param array $array
	 * @return Account
	 */
	public function fromArray(array $array)
	{
		return $this
			->setAccountId($array['account_id'])
            ->setCreatedTimestamp($array['created'])
            ->setName($array['name'])
            ->setLanguage($array['language']);
	}
	
	/**
	 * Gibt die Attribute des Accounts als Array zurück
	 * @return array
	 */
	public function toArray()
	{
		return [
			'__className' => __CLASS__,
			'account_id' => $this->getAccountId(),
            'created' => $this->getCreatedTimestamp(),
            'name' => $this->getName(),
            'language' => $this->getLanguage(),
		];
	}
}
