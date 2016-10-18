#PHP HAL (Hypertext Application Language) Explorer#

This library provides a full featured API to discover a [HAL (Hypertext Application Language)](http://stateless.co/hal_specification.html) API via an expressive interface.

```php
$posts = $resource->getLink('posts')->follow();
```

Features
* GuzzleHttp as default HTTP Client
* integrate custom HTTP clients easily
* human readable API
* Shipped with a simple default serializer for JSON responses
* Possibility to integrate custom serializers
* Fully tested
* Used in production projects

##Usage##

###1. Initiate the Explorer###
```php
$explorer = new Explorer();
$explorer->setClientAdapter(new GuzzleClientAdapter());
$explorer->setSerializer(new JsonSerializer());
```
If you want to use the the build in "GuzzleClientAdapter" you have to require guzzlehttp/guzzle manually in your composer project since guzzle is only suggested.

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
The result of following a link is that the resolved resource is appended to the parent „$resource“ object („_embedded“).
This allows you to access the linked resource without resolving the link again:
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

To listen on a specific event you have to implement a Listener. A Listener is a PHP object with a public method "handle".
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
###PostClientRequestEvent###
This event is called on each executed request (after following a link or using the "request" method) and contains the complete PSR-7 response.
```php
$explorer->listenOnEvent(PostClientRequestEvent::class, new MyHandler());
```