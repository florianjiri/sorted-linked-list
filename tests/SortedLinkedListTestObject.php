<?php
namespace Florianjiri\SortedLinkedList;

use Florianjiri\SortedLinkedList\Node\NodeInterface as NodeNodeInterface;

class SortedLinkedListTestObject extends SortedLinkedList {

    public function getFirstNode():NodeNodeInterface|Null
    {
        return $this->firstNode;
    }
}