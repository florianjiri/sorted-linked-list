<?php

namespace Florianjiri\SortedLinkedList;

use Florianjiri\SortedLinkedList\Node\NodeInterface;
use Florianjiri\SortedLinkedList\Node\StringNode;
use PHPUnit\Framework\TestCase;

final class SortedLinkedListIteratorTest extends TestCase
{
    public function testFromSortedLinkedList(): void
    {
        $node = new StringNode();
        $node->value = 'A';
        $iterator = SortedLinkedListIterator::fromSortedLinkedList($node);
        $this->assertInstanceOf(SortedLinkedListIterator::class, $iterator);
        $reflectIterator= new \ReflectionClass($iterator);
        $reflectIteratorFirstNode = $reflectIterator->getProperty('firstNode');
        $reflectIteratorFirstNode->setAccessible(true);
        $this->assertSame($node, $reflectIteratorFirstNode->getValue($iterator));

        $reflectIteratorCurrentNode = $reflectIterator->getProperty('currentNode');
        $reflectIteratorCurrentNode->setAccessible(true);
        $this->assertSame($node, $reflectIteratorCurrentNode->getValue($iterator));

        $reflectIteratorKey= $reflectIterator->getProperty('key');
        $reflectIteratorKey->setAccessible(true);
        $this->assertEquals(0,$reflectIteratorKey->getValue($iterator));
    }

    public function testCurrent(): void
    {
        $iterator = $this->createTestIterator();
        $this->assertInstanceOf(SortedLinkedListIterator::class, $iterator);
        $reflectIterator= new \ReflectionClass($iterator);
        $reflectIteratorCurrentNode = $reflectIterator->getProperty('currentNode');
        $reflectIteratorCurrentNode->setAccessible(true);
        $this->assertSame($reflectIteratorCurrentNode->getValue($iterator), $iterator->current());
    }

    public function testKey(): void
    {
        $iterator = $this->createTestIterator();
        $this->assertInstanceOf(SortedLinkedListIterator::class, $iterator);
        $reflectIterator= new \ReflectionClass($iterator);
        $reflectIteratorKey= $reflectIterator->getProperty('key');
        $reflectIteratorKey->setAccessible(true);
        $this->assertEquals($reflectIteratorKey->getValue($iterator), $iterator->key());
    }

    public function testNext(): void
    {
        $secondNode = new StringNode();
        $secondNode->value = 'B';

        $firstNode = new StringNode();
        $firstNode->value = 'A';
        $firstNode->next = $secondNode;

        $iterator = SortedLinkedListIterator::fromSortedLinkedList($firstNode);
        
        $reflectIterator= new \ReflectionClass($iterator);
        $reflectIteratorFirstNode = $reflectIterator->getProperty('firstNode');
        $reflectIteratorFirstNode->setAccessible(true);
        $reflectIteratorCurrentNode = $reflectIterator->getProperty('currentNode');
        $reflectIteratorCurrentNode->setAccessible(true);
        $reflectIteratorKey= $reflectIterator->getProperty('key');
        $reflectIteratorKey->setAccessible(true);

        $this->assertSame($firstNode, $reflectIteratorFirstNode->getValue($iterator));
        $this->assertSame($firstNode, $reflectIteratorCurrentNode->getValue($iterator));
        $this->assertEquals(0,$reflectIteratorKey->getValue($iterator));

        $iterator->next();

        $this->assertSame($firstNode, $reflectIteratorFirstNode->getValue($iterator));
        $this->assertSame($secondNode, $reflectIteratorCurrentNode->getValue($iterator));
        $this->assertEquals(1,$reflectIteratorKey->getValue($iterator));
    }

     /**
     * @dependent testNext
     */
    public function testRewind(): void
    {
        $secondNode = new StringNode();
        $secondNode->value = 'B';
        $firstNode = new StringNode();
        $firstNode->value = 'A';
        $firstNode->next = $secondNode;

        $iterator = SortedLinkedListIterator::fromSortedLinkedList($firstNode);
        $reflectIterator= new \ReflectionClass($iterator);
        $reflectIteratorFirstNode = $reflectIterator->getProperty('firstNode');
        $reflectIteratorFirstNode->setAccessible(true);
        $reflectIteratorCurrentNode = $reflectIterator->getProperty('currentNode');
        $reflectIteratorCurrentNode->setAccessible(true);
        $reflectIteratorKey= $reflectIterator->getProperty('key');
        $reflectIteratorKey->setAccessible(true);

        $iterator->next();

        $this->assertSame($firstNode, $reflectIteratorFirstNode->getValue($iterator));
        $this->assertSame($secondNode, $reflectIteratorCurrentNode->getValue($iterator));
        $this->assertEquals(1, $reflectIteratorKey->getValue($iterator));

        $iterator->rewind();

        $this->assertSame($firstNode, $reflectIteratorFirstNode->getValue($iterator));
        $this->assertSame($firstNode, $reflectIteratorCurrentNode->getValue($iterator));
        $this->assertEquals(0, $reflectIteratorKey->getValue($iterator));
    }

    /**
     * @dependent testNext
     */
    public function testValidate(): void
    {
        $iterator = $this->createTestIterator();
        $this->assertTrue($iterator->valid());
        $iterator->next();
        $this->assertFalse($iterator->valid());
    }

    private function createTestIterator(): SortedLinkedListIterator
    {
        $node = new StringNode();
        $node->value = 'A';
        return SortedLinkedListIterator::fromSortedLinkedList($node);
    }
}
