<?php

/**
 * Unit Tests
 *
 * @copyright 2012-2013 Rackspace Hosting, Inc.
 * See COPYING for licensing information
 *
 * @version 1.0.0
 * @author Glen Campbell <glen.campbell@rackspace.com>
 */

namespace OpenCloud\Tests\Compute;

class ServiceTest extends \OpenCloud\Tests\OpenCloudTestCase
{
    private $service;
    
    public function __construct()
    {
        $this->service = $this->getClient()->compute('cloudServersOpenStack', 'DFW', 'publicURL');
    }

    /**
     * @expectedException \OpenCloud\Common\Exceptions\UnsupportedVersionError
     */
    public function test__construct()
    {
        $this->getClient()->compute('cloudServers', 'DFW', 'publicURL');
    }

    public function testUrl()
    {
        $this->assertEquals(
            'https://dfw.servers.api.rackspacecloud.com/v2/TENANT-ID/servers', 
            $this->service->Url()
        );
        $this->assertEquals(
            'https://dfw.servers.api.rackspacecloud.com/v2/TENANT-ID/servers/detail', 
            $this->service->Url('servers/detail')
        );
        $this->assertEquals(
            'https://dfw.servers.api.rackspacecloud.com/v2/TENANT-ID/servers?A=1&B=2', 
            $this->service->Url('servers', array('A' => 1, 'B' => 2))
        );
    }

    public function testServer()
    {
        $this->assertInstanceOf('OpenCloud\Compute\Resource\Server', $this->service->Server());
    }

    public function testServerList()
    {
        $this->assertInstanceOf('OpenCloud\Common\Collection', $this->service->ServerList());
    }

    public function testImage()
    {
        $this->assertInstanceOf('OpenCloud\Compute\Resource\Image', $this->service->Image());
    }

    public function testNetwork()
    {
        $this->assertInstanceOf('OpenCloud\Compute\Resource\Network', $this->service->Network());
    }

    public function testNetworkList()
    {
        $this->assertInstanceOf('OpenCloud\Common\Collection', $this->service->NetworkList());
    }

    public function testNamespaces()
    {
        $this->assertNotContains('FOO', $this->service->namespaces());
        $this->assertContains('rax-bandwidth', $this->service->namespaces());
    }

    public function test_load_namespaces()
    {
        $this->assertContains('rax-bandwidth', $this->service->namespaces());
    }

}
