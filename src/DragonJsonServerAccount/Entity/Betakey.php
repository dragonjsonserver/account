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
 * Entityklasse eines Betakeys
 * @Doctrine\ORM\Mapping\Entity
 * @Doctrine\ORM\Mapping\Table(name="betakeys")
 */
class Betakey
{
	/** 
	 * @Doctrine\ORM\Mapping\Id 
	 * @Doctrine\ORM\Mapping\Column(type="integer")
	 * @Doctrine\ORM\Mapping\GeneratedValue
	 **/
	protected $betakey_id;

    /**
     * @Doctrine\ORM\Mapping\Column(type="string")
     **/
    protected $betakey;
	
	/**
	 * Setzt die ID des Betakeys
	 * @param integer $betakey_id
	 * @return Betakey
	 */
	protected function setBetakeyId($betakey_id)
	{
		$this->betakey_id = $betakey_id;
		return $this;
	}
	
	/**
	 * Gibt die ID des Betakeys zurück
	 * @return integer
	 */
	public function getBetakeyId()
	{
		return $this->betakey_id;
	}

    /**
     * Setzt den Betakey
     * @param string $betakey
     * @return Betakey
     */
    public function setBetakey($betakey)
    {
        $this->betakey = $betakey;
        return $this;
    }

    /**
     * Gibt den Betakey zurück
     * @return string
     */
    public function getBetakey()
    {
        return $this->betakey;
    }
	
	/**
	 * Setzt die Attribute des Betakeys aus dem Array
	 * @param array $array
	 * @return Betakey
	 */
	public function fromArray(array $array)
	{
		return $this
			->setBetakeyId($array['betakey_id'])
            ->setBetakey($array['betakey']);
	}
	
	/**
	 * Gibt die Attribute des Betakeys als Array zurück
	 * @return array
	 */
	public function toArray()
	{
		return [
			'__className' => __CLASS__,
			'betakey_id' => $this->getBetakeyId(),
            'betakey' => $this->getBetakey(),
		];
	}
}
