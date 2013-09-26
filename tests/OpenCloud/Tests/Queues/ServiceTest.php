<?php
/**
 * @copyright Copyright 2012-2013 Rackspace US, Inc. 
      See COPYING for licensing information.
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @version   1.5.9
 * @author    Glen Campbell <glen.campbell@rackspace.com>
 * @author    Jamie Hannaford <jamie.hannaford@rackspace.com>
 */

namespace OpenCloud\Tests\Queues;

class ServiceTest extends \OpenCloud\Tests\OpenCloudTestCase 
{
    
    private $service;
    
    public function __construct()
    {
        $this->service = $this->getClient()->queues('cloudQueues', 'ORD');
    }
        
    public function testListQueues()
    {
        $queues = $this->service->listQueues(array('marker' => 2));
        $this->assertInstanceOf('OpenCloud\Common\Collection', $queues);

        $first = $queues->first();

        $this->assertEquals(
            '036b184b28fcb548349af623079119c6a966cbc',
            $first->getName()
        );
        
        $this->assertNotNull($first->getHref());
    }
    
    public function testGetQueue()
    {
        $queue = $this->service->getQueue();
        $this->assertInstanceOf('OpenCloud\Queues\Resource\Queue', $queue);
    }
    
    public function testHasQueue()
    {
        $this->assertTrue($this->service->hasQueue('realQueue'));
        $this->assertFalse($this->service->hasQueue('foobar'));
    }
    
    /**
     * @expectedException OpenCloud\Common\Exceptions\InvalidArgumentError
     */
    public function testHasQueueFailsWithoutName()
    {
        $this->service->hasQueue(array());
    }

}