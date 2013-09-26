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

namespace OpenCloud\Tests\Volume;

class SnapshotTest extends \OpenCloud\Tests\OpenCloudTestCase
{

    private $snapshot;

    public function __construct()
    {
        $service = $this->getClient()->volumeService('cloudBlockStorage', 'DFW');
        $this->snapshot = $service->snapshot();
    }

    /**
     * @expectedException OpenCloud\Common\Exceptions\UpdateError
     */
    public function testUpdate()
    {
        $this->snapshot->Update();
    }

    public function testName()
    {
        $this->snapshot->display_name = 'FOOBAR';
        $this->assertEquals('FOOBAR', $this->snapshot->Name());
    }

    public function testJsonName()
    {
        $this->assertEquals('snapshot', $this->snapshot->JsonName());
    }

    public function testResourceName()
    {
        $this->assertEquals('snapshots', $this->snapshot->ResourceName());
    }

    public function testCreateJson()
    {
        $this->snapshot->display_name = 'BARFOO';
        $obj = $this->snapshot->createJson();
        $this->assertEquals('BARFOO', $obj->snapshot->display_name);
    }

}
