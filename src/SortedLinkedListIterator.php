<?php

namespace Florianjiri\SortedLinkedList;

use Florianjiri\SortedLinkedList\Node\NodeInterface;

/** @implements \Iterator<int, NodeInterface> */
class SortedLinkedListIterator implements \Iterator
{
    private NodeInterface|null $firstNode;

    private NodeInterface|null $currentNode;

    private int $key;

    private function __construct()
    {
    }

    public static function fromSortedLinkedList(NodeInterface|null $node): self
    {
        $iterator = new SortedLinkedListIterator();
        $iterator->firstNode = $node;
        $iterator->currentNode = $node;
        $iterator->key = 0;
        return $iterator;
    }

    public function current(): NodeInterface|null
    {
        return $this->currentNode;
    }

    public function key(): int
    {
        return $this->key;
    }

    public function next(): void
    {
        $this->currentNode = $this->currentNode->next ?? null;
        $this->key += 1;
    }

    public function rewind(): void
    {
        $this->currentNode = $this->firstNode;
        $this->key = 0;
    }

    public function valid(): bool
    {
        return $this->currentNode !== null;
    }
}
