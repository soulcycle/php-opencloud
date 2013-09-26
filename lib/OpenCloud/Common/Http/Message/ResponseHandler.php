<?php

/**
 * @copyright Copyright 2012-2013 Rackspace US, Inc. 
  See COPYING for licensing information.
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @version   1.5.9
 * @author    Glen Campbell <glen.campbell@rackspace.com>
 * @author    Jamie Hannaford <jamie.hannaford@rackspace.com>
 */

namespace OpenCloud\Common\Http\Message;

use OpenCloud\Http\Exception\UnexpectedResponseException;
use Guzzle\Http\Exception\BadResponseException;

/**
 * Description of ResponseHandler
 * 
 * @link 
 */
class ResponseHandler
{
    
    private $template = array();
    
    public static function fromArray(array $params = array())
    {
        $self = new self();
        $self->setConfiguration($params);
        return $self;
    }
    
    public function setConfiguration(array $params = array())
    {
        foreach ($params as $status => $config) {
            if (Response::isValidStatus($status)) {
                $this->template[$status] = $config;
            }
        }
        
        return $this;
    }
    
    public function setRequest($request)
    {
        $this->request = $request;
        
        return $this;
    }
    
    public function setResponse($response)
    {
        $this->response = $response;
        
        return $this;
    }
    
    public function setExpectedResponse($expected)
    {
        $this->expectedResponse = $expected;
        
        return $this;
    }
    
    public function handle()
    {
        $status = $this->response->getStatusCode();
        
        // If somebody is expecting a specific response code, make the check stricter
        if ($this->expectedResponse && $this->expectedResponse != $this->response) {
            return new UnexpectedResponseException(sprintf(
                'This operation was expecting a %d status code, but received %d',
                $this->expectedResponse,
                $status
            ));
        }
        
        // How do we want to handle this particular status code?
        if (in_array($status, $this->template)) {

            $config = $this->template[$status];
            
            if (isset($config['allow']) && $config['allow'] === true) {
                
                if (!empty($config['callback'])) {
                    return $config['callback'];
                }
                
            } else { 
                $class = $config['class'];
                return new $class($config['message']);
            }        
            
        } elseif ($this->response->isError()) {
            // Otherwise, handle other errors
            return BadResponseException::factory($this->request, $this->response);
        }
    }
    
}