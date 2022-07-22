<?php

namespace Florianjiri\SortedLinkedList;

use Florianjiri\SortedLinkedList\Exception\SortedLinkedListException;
use Florianjiri\SortedLinkedList\Node\IntegerNode;
use Florianjiri\SortedLinkedList\Node\NodeInterface;
use Florianjiri\SortedLinkedList\Node\StringNode;

/** @implements \IteratorAggregate<int, NodeInterface> */
class SortedLinkedList implements \IteratorAggregate
{
    protected NodeInterface|null $firstNode = null;

    public function getIterator(): \Traversable
    {
        return SortedLinkedListIterator::fromSortedLinkedList($this->firstNode);
    }

    public function add(string|int $value): int
    {
        if (is_string($value)) {
            return $this->addString($value);
        }
        if (is_int($value)) {
            return $this->addInteger($value);
        }

        // @phpstan-ignore-next-line
        throw new SortedLinkedListException("Unsupported value's type");
    }

    public function addString(string $value): int
    {
        $newNode = new StringNode();
        $newNode->value = $value;
        return $this->executeAdd($newNode);
    }

    public function addInteger(int $value): int
    {
        $newNode = new IntegerNode();
        $newNode->value = $value;
        return $this->executeAdd($newNode);
    }

    private function executeAdd(NodeInterface $newNode): int
    {
        $position = 1;

        if (! $this->firstNode) {
            $this->firstNode = $newNode;

            return $position;
        } else {
            if ($this->firstNode->valueCompare($newNode) > 0) {
                $newNode->next = $this->firstNode;
                $this->firstNode = $newNode;

                return $position;
            }

            $current = $this->firstNode;
            while ($current) {
                if ($current->valueCompare($newNode) <= 0 && $current->next !== null && $current->next->valueCompare($newNode) > 0) {
                    $newNode->next = $current->next;
                    $current->next = $newNode;

                    return $position;
                } elseif ($current->valueCompare($newNode) <= 0 && $current->next === null) {
                    $newNode->next = $current->next;
                    $current->next = $newNode;

                    return $position;
                }
                $current = $current->next;
                $position++;
            }
        }
        throw new SortedLinkedListException("Unexpected error");
    }

    public function remove(string|int $value): bool
    {
        if (is_string($value)) {
            return $this->removeString($value);
        }
        if (is_int($value)) {
            return $this->removeInteger($value);
        }

        // @phpstan-ignore-next-line
        throw new SortedLinkedListException("Unsupported value's type");
    }

    public function removeString(string $value): bool
    {
        $removeNode = new StringNode();
        $removeNode->value = $value;

        return $this->executeRemove($removeNode);
    }

    public function removeInteger(int $value): bool
    {
        $removeNode = new IntegerNode();
        $removeNode->value = $value;

        return $this->executeRemove($removeNode);
    }

    public function executeRemove(NodeInterface $removeNode): bool
    {
        if (! $this->firstNode) {
            return false;
        }
        if ($this->firstNode->valueCompare($removeNode) == 0) {
            $this->firstNode = $this->firstNode->next;

            return true;
        }

        $current = $this->firstNode;
        while ($current) {
            if (isset($current->next)) {
                if ($current->next->valueCompare($removeNode) == 0) {
                    $current->next = $current->next->next;

                    return true;
                }
                $current = $current->next;
            } else {
                return false;
            }
        }
    }

    public function __toString(): string
    {
        $string = "";
        $current = $this->firstNode;
        while ($current) {
            $string .= $current->value . PHP_EOL;
            $current = $current->next;
        }

        return $string;
    }
}
