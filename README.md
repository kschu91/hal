#PHP HAL (Hypertext Application Language) Explorer#

This library provides a full featured API to discover a [HAL (Hypertext Application Language)](http://stateless.co/hal_specification.html) API via an fluent interface.

```php
$posts = $resource->getLink('posts')->follow();
```

Features
* GuzzleHttp as default HTTP Client
* Easy integrate custom HTTP Clients
* Chainable API for human friendly coding
* Shipped with a simple default serializer for JSON responses
* Possibility to integrate custom serializers
* Full tested
* Used in production projects

##Usage##

###1. Initiate the Explorer###
```php
$explorer = new Explorer();
$explorer->setClientAdapter(new GuzzleClientAdapter());
$explorer->setSerializer(new JsonSerializer());
```

###2. Request your API###
```php
$response = $explorer->request('GET', '/my/api/');
```

###3. Explore the response###
```php
$resource = $explorer->explore($response);
```

###4. Discover your API###
```php
$posts = $resource->getLink('posts')->follow();
foreach($posts as $post) {
    $publisher = $post->getLink('publisher')->follow();
    $company = $publisher->getLink('company')->follow();
}
```
After following links the resolved resource will be append as "_embedded" in the original "$resource" object.
This allows you to get already followed links without resolving the link again:
```php
$posts = $resource->getEmbedded('posts');
foreach($posts as $post) {
    $publisher = $post->getEmbedded('publisher');
    $company = $publisher->getEmbedded('company');
}
```

##Custom HTTP Clients##
Create a new class implementing the "ClientAdapterInterface" and return the response as PSR-7.
```php
use Aeq\Hal\Client\ClientAdapterInterface;

class MyCustomClientAdapter implements ClientAdapterInterface
{
    public function request($method, $uri = null, array $options = [])
    {
        // call your custom client and return the response
    }
}

```

Set the custom client adapter to your explorer before using it.

```php
$explorer->setClientAdapter(new MyCustomClientAdapter());
```

##Custom Serializers##
Create a new class implementing the "SerializerInterface" and return the response.
```php
use Aeq\Hal\Serializer\SerializerInterface;

class MyCustomSerializer implements SerializerInterface
{
    public function serialize($data)
    {
        // serialize your data: $data
    }

    public function deserialize($str)
    {
        // deserialize the string: $str
    }
}
```

Set the custom serializer to your explorer before using it.

```php
$explorer->setSerializer(new MyCustomSerializer());
```
##Events##
This library offers you some events to listen on. To use the event system you have to add the "EventManager" to your Explorer before using it.
```php
$explorer->setEventManager(new EventManager());
```

To listen on a specific event you have to implement a Listener. A Listener is a PHP object with an public method "handle".
As parameter your will get the triggered Event object.

```php
class MyHandler
{
    public function handle(EventInterface $event)
    {
        // process your stuff
    }
}
```
###AfterClientRequestedEvent###
This event is called after a request is done and contains the complete PSR-7 response.
```php
$explorer->listenOnEvent(AfterClientRequestedEvent::class, new MyHandler());
```