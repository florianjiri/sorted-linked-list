<?php

namespace Florianjiri\SortedLinkedList;
use PHPUnit\Framework\TestCase;

final class SortedLinkedListTest extends TestCase
{
    /**
     * @dataProvider addProvider
     * @param array<string|int> $insertValues
     * @param array<string|int> $expected
     */
    public function testAdd(array $insertValues, array $expected): void
    {
        $sortedLinkedList = new SortedLinkedListTestObject();
        foreach($insertValues as $insertValue) {
            $sortedLinkedList->add($insertValue);
        }

        $current = $sortedLinkedList->getFirstNode();

        $iterator = 0;
        while($current) {
            $this->assertEquals($expected[$iterator], $current->value);
            $current = $current->next;
            $iterator++;
        }
        $this->assertEquals(count($expected), $iterator);
        $this->assertEquals(count($insertValues), $iterator);
    }

    /**
     * @return array<int,array<int,array<int,int|string>>>
     */
    public function addProvider(): array
    {
        $alphabet = range('A', 'Z');
        return [
            [['a', 'z'], ['a', 'z']],
            [['z', 'a'], ['a', 'z']],
            [[0, 'a'], [0,'a']],
            [['a', 0], [0,'a']],
            [array_reverse($alphabet), $alphabet ],
            [[-1,0, -10], [-10, -1, 0]],
            [['a', 'a'], ['a','a']],
            [['c', 'a', 'a'], ['a','a', 'c']],
            [['a', 'c', 'a'], ['a','a', 'c']],
            [['a', 'a', 'c'], ['a','a', 'c']],
        ];
    }

     /**
     * @dataProvider removeProvider
     * @depends testAdd
     * @param array<string|int> $removeValues
     * @param array<string|int> $expectedValuesInNodes
     */
    public function testRemove(
        SortedLinkedListTestObject $sortedLinkedList,
        array $removeValues,
        array $expectedValuesInNodes,
        bool $expectedRetun
        ): void
    {
        foreach($removeValues as $removeValue) {
            $return = $sortedLinkedList->remove($removeValue);
            $this->assertEquals($expectedRetun, $return);
        }

        $current = $sortedLinkedList->getFirstNode();

        $iterator = 0;
        while($current) {
            $this->assertEquals($expectedValuesInNodes[$iterator], $current->value);
            $current = $current->next;
            $iterator++;
        }
        
        $this->assertEquals(count($expectedValuesInNodes), $iterator);
    }

    /**
     * @return array<int,array<int,array<int,string>|bool|SortedLinkedListTestObject>>
     */
    public function removeProvider(): array
    {
        return [
            [$this->preCreateAlphabetSortedLinkedList('A', 'Z'), ['A'], range('B', 'Z'), true],
            [$this->preCreateAlphabetSortedLinkedList('A', 'Z'), ['D'], array_merge(range('A', 'C'), range('E', 'Z')), true],
            [$this->preCreateAlphabetSortedLinkedList('A', 'Z'), ['D', 'E'], array_merge(range('A', 'C'), range('F', 'Z')), true],
            [$this->preCreateAlphabetSortedLinkedList('A', 'Z'), ['Y', 'Z'], range('A', 'X'), true],
            [$this->preCreateAlphabetSortedLinkedList('A', 'Z'), ['1'], range('A', 'Z'), false],
        ];
    }

    /**
     * @depends testAdd
     */
    public function testToString(): void
    {
        $sortedLinkedList = $this->preCreateAlphabetSortedLinkedList('A','C');
        $string = $sortedLinkedList->__toString();
        $this->assertEquals('A'.PHP_EOL.'B'.PHP_EOL.'C'.PHP_EOL, $string);
    }

    public function testGetIterator(): void
    {
        $sortedLinkedList = $this->preCreateAlphabetSortedLinkedList('A','C');

        $iterator = $sortedLinkedList->getIterator();
        $this->assertInstanceOf(SortedLinkedListIterator::class, $iterator);
         // @phpstan-ignore-next-line
        $this->assertSame($sortedLinkedList->getFirstNode(), $iterator->current());
    }

    private function preCreateAlphabetSortedLinkedList(string $first, string $end): SortedLinkedListTestObject
    {
        $sortedLinkedList = new SortedLinkedListTestObject();
        foreach((range($first, $end)) as $insertValue) {
            $sortedLinkedList->add($insertValue);
        }

        return $sortedLinkedList;
    }

}

