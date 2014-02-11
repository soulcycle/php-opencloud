<?php
/**
 * Copyright 2012-2014 Rackspace US, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace OpenCloud\LoadBalancer\Resource;

/**
 * The connection logging feature allows logs to be delivered to a Cloud Files
 * account every hour. For HTTP-based protocol traffic, these are Apache-style
 * access logs. For all other traffic, this is connection and transfer logging.
 */
class ConnectionLogging extends SubResource
{

    public $enabled;

    protected static $json_name = "connectionLogging";
    protected static $url_resource = "connectionlogging";

    protected $createKeys = array('enabled');

    public function create($params = array())
    {
        return $this->update($params);
    }

    public function delete()
    {
        return $this->noDelete();
    }
}
