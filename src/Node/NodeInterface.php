<?php

namespace Florianjiri\SortedLinkedList\Node;

/**
 * @property NodeInterface|null $next
 * @property string|int $value
 */
interface NodeInterface
{
    public function valueCompare(NodeInterface $node): int;
}
