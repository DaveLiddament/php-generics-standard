# PHP Generics specification (using Attributes)

Developers might think that documenting the additional metadata required for generics should live in [Attributes](https://www.php.net/manual/en/language.attributes.overview.php) instead of a docblock.
The documentation for attributes opens with this statement: 

> Attributes allow to add structured, machine-readable metadata information on declarations in code

The metadata in an attribute is available:
- via reflection at run time (not relevant for static analysis)
- in the AST (use case for static anlaysers)

This section has been included to propose a how attributes could be used for generics. 

Points to consider:

- Not currently supported
- Static analysis tool maintainers and vendors may have little desire to support this. (Initial feedback to the attributes proposal is not favourable.)
- Is this actually better than the docblock version? 
  
That said if there is a desire to use attributes it might be the best method, other suggestions are examined [here](https://www.daveliddament.co.uk/articles/php-generics-standard/).

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

[More examples](example/attributes.php) of using Attributes.

## Using Attributes instead of docblocks

There is already a move to use Attributes for metadata used by static analysers. For example PHPStorm has [added support](https://blog.jetbrains.com/phpstorm/2020/10/phpstorm-2020-3-eap-4/) Attributes such as `#[Immutable]` and `#[ArrayShape]`.

PHP is in danger of having multiple standards for the same thing.
Psalm's author [thoughts on PHP Attributes for static analysis](https://gist.github.com/muglug/03f63a0e6da1d95d03a014f374e8217d), points to Java where this issue has happened.
Adding additional information for static analysis via attributes will happen. 
It would be better to do this as a single standard. 

Using Attributes has the benefit that multiple versions of the standard can exist. 
This allows a version 1 (compatible with the existing docblock standard) that covers the vast majority of generics.
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


## Feedback

Raise issues or create a PR with proposal for improvements. 

