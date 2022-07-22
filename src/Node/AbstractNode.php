<?php

namespace Florianjiri\SortedLinkedList\Node;

abstract class AbstractNode implements NodeInterface
{
    public AbstractNode|null $next = null;

    abstract public function valueCompare(NodeInterface $node): int;
}
