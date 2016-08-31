<?php
namespace Aeq\Hal;

use Aeq\Hal\Client\UnitTestClientAdapter;
use Aeq\Hal\Serializer\JsonSerializer;
use Aeq\Hal\Explorer\Resource\Resource as HalResource;

class ExplorerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var UnitTestClientAdapter
     */
    private $client;

    /**
     * @var Explorer
     */
    private $explorer;

    /**
     * initialize dependencies
     */
    public function setUp()
    {
        $this->client = new UnitTestClientAdapter();
        $this->explorer = new Explorer();
        $this->explorer->setClientAdapter($this->client);
        $this->explorer->setSerializer(new JsonSerializer());
    }

    /**
     * @test
     * @return HalResource
     */
    public function shouldExploreResponse()
    {
        $resource = $this->explorer->explore($this->client->request('GET', '/api'));
        $data = $resource->getData();

        $this->assertSame('cool API', $data['description']);

        return $resource;
    }

    /**
     * @param HalResource $resource
     *
     * @depends shouldExploreResponse
     * @test
     */
    public function shouldFollowLinkToResource(HalResource $resource)
    {
        $data = $resource->getLink('administrator')->follow()->getData();
        $this->assertSame('Kevin Schu', $data['name']);
    }

    /**
     * @param HalResource $resource
     *
     * @depends shouldExploreResponse
     * @test
     */
    public function shouldFollowLinkToResourceCollection(HalResource $resource)
    {
        $data = $resource->getLink('posts')->follow()->getData();
        $this->assertCount(2, $data);
        $this->assertSame(1, $data[0]['id']);
        $this->assertSame(2, $data[1]['id']);
    }

    /**
     * @param HalResource $resource
     *
     * @depends shouldExploreResponse
     * @test
     */
    public function shouldFollowLinkToResourceAfterFollowingLinkToResourceCollection(HalResource $resource)
    {
        $resourceCollection = $resource->getEmbedded('posts');
        foreach ($resourceCollection as $index => $subResource) {
            /** @var HalResource $subResource */
            $data = $subResource->getLink('publisher')->follow()->getData();
            $this->assertSame('Kevin Schu', $data['name']);
        }
        $data = $resource->getData();
        $this->assertSame('Kevin Schu', $data['_embedded']['posts'][0]['_embedded']['publisher']['name']);
        $this->assertSame('Kevin Schu', $data['_embedded']['posts'][1]['_embedded']['publisher']['name']);
    }
}
