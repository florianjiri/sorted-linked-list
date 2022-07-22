<?php

namespace Florianjiri\SortedLinkedList\Node;

class IntegerNode extends AbstractNode
{
    public int $value;

    public function valueCompare(NodeInterface $node): int
    {
        if ($this->value == $node->value) {
            return 0;
        }
        return ($this->value < $node->value) ? -1 : 1;
    }
}
