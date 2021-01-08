# PHP Generics specification (for static analysis)

> This is a working document. Please raise issues or submit small PRs to enhance it.  

Generics in PHP are already a reality by using advanced static analysers such as 
[Psalm](https://psalm.dev) and [PHPStan](https://phpstan.org/). 
There are huge benefits that added type safety that generics bring. 
These benefits are due to improved clarity of code and reduced costs from fewer bugs.

There is already an unofficial standard for generics, see documentation from
[Psalm](https://psalm.dev/docs/annotating_code/templated_annotations/) and
[PHPStan](https://medium.com/@ondrejmirtes/generics-in-php-using-phpdocs-14e7301953).
Additional information required for generics is added in docblocks. 

A major blocker to increased uptake is the lack of an "official" standard for generics.
A standard will provide tools (such as IDEs) and libraries with a clear guidelines for implementing and supporting generics. 

The purposes of this repository are:
- Formalise the existing unofficial standards by specifying the syntax. (Rest of this document)
- Create a series of test set of code snippets for testing static analysers against the specification. (See `tests`)
- Eventually progress to a PSR or similar "official" standard. (Assuming this is something the FIG would support).


#### Goals

- To create a clear set of standards for annotating code with the additional information required for generics. Analysis is done by static analysers, not at the run time.
- Provide a set of code samples that illustrate correct behaviour for generics.
- The initial standard is pragmatic. It will aim to address the vast majority of use cases. Some edge cases will not be addressed.  
- The standard will not prevent code from working that does not support the generics notation. 
- Has buy in from the established static analysers (Psalm, PHPStan and Phan) and IDEs (PHPStorm).
- Will be palatable for library and framework maintainers to add support if they want to.

#### Non Goals

- Run time support. The information is for static analysers only.
- To provide complete generics support.
- This deals with only docblocks required for generics. This is not a replacement for PSRs [5](https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc.md) and [19](https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc-tags.md). 



### Overview

There are two parts to the specification.

1. The syntax itself (which is based on the current unofficial standard).
1. How code is annotated with the additional information required by generics. Proposed are 2 methods:
    - Docblocks (the current unoffical standard).
    - Subject to demand and support from tools an Attributes. This the same syntax but adding it to an attribute rather than a docblock.
    
The specification is supported by a series of code snippets to illustate the expected behaviour (with respect to generics).

This is a brief examples of how code can be annotated with additional information required for generics.


#### Docblock version 
This is the current unofficial standard:

```php
/**
 * @template T
 * @param T $value
 * @return array<int,T> 
 */
function asArray(
    $value,
) { 
    return [$value]; 
}
```

#### Attribute version 
This takes the same notation as above and puts it in an [Attribute](https://www.php.net/manual/en/language.attributes.overview.php) instead of a docblock.

This is included as a possible additional method of annotating code with the extra information required for generics. 
Points to consider:

- Not currently supported
- Static analysis tool maintainers and vendors may have little desire to support this. (Initial feedback to the attributes proposal is not favourable.)
- Is this actually better than the docblock version? That said if there is a desire to use attributes it might be the best method, other suggestions are examined [here](https://www.daveliddament.co.uk/articles/php-generics-standard/).

Code using Attributes instead of docblock:
```php
use StaticAnalysis\Generics\v1\Template;
use StaticAnalysis\Generics\v1\Type;

#[Template("T")] 
#[Type("array<int,T>")]    // This is documenting the return type
function asArray(
    #[Type("T")] $value,
) { 
    return [$value]; 
}
```

## Contents

- This file:
  - [TODO](#todo)
  - [FAQs](#faqs)
  - [Related articles](#related-articles)
  - [PHP Generics Notation](#php-generics)
  - [Attributes](#using-attributes-instead-of-docblocks)
  - [Test cases](#test)
  - [Further discussion points](#further-discussion-points)
  - [Conclusions](#conclusions)  
  - [Feedback, suggestions, comments](#feedback)

- Attributes (PHP Code) (Assuming there is demand and support for this):
  - [Template](src/Template.php)
  - [Type](src/Type.php)
  - [Extend](src/Extend.php)
  - [Implement](src/Implement.php)

- Code Examples:
  - [Using docblocks](example/docblock.php)
  - [Using Attributes](example/attributes.php)

- Test cases:
  - [Test cases](tests)


    
## TODO

- [ ] Add more test cases (e.g. corner cases)
- [ ] Add test cases for Attributes (port the docblock tests, maybe a job for Rector?) 
- [ ] Add glossary  
- [ ] Create script to run test code samples through Psalm and PHPStan and check errors reported by those tools match lines annotated with `ERROR:` in the sample files. 
- [ ] Add code of conduct
- [ ] Add contributing doc

## FAQs

- **Did you know X is already working on this?** 
  No. Let [Dave Liddament](https://twitter.com/daveliddament) know and we'll join forces.
- **Why isn't this a PSR?** 
  The hope is this will become a PSR or similar. The purpose of this document is to get the process doing. If there is enough interest then it will be submitted to the FIG in the hope it becomes a PSR.
- **Isn't this covered by PSRs [5](https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc.md) and [19](https://github.com/php-fig/fig-standards/blob/master/proposed/phpdoc-tags.md)?** 
  Those are more general PSRs. Here the focus is only on generics.
- **Who are you to decide this?** 
  Merely an enthusiastic user of static analysis tools and a fan of generics (from Java days). The hope is this will help wider adoption of generics and static analysis in the PHP community.
- **What happens if PHP evolves to have generics as part of the language?** 
  That will be great news. Tools like [Rector](https://getrector.org/) will have rulesets created to automatically convert from code annotated with generics information to full language support.


## Related articles

- [Psalm: Templated annotations](https://psalm.dev/docs/annotating_code/templated_annotations/)
- [PHPStan: Generics in PHP using PHPDocs](https://medium.com/@ondrejmirtes/generics-in-php-using-phpdocs-14e7301953)
- [A standard for generics in PHP](https://www.daveliddament.co.uk/articles/php-generics-standard/)
- [Psalm's author's thoughts on PHP Attributes for static analysis](https://gist.github.com/muglug/03f63a0e6da1d95d03a014f374e8217d)


## PHP Generics 

Generics requires additional information. This additional information is added either via docblock or Attribute. 


## Glossary 

> TODO add in definition of terms including: supertype, subtype, covariance, contravariance, union types, etc 

### Template type

Code is often written that can operate on data of any types. Consider code that models a queue. 
The queue could hold almost anything; strings, objects, integers, etc. 
At the time of writing the code the type of data the queue holds is unknown. 
Instead of specifying the type a placeholder or _template type_ is specified instead. 
The actual type that the _templated type_ resolves to is known based on the context of how the code is used.

A _templated type_ MUST resolve to any FQCN or primitive type.

By convention a _templated type_ is often referred to as `T`.
In the case of arrays or collections with keys and values by convention `K` and `V` are used.

Using docblocks the _template type_ is defined using `@template`, e.g. `@template T`

The `@template` annotation can only be added to: 
- functions
- methods
- classes


#### Class

Here is a class that holds a value, the type of the value it holds, `T`, is not known at the time of writing the `ValueHolder` class.

```php
/**
 * @template T 
 */
class ValueHolder
{
    /** @var T */
    private $value;

    /** @param T $value */
    public function __construct($value) 
    {
        $this->value = $value;
    }
    
    /** @return T */
    public function value()
    {
        return $this->value;
    }
}
```

There are 3 ways of specifying the type of `T`. 

##### Constructor

The first is via the type passed into the constructor.
In the example below an `int` is passed into the constructor. In this context `T` is an `int`.

```php
$valueHolder = new ValueHolder(21);

$age = $valueHolder->value(); // $age is of type int.
```

###### Examples:
- [tests/docblock/template_class_constructor.php](tests/docblock/template_class_constructor.php)

##### Return 
The second to specify the type is giving type information is via a `@return`.

```php
/** @return ValueHolder<int> */
function getAgeValueHolder(): ValueHolder 
{  
    return new ValueHolder(21);
}

$age = getAgeValueHolder()->value(); // $age is of type int 
```

###### Examples:
- [tests/docblock/template_class_return.php](tests/docblock/template_class_return.php)


##### Property 

The third method is to specify type information via a `@var` docblock on a class property. 

```php
class Entity 
{
    /** @var ValueHolder<int> */
    public ValueHolder $ageValueHolder;
    
    public function __construct() 
    {
        $this->ageValueHolder = new ValueHolder(21);
    }
}

$entity = new Entity();
$age = $entity->ageValueHolder; // $age is of type int
```

###### Examples:
- [tests/docblock/template_class_property.php](tests/docblock/template_class_property.php)

##### Param

The final method is specifying type information via a `@param` docblock.

```php
/** @param ValueHolder<int> $intValueHolder */
function takesIntValueHolder(ValueHolder $intValueHolder): void 
{  
    $age = $intValueHolder->value(); // $age is of type int 
}
```

###### Examples:
- [tests/docblock/template_class_param.php](tests/docblock/template_class_param.php)


#### Class templates that cannot be derived from constructor

Consider an object that models a queue:

```php
/** @template T */
class Queue
{
    /** T $item */
    public function add($item): void {...}
    
    /** @return T */
    public function next() {...}
}
```

When creating an instance of the Queue the type `T` can not be inferred. 

The type of entities in the queue needs explicitly stating. In the example below the `@var` docblock is used to show the `Queue` takes items of type `string`:

```php
/** @var Queue<string> $queue */
$queue = new Queue();

$queue->add("hello"); // This is OK
$item = $queue->next(); // $item is a string 
```

###### Examples:
- [tests/docblock/template_class_no_constructor.php](tests/docblock/template_class_no_constructor.php)
- [tests/docblock/template_class_no_constructor_invalid.php](tests/docblock/template_class_no_constructor_invalid.php)


#### Function

Template types can also be used on functions. E.g.:

```php
/** 
 * @template T
 * @param T $value
 * @return T
 */
function mirror($value) 
{
    return $value;
}
```
In this example the type `T` is determined by the type of the argument `$value`.

In the example below `$value` is of type string. Therefore `T` will be `string`. The return type and thus `$mirroredValue` will also be of type `string`.

```php
$mirroredValue = mirror("hello world");
```

###### Examples:
- [tests/docblock/template_function.php](tests/docblock/template_function.php)



### Multiple types

It is possible to specify multiple types. Consider a code to represent a map collection. The type of both the map key (K) and map value (V) need specifying:

```php
/**
 * @template K
 * @template V 
 */
class Map
{
    /** 
     * @param K $key
     * @param V $value
     */
    public function add($key, $value): void {...}
    
    /** 
     * @param K $key
     * @return V
     */
    public function getValue($key) {...}
}
```

To specify multiple _templated types_ add the type information in the angular brackets in the same order that the `@template` appear.
In the `Map` example, the first `@template` is for the type of `K` and the second for `V`. 
In the following example `K` is `string` and `V` is `Person`:

```php
/** @var Map<string,Person> */
$map = new Map();
```

###### Examples:
- [tests/docblock/template_multiple_types.php](tests/docblock/template_multiple_types.php)

### Restricting Template types

It is possible to restrict what a _template type_ resolves to. For example restricting `T` to only be objects is done by using `of`:

```php
/** @template T of object */
```

Full of example:

```php
/**
 * @template T of object
 * @param T $value
 * @return T
 */
function mirror($value)
{
    return $value;
}


$person = mirror(new Person); // OK

$int = mirror(7); // Problem as int is not an object
```


It is also possible a number of valid types. E.g. to allow `T` to be either an `int` of `string` is done like this:

```php
/** @template T of int|string */
```

Example:

```php
/**
 * @template T of int|string
 * @param T $value
 * @return T
 */
function mirror($value)
{
    return $value;
}

$int = mirror(7); // OK
$bool = mirror(true); // Problem as a boolean is not a string or int.
```

A template can restrict to an object and subtypes of that object. For example:

```php
interface Shape {...}

class Square implements Shape {...}

/** @template T of Shape */
class ShapeProcessor {...} // T can only resolve to Shape or a subtype of Shape

/** @var ShapeProcessor<Shape> $shapeProcessor */
$shapeProcessor = new ShapeProcessor(); // OK - Shape is a Shape!

/** @var ShapeProcessor<Square> $squareProcessor */
$squareProcessor = new ShapeProcessor(); // OK - Square is a Shape

/** @var ShapeProcessor<Person> $personProcessor */
$personProcessor = new ShapeProcessor(); // ERROR: Person not subtype of Shape
```

###### Examples:
- [tests/docblock/restricting_templates.php](tests/docblock/restricting_templates.php)
- [tests/docblock/restricting_templates_2.php](tests/docblock/restricting_templates_2.php)
- [tests/docblock/restricting_templates_3.php](tests/docblock/restricting_templates_3.php)


### Class string

A `class-string` is a string that represents the FQCN of a class. 

```php
/**
 * @param class-string $className
 */
function takesClassString(string $className): void {}

takesClassString(Person::class); // OK (assuming Person is a valid class)

takesClassString("a random string"); // ERROR: Does not represent FQCN
```

A class string can be used in conjunction with a _templated type_. 

In the example below `$className` is the FQCN of the type `T`, so `T` is of type `Person`:

```php
/**
 * @template T
 * @param class-string<T> $className
 * @return T
 */
function build(string $className) {
    return new $className;
}

$person = build(Person::class); // $person is an object of type Person
```

###### Examples:
- [tests/docblock/class_string.php](tests/docblock/class_string.php)
- [tests/docblock/template_class_string.php](tests/docblock/template_class_string.php)


### Extending/Implementing types


#### Extends
Consider a repository. The base class has a `persist` method.

```php
/** @template T */
abstract class Repository 
{
    /** @param T $entity */
    public function persist($entity) {...}
}
```

The concrete implementations must specify the `T` and could provide additional methods. E.g.:
```php
/** @extends Repository<Person> */
class PersonRepository extends Repository {...}
  ```

NOTE: the `@extends` docblock. It states that `Repository` is being extended. It also states that `T` is of type `Person`.


#### Implements

If a class is implementing and interface then use `@implements`. 

```php
interface Job {...}
class SendEmailJob implements Job {...}
class CreatePdfJob implements Job {...}

/** @template T */
interface JobProcessor
{
    /** @param T $job */
    public function process($job): void {...}
}

/** @implements JobProcessor<SendEmailJob> */
class EmailSenderJobProcessor implements JobProcessor
{
    public function process($job): void {...}
}

$emailSenderJobProcessor = new EmailSenderJobProcessor();
$emailSenderJobProcessor->process(new SendEmailJob()); // OK

$emailSenderJobProcessor->process(new CreatePdfJob()); // ERROR. Expected SendEmailJob got CreatePdfJob
```

#### Restricting extended/implemented types 
 
As before it is possible to put restrictions on the templated type. E.g. `T` in `JobProcessor` should be restricted to `Job`. 
This is done as before:

```php
/** @template T of Job */
interface JobProcessor {...}

class Person {}

// The following is not allowed as Person is not a Job
/** @implements JobProcessor<Person> */
class PersonProcessor implements JobProcessor {...}
```

###### Examples:
- [tests/docblock/extending_types.php](tests/docblock/extending_types.php)
- [tests/docblock/extending_types_with_restriction.php](tests/docblock/extending_types_with_restriction.php)
- [tests/docblock/extending_types_with_restriction_2.php](tests/docblock/extending_types_with_restriction_2.php)


### Arrays and iterables

> TODO behaviour difference between PHPStan and Psalm. Need to decide correct path to take here. 

#### array and iterable 

Arrays and iterables can have their key and value pairs specified, just as with generics. E.g.

```php
/** 
 * @param iterable<string, Person> $people 
 * @return array<string,Person>
 */
function sortPeople(iterable $people): array {}
```

Short versions that don't specify the type of the key are also allowed:  

```php
/** 
 * @param iterable<Person> $people 
 * @return array<Person>
 */
function sortPeople(iterable $people): array {}
```
In the cases above the type of key is assumed to be `int|string`. This means `array<Person>` is treated as `array<string|int,Person>`.

#### Type[]

A frequently used convention for specifying returning and array of things (e.g. Books) is:

```php
/** @return Book[] */
function getBooks() {...}
```

`Book[]` is the treated as `array<string|int,Book>`

Or more generally:

`T` is the same as `array<string|int,T>`

###### Examples:
- [tests/docblock/arrays.php](tests/docblock/arrays.php)

> TODO lots more test cases needed here

### Array shapes

Support for object like arrays is documented in this way: 

```array{0: string, person: Person, age?: int}```

This means:

- The first item in the array must be of type `string`.
- An entry with the key `person` and value of type `Person` object MUST be supplied.
- An optional entry with key `age` and value of type `int` can also be specified. The `?` after the key name denotes it is optional.

Example

```php
takesArrayShape(['Anna', 'age' => 21, 'person' => new Person()]); // OK - All data provided
takesArrayShape(['Bob',  'person' => new Person()]); // OK - All all mandatory data provided
takesArrayShape([true, 'age' => 21, 'person' => new Person()]); // ERROR: Wrong type for arg 0.
takesArrayShape(['Charlie', 'age' => 22]); // ERROR: Missing 'Person'

/** @param array{0: string, age?:int,  person:Person} $array */
function takesArrayShape(array $array): void {..}
```


###### Examples:
- [tests/docblock/array_shapes.php](tests/docblock/array_shapes.php)



### Generators

Generators can be provided with type information for key, value, send and return types.

The first type is for key. The second for value. Third for send type. Forth for return type.

```php
/** @return Generator<string,Person,bool,int> */
function getPeople(): Generator {...}

foreach(getPeople() as $name => $person) {
    // $name is of type string
    // $person is of type Person
    
    getPeople()->send(true); // Type sent must be of type bool
}

$count = getPeople()->getReturn(); // $count is of type int
```

When providing types either key and value must be provided, or all 4 types must be provided.

###### Examples:
- [tests/docblock/generator_simple.php](tests/docblock/generator_simple.php)
- [tests/docblock/generator_full.php](tests/docblock/generator_full.php)



### Types

> TODO Decide which types MUST be supported

Examples: 
- `array-key` (alias for `string|int`)
- `callable-array` 


See full list from [Psalm](https://psalm.dev/docs/annotating_code/type_syntax/atomic_types/) and [PHPStan](https://phpstan.org/writing-php-code/phpdoc-types).

Remember the scope of this specification is just for generics, need to strike the balance between just supporting generics, 
but also not hindering projects static analysis that has more specialised types (e.g. `numeric`). 
Perhaps a separate specification is needed for aliases? 


### Resolving class names 

When class names are used in generics docblocks the rules for resolving them are the same as they are for normal PHP code. 

```php
namespace Code;

use Entities\Student;

class Room {...}

/** @var array<int,Room> */
$rooms = [];  // Room is defined in same namespace

/** @var array<int,Student> */
$students = [];  // Student is included via use statement

/** @var array<int,\Entities\Subject> */
$subjects = []; // FQCN for Subject is used
```

###### Examples:
- [tests/docblock/namespace.php](tests/docblock/namespace.php)


## Using Attributes instead of docblocks

Attributes can also be used to add the additional information required for generics.
There is already a move to this. For example PHPStorm has [added support](https://blog.jetbrains.com/phpstorm/2020/10/phpstorm-2020-3-eap-4/) Attributes such as `#[Immutable]` and `#[ArrayShape]`.

PHP is in danger of having multiple standards for the same thing.
Psalm's author [thoughts on PHP Attributes for static analysis](https://gist.github.com/muglug/03f63a0e6da1d95d03a014f374e8217d), points to Java where this issue has happened.
Adding additional information for static analysis via attributes will happen. 
It would be better to do this as a single standard. 

Using Attributes has the benefit that multiple versions of the standard can exist. 
This allows a version 1 (compatible with the existing docblock standard) that covers the vast marjority of generics.
The standard can evolve to support more complex generics corner cases once those cases have been identified and a common ground has been reached.

This standard proposed is to use the same standard as docblocks and put the information into attributes. 
Arguments for this method and reasons against are explored in the article [A standard for generics in PHP](https://www.daveliddament.co.uk/articles/php-generics-standard/).

Four Attributes are proposed:

- `#[Template]` [definition](src/Template.php)
- `#[Type]` [definition](src/Type.php)
- `#[Extend]` [definition](src/Extend.php)
- `#[Implement]` [definition](src/Implement.php)

Instead of `@template` docblock use the attribute `#[Template]`.
For additional type information (that appears after `@var`, `@param` or `@return`) use the attribute `#[Type]`.

##### Param
Using `@param` docblock:
```php
/**
 * @param T $item 
 */
public function add(
    $item,
): void { ... }
```

Using an attribute instead of `@param`:

```php
public function add(
    #[Type("T")] $item,
): void { ... }
```
##### Return

Using the `@return` docblock:
```php
/**
  *  @return T 
  */
public function next () { ... }
```

Using an attribute instead of `@return` (NOTE: it's not possible to add an attribute to a return type. However, as a function or method can only have one return type an attribute is attached to the function/method to give information about the return type) :

```php
#[Type("T")] 
public function next() { ... }
```


##### Template
Using the `@template` docblock:
```php
/** @template T */
class Queue { ... } 
```
Same information as an attribute:
```php
#[Template("T")]
class Queue { ... } 
``` 

### Restricting template types in Attributes

The `#[Template]` attribute takes an optional 2nd argument. The restriction of the template is the 2nd argument.

Docblock version:

```php
/** @template T of Animal */
interface AnimalGame { ... }
```

Attribute version:

```php
#[Template("T", "Animal")]
interface AnimalGame { ... }
```




### Array and iterable differences

Make array and iterable keys mandatory. I.e. REMOVE support for shortened versions `T[]`, `array<T>` and `iterable<T>`.

So `#[Type("Person[]")]` must be `#[Type("array<string|int,Person>")]`

And `#[Type("array<Person>")]` must be `#[Type("array<string|int,Person>")]`


### Resolving class names in Attributes


When class names are used in generics attributes the rules for resolving them are the same as they are for normal PHP code.

```php
namespace Code;

use Entities\Student;

class Room {...}

// Room is defined in same namespace
#[Type("array<int,Room>")]   
function getRooms(): array {...}

// Student is included via use statement
#[Type("array<int,Student>")]   
function getStudents(): array {...}

// FQCN for Subject is used
#[Type("array<int,\Entities\Subject>")]   
function getSubjects(): array {...}
```

### Extending/Implementing types in Attributes

`extends` is a reserved word in PHP. An attribute called `extends` is not allowed. Instead use `#[Extend]`.

`implements` is a reserved word in PHP. An attribute called `implements` is not allowed. Instead use `#[Implement]`.


## Further discussion points 

Code samples showing edge cases where PHPStan and Psalm differ. 

- [tests/docblock/edgecase_class_string_templates.php](tests/docblock/edgecase_class_string_templates.php) 


## Tests

Tests provide an essential part of this standard. 
They show a static analyser should interpret code. They also define the correct behaviour for many of the corner cases that appear in generics.

The tests are available under the [tests](tests/) folder.


### Rules for test scripts
Each script under the `tests` folder MUST be analysed on its own.

Each script should focus on one concept. 

Concepts SHOULD have both passing and failing examples. 

Happy path examples MUST have the comment `// OK` (There can be optional additional information as to why the case is valid)
Failing examples MUST have the comment `// ERROR - <description of problem>`

The `// OK` or `// ERROR` comments MUST be on the same line of code. (I.e. it can not be before or after). 
This is so these scripts can be used as automated testing. 

If a line of code has an `// OK` or `// ERROR` comment then it MUST NOT be split over multiple lines. (This is to help with test automation).

To test data is a certain type use a `takesX` function, e.g. `function takesInt(int $value): void`

### Example:

```php
/**
 * @template T
 * @param T $value
 * @return T
 */
function mirror($value)
{
    return $value;
}

function takesString(string $value): void {}
function takesInt(int $value): void {}

$stringValue = mirror("hello");
takesString($stringValue); // OK
takesInt($stringValue); // ERROR. Method expects int, string given
```

NOTE: Warnings/errors that are not applicable to generics MUST be ignored. 
E.g. warnings about unused variables are not relevant to generics, so MUST be ingored.

## Conclusions

There is already a widely used unofficial standard for annotating code to enable static analysis for generics. 
This proposal endorses the existing standard. 
It also proposes 4 Attributes for annotating code with the extra information required for generics.

Acting now to formalise a version 1 of generics will stop multiple tools and vendors implementing the same thing. 
It will provide a standard that all static analysers and libraries can follow. 
This will provide maximum benefit to the PHP ecosystem.


## Feedback

Raise issues or create a PR with proposal for improvements. 

