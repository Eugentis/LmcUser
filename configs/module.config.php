<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'user'                  => 'EdpUser\Controller\UserController',
                'edpuser-register-form' => 'EdpUser\Form\Register',
                'edpuser-login-form'    => 'EdpUser\Form\Login',
            ),
            'doctrine-container' => array(
                'parameters' => array(
                    'em' => array(
                        'default' => array(
                            'driver' => array(
                                'paths' => array(
                                    'EdpUser' => __DIR__ . '/../src/EdpUser/Entity',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'edpuser-register-form' => array(
                'parameters' => array(
                    'entityManager' => 'em-default'
                ),
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options'  => array(
                        'script_paths' => array(
                            'user' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ),
        ),
    ),
);