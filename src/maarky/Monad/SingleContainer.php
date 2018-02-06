<?php


namespace maarky\Monad;


interface SingleContainer
{
    /**
     * Returns container value.
     *
     * @return mixed Where mixed is the same datatype that should be stored in the container
     */
    public function get();

    /**
     * Returns container value if the container has a value, otherwise returns $else.
     *
     * @param mixed $else Where mixed is the same datatype that should be stored in the container
     * @return mixed
     */
    public function getOrElse($else);

    /**
     * Returns container value if the container has a value, otherwise calls $call and returns its value.
     *
     * @param callable $call Should have signature function(SingleContainer): mixed where SingleContainer is the calling SingleContainer and mixed is the same datatype that should be stored in the container
     * @return mixed
     */
    public function getOrCall(callable $call);

    /**
     * Returns container if the container has a value, otherwise returns $else.
     *
     * @param SingleContainer $else
     * @return SingleContainer
     */
    public function orElse(SingleContainer $else): SingleContainer;

    /**
     * Returns container if the container has a value, otherwise calls $call and returns its value.
     *
     * @param callable $call Should have signature function(SingleContainer): SingleContainer where SingleContainer is the calling SingleContainer
     * @return SingleContainer
     */
    public function orCall(callable $call): SingleContainer;

    /**
     * @return bool True if container has value, otherwise false
     */
    public function isDefined(): bool;

    /**
     * @return bool False if container has value, otherwise true
     */
    public function isEmpty(): bool;

    /**
     * Calls filter passing in the container value and the container itself.
     * Returns itself if filter returns true, otherwise an empty container of the same type.
     *
     * @param callable $filter Should have signature function(mixed, SingleContainer): boolean where mixed is the datatype being stored in the calling SingleContainer and SingleContainer is the calling SingleContainer
     * @return SingleContainer
     */
    public function filter(callable $filter): SingleContainer;

    /**
     * Calls filter passing in the container value and the container itself of the same type.
     * Returns itself if filter returns false, otherwise an empty container.
     *
     * @param callable $filter Should have signature function(mixed, SingleContainer): boolean where mixed is the datatype being stored in the calling SingleContainer and SingleContainer is the calling SingleContainer
     * @return SingleContainer
     */
    public function filterNot(callable $filter): SingleContainer;

    /**
     * If container has a value it should call $map, passing in the value and itself.
     * $map should return a value to be wrapped inside a SingleContainer. If $map returns a SingleContainer it should be wrapped inside another SingleContainer.
     * If $map returns an empty value it should return an empty SingleContainer.
     *
     * If container has no value it should ignore $map and return itself
     *
     * @param callable $map Should have signature function(mixed, SingleContainer): mixed where mixed is the datatype being stored in the calling SingleContainer and SingleContainer is the calling SingleContainer
     * @return SingleContainer
     */
    public function map(callable $map): SingleContainer;

    /**
     * If container has a value it should call $map, passing in the value and itself.
     * $map must return any type of SingleContainer
     *
     * If container has no value it should ignore $map and return itself.
     *
     * @param callable $map Should have signature function(mixed, SingleContainer): SingleContainer where mixed is the datatype being stored in the calling SingleContainer and SingleContainer is the calling SingleContainer
     * @return SingleContainer Any type of SingleContainer returned by $map
     * @throws \TypeError If $map does not return a SingleContainer
     */
    public function flatMap(callable $map): SingleContainer;

    /**
     * If container has a value it calls $each and does nothing with the result. Then returns itself.
     *
     * If container has no value it ignores $each and returns itself.
     *
     * @param callable $each Should have signature function(mixed, SingleContainer): void where mixed is the datatype being stored in the calling SingleContainer, and SingleContainer is the calling SingleContainer
     * @return SingleContainer
     */
    public function foreach(callable $each): SingleContainer;

    /**
     * If container has a value it ignores $nothing and returns itself.
     *
     * If container has no value it calls $nothing and does nothing with the result. Then returns itself.
     *
     * @param callable $nothing Should have signature function(SingleContainer): void where SingleContainer is the calling SingleContainer
     * @return SingleContainer
     */
    public function fornothing(callable $nothing): SingleContainer;

    /**
     * Determines if two containers are equal. They must be the same container type.
     * They must also have the same value, or they must both be empty.
     *
     * @param SingleContainer $value
     * @return bool
     */
    public function equals($value): bool;
}