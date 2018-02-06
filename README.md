Single Container
================

SingleContainer is an interface for creating monads. The idea is that you can create a container 
that wraps a single value, or no value, and then perform actions on that value and create new monads 
containing that value or the result of an action performed on that value.

Although it doesn't have to be implemented this way, the idea is that a SingleContainer should expect values of 
specific types. For example, one type of SingleContainer might only contain strings. This provides type safety, 
allowing you to apply functions with the confidence that the function is able to operate on the type of value
stored in the container.

Documentation
-------------

A number of these methods take callables as their argument. These methods come in two types: those whose container 
does hold a value, and those whose container holds no value. On those methods which do expect a container to have 
a value the callable must always take that value as the first argument and they can optionally take the container 
itself as the second. On those methods which do not expect a container to have a value the callable can optionally 
take the container as its only value. The reason the container is passed to the callables is because it is possible 
the container might have additional information. For example, if the container has no value then the callable might
want to know what type of container is calling it in order to provide context on what it should do.

Methods that expect a container to have a value are map(), flatmap(), filter(), filternot(), and foreach().

Methods that expect a container to have no value are getOrCall(), orCall(), and fornothing().

### get()

Retrieves the container value. Must throw a Type error if the container has no value.

### getOrElse($else)

Retrieves the container value, or $else if the container has no value. Must throw a Type error if the 
container has no value and $else is a different type than what the container should have. In other words, 
if the container is meant to store strings then $else must be a string.

### getOrCall(callable $call)

Retrieves the container value, or calls $call if the container has no value and returns the result. Must 
throw a Type error if the container has no value and $call returns a different type than what the container 
should have. In other words, if the container is meant to store strings then $call must return a string.

$call should have signature function(SingleContainer $container): mixed 
where $container is the calling SingleContainer and mixed is the same datatype that should be stored 
in the container.

### orElse(SingleContainer $else)

Returns container if the container has a value, otherwise returns $else.

### orCall(callable $call): SingleContainer

Returns container if the container has a value, otherwise calls $call and returns its value.

$call should have signature function(SingleContainer $container): SingleContainer where $container is the 
calling SingleContainer.

### isDefined(): bool

Returns true if container has value, otherwise false.

### isEmpty(): bool

Returns false if container has value, otherwise true.

### filter(callable $filter): SingleContainer

Calls filter passing in the container value and the container itself. Returns itself if filter returns true, 
otherwise an empty container of the same type. If this method is called on an empty container there is nothing 
to filter so it should ignore $filter and return itself.

$filter should have signature function(mixed $var, SingleContainer $container): boolean where $var is the data 
being stored in the calling SingleContainer and $container is the calling SingleContainer. 

### filterNot(callable $filter): SingleContainer

The inverse of the filter() method. It should return itself if $filter returns false, otherwise it should return 
an empty container.

### map(callable $map): SingleContainer

If container has a value it should call $map, passing in the value and itself. $map should return a value to be 
wrapped inside a SingleContainer. If $map returns a SingleContainer it should be wrapped inside another 
SingleContainer. If $map returns an empty value it should return an empty SingleContainer. If the calling container 
has no value it should ignore $map and return itself.

$map should have signature function(mixed $var, SingleContainer $container): mixed where $var is the data being 
stored in the calling SingleContainer and $container is the calling SingleContainer.

### flatMap(callable $map): SingleContainer

If container has a value it should call $map, passing in the value and itself. $map must return any type of 
SingleContainer. If container has no value it should ignore $map and return itself.

$map Should have signature function(mixed $var, SingleContainer $container): SingleContainer where $var is the data 
being stored in the calling SingleContainer and $container is the calling SingleContainer.

### foreach(callable $each): SingleContainer

If container has a value it calls $each and does nothing with the result. Then returns itself. 
If container has no value it ignores $each and returns itself.

This method is meant to be used when you want to produce side effects, not when you want to alter the container value.

$each should have signature function(mixed $var, SingleContainer $container): void where $var is the data being 
stored in the calling SingleContainer, and $container is the calling SingleContainer.

### fornothing(callable $nothing): SingleContainer

If container has a value it ignores $nothing and returns itself. If container has no value it calls $nothing and 
does nothing with the result. Then returns itself.

This method is meant to be used when you want to produce side effects.

$nothing should have signature function(SingleContainer $container): void where $container is the calling 
SingleContainer.

### equals($value): bool

Determines if two containers are equal. They must be the same container class. They must also have the same value, 
or they must both be empty.