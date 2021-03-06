<?php

namespace FSC\RestBundle\Tests\Functional\Model\Representation;

use FSC\RestBundle\Tests\Functional\SerializationTestCase;

use FSC\RestBundle\Model\Representation\Collection;
use FSC\RestBundle\Model\Representation\AtomLink;

class CollectionTest extends SerializationTestCase
{
    public function testEmptySerialization()
    {
        $collection = new Collection();

        $this->assertSerializedXmlEquals(
            '<collection/>',
            $collection
        );
    }

    public function testShortSerialization()
    {
        $collection = new Collection();

        $collection->addLink(AtomLink::create('self', 'http://fsc.com/collection'));
        $collection->addLink(AtomLink::create('next', 'http://fsc.com/collection?page=2'));

        $this->assertSerializedXmlEquals(
'<collection>
  <link rel="self" href="http://fsc.com/collection"/>
  <link rel="next" href="http://fsc.com/collection?page=2"/>
</collection>',
            $collection
        );
    }

    public function testSerialization()
    {
        $collection = new Collection();
        $collection->total = 20;
        $collection->page = 2;
        $collection->limit = 10;

        $collection->addLink(AtomLink::create('self', 'http://fsc.com/collection?page=2'));
        $collection->addLink(AtomLink::create('next', 'http://fsc.com/collection?page=3'));
        $collection->addLink(AtomLink::create('previous', 'http://fsc.com/collection?page=1'));
        $collection->addLink(AtomLink::create('first', 'http://fsc.com/collection?page=1'));
        $collection->addLink(AtomLink::create('last', 'http://fsc.com/collection?page=5'));
        $collection->addLink(AtomLink::create('new', 'http://fsc.com/collection/new'));

        $collection->results = array('foo', 'bar');

        $this->assertSerializedXmlEquals(
'<collection total="20" page="2" limit="10">
  <link rel="self" href="http://fsc.com/collection?page=2"/>
  <link rel="next" href="http://fsc.com/collection?page=3"/>
  <link rel="previous" href="http://fsc.com/collection?page=1"/>
  <link rel="first" href="http://fsc.com/collection?page=1"/>
  <link rel="last" href="http://fsc.com/collection?page=5"/>
  <link rel="new" href="http://fsc.com/collection/new"/>
  <entry><![CDATA[foo]]></entry>
  <entry><![CDATA[bar]]></entry>
</collection>',
            $collection
        );
    }
}
