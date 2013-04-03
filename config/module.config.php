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
    'apiclasses' => [
        '\DragonJsonServerAccount\Api\Account' => 'Account',
        '\DragonJsonServerAccount\Api\EmailAddress' => 'EmailAddress',
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
	'service_manager' => [
		'invokables' => [
            'Account' => '\DragonJsonServerAccount\Service\Account',
            'Emailaddress' => '\DragonJsonServerAccount\Service\Emailaddress',
            'Session' => '\DragonJsonServerAccount\Service\Session',
		],
	],
    'eventlisteners' => [
    	['DragonJsonServer\Service\Server', 'request', function (\DragonJsonServer\Event\Request $request) {
    		$serviceManager = $request->getServiceManager();
    		
    		$method = $request->getRequest()->getMethod();
    		list ($classname, $methodname) = $serviceManager->get('Server')->parseMethod($method);
    		$classreflection = new \Zend\Code\Reflection\ClassReflection($classname);
    		if (!$classreflection->getMethod($methodname)->getDocBlock()->hasTag('authenticate')) {
    			return;
    		}
    		$serviceSession = $serviceManager->get('Session');
    		$session = $serviceSession->verifySession($request->getRequest()->getParam('sessionhash'));
    		$serviceSession->setSession($session);
    	}],
    	['DragonJsonServer\Service\Server', 'servicemap', function (\DragonJsonServer\Event\Servicemap $servicemap) {
    		$serviceManager = $servicemap->getServiceManager();
    		
    		$serviceServer = $serviceManager->get('Server');
	        foreach ($servicemap->getServicemap()->getServices() as $method => $service) {
    			list ($classname, $methodname) = $serviceServer->parseMethod($method);
	            $classreflection = new \Zend\Code\Reflection\ClassReflection($classname);
	            if (!$classreflection->getMethod($methodname)->getDocBlock()->hasTag('authenticate')) {
	                continue;
	            }
	            $service->addParams([
	                [
	                    'type' => 'string',
	                    'name' => 'sessionhash',
	                    'optional' => false,
	                ],
	            ]);
	        }
    	}]
    ],
];
