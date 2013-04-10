<?php
/**
 * @link http://dragonjsonserver.de/
 * @copyright Copyright (c) 2012-2013 DragonProjects (http://dragonprojects.de/)
 * @license http://license.dragonprojects.de/dragonjsonserver.txt New BSD License
 * @author Christoph Herrmann <developer@dragonprojects.de>
 * @package DragonJsonServerAccount
 */

/**
 * @return array
 */
return [
	'dragonjsonserver' => [
	    'apiclasses' => [
	        '\DragonJsonServerAccount\Api\Account' => 'Account',
	    ],
	],
	'dragonjsonserverapiannotation' => [
		'annotations' => ['session'],
	],
	'service_manager' => [
		'invokables' => [
            'Account' => '\DragonJsonServerAccount\Service\Account',
            'Session' => '\DragonJsonServerAccount\Service\Session',
		],
	],
	'doctrine' => [
		'driver' => [
			'DragonJsonServerAccount_driver' => [
				'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
				'cache' => 'array',
				'paths' => [
					__DIR__ . '/../src/DragonJsonServerAccount/Entity'
				],
			],
			'orm_default' => [
				'drivers' => [
					'DragonJsonServerAccount\Entity' => 'DragonJsonServerAccount_driver'
				],
			],
		],
	],
];
