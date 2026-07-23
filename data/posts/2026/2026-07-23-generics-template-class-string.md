---
title: "Generics tip for class-string"
tags: [php, static-analysis, phpstan, psalm, generics]
mastodon: https://phpc.social/@asgrim/116920134063499708
---

Just a quick tip this one. When writing a method that returns an instance of
a class instantiated within the method, make use of static analysis templates
to help your IDE/tooling figure out what the thing is... for example, let's
say you have this mocking method with Mockery:

```php
function createMockOf(string $className): MockInterface
{
  $mock = Mockery::mock($class);
  // maybe do some stuff with the mock for your use case
  return $mock;
}
```

The trouble with this is it's not particularly straightforward for tooling to
figure out what the return type really is; sometimes you'll find it thinks
`$mock` is just a `MockInterface`... in reality it is an 
[intersection type](https://phpstan.org/blog/union-types-vs-intersection-types).
Try this to help tooling understand:

```php
/**
 * @template T
 * @param class-string<T> $className
 * @return T&MockInterface
 */
function createMockOf(string $className): MockInterface
// etc...
```

Now when you call this, tooling and IDEs will understand better, e.g.:

```php
// before - MockInterface
// after - SomeInterface&MockInterface
$thing = createMockOf(SomeInterface::class);
```
