<?php


namespace maarky\Monad;


interface SingleContainer
{
    /**
     * @return mixed
     */
    public function get();

    /**
     * @param mixed $else
     * @return mixed
     */
    public function getOrElse($else);

    /**
     * @param callable $call
     * @return mixed
     */
    public function getOrCall(callable $call);

    /**
     * @param SingleContainer $else
     * @return SingleContainer
     */
    public function orElse(SingleContainer $else): SingleContainer;

    /**
     * @param callable $call
     * @return SingleContainer
     */
    public function orCall(callable $call): SingleContainer;

    /**
     * @return bool
     */
    public function isDefined(): bool;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @param callable $filter
     * @return SingleContainer
     */
    public function filter(callable $filter): SingleContainer;

    /**
     * @param callable $filter
     * @return SingleContainer
     */
    public function filterNot(callable $filter): SingleContainer;

    /**
     * @param callable $map
     * @return SingleContainer
     */
    public function map(callable $map): SingleContainer;

    /**
     * @param callable $map
     * @return SingleContainer Any type of SingleContainer returned by $map
     * @throws \TypeError If $map does not return a SingleContainer
     */
    public function flatMap(callable $map): SingleContainer;

    /**
     * @param callable $each
     * @return SingleContainer
     */
    public function foreach(callable $each): SingleContainer;

    /**
     * @param callable $nothing
     * @return SingleContainer
     */
    public function fornothing(callable $nothing): SingleContainer;

    /**
     * @param SingleContainer $value
     * @return bool
     */
    public function equals($value): bool;
}