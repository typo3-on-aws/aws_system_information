<?php
namespace Typo3OnAws\AwsSystemInformation\Slots;

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
 * @link        https://typo3-on-aws.org
 */

use TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Http\RequestFactory;
use GuzzleHttp\Exception\RequestException;

/**
 * Signal Service
 */
class SystemInformationSlot
{
    /**
     * EC2 instance metadata URI
     *
     * @see https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-instance-metadata.html
     * @access private
     * @var string
     */
    private $uri = 'http://169.254.169.254/latest/meta-data/instance-type';

    /**
     * Number of seconds to wait while trying to connect to a server
     *
     * @var float
     */
    const HTTP_CONNECT_TIMEOUT = 2;

    /**
     * Timeout to use when reading a streamed body
     *
     * @var float
     */
    const HTTP_READ_TIMEOUT = 2;

    /**
     * Timeout of the request in seconds
     *
     * @var float
     */
    const HTTP_TIMEOUT = 4;

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct()
    {
    }

    /**
     * Adds environment information for System Information Toolbar
     *
     * @access public
     * @param SystemInformationToolbarItem $systemInformation
     */
    public function addEnvironmentInformation(SystemInformationToolbarItem $systemInformation)
    {
        // Set system information entry
        $systemInformation->addSystemInformation(...$this->getInstanceType());
    }


    /**
     * Returns the instance type, e.g. "t2.medium"
     *
     * @access public
     * @param SystemInformationToolbarItem $systemInformation
     * @return array
     */
    public function getInstanceType() : array
    {
        /** @var \TYPO3\CMS\Core\Http\RequestFactory $requestFactory */
        $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);

        $additionalOptions = [
            'headers' => ['Cache-Control' => 'no-cache'],
            'allow_redirects' => false,
            'cookies' => false,
            'connect_timeout' => self::HTTP_CONNECT_TIMEOUT,
            'read_timeout' => self::HTTP_READ_TIMEOUT,
            'timeout' => self::HTTP_TIMEOUT
        ];

        try {
            $response = $requestFactory->request($this->uri, 'GET', $additionalOptions);
            if ($response->getStatusCode() === 200) {
                $instanceType = $response->getBody()->getContents();
            }
        } catch (RequestException $e) {
            $instanceType = 'unknown';
        }

        return [
            htmlspecialchars('EC2 Instance Type'),
            htmlspecialchars($instanceType),
            'systeminformation-aws'
        ];
    }
}
