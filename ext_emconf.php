<?php

/*
 * This file is part of the TYPO3 CMS Extension "AWS System Information"
 * Extension author: Michael Schams - https://schams.net
 *
 * For copyright and license information, please read the README.md
 * file distributed with this source code.
 *
 * @package     TYPO3
 * @subpackage  aws_system_information
 * @author      Michael Schams <schams.net>
 * @link        https://t3rrific.com/typo3-on-aws/
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'AWS System Information',
    'description' => 'Extend System Information panel to show Amazon EC2 instance type, e.g. t2.large',
    'category' => 'module',
    'state' => 'stable',
    'clearCacheOnLoad' => 0,
    'author' => 'Michael Schams <schams.net>',
    'author_email' => '',
    'author_company' => 'schams.net',
    'version' => '10.2.0',
    'constraints' => [
        'depends' => [
            'typo3' => '10.0.0-10.5.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
