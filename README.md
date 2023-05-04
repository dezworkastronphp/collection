# Collection

[![](https://img.shields.io/packagist/v/astronphp/collection.svg)](https://packagist.org/packages/astronphp/collection)
[![](https://img.shields.io/packagist/dt/astronphp/collection.svg)](https://packagist.org/packages/astronphp/collection)
[![](https://img.shields.io/github/license/astronphp/collection.svg)](https://raw.githubusercontent.com/astronphp/collection/master/LICENSE)
[![](https://img.shields.io/travis/astronphp/collection.svg)](https://travis-ci.org/astronphp/collection)
[![](https://coveralls.io/repos/github/astronphp/collection/badge.svg?branch=master)](https://coveralls.io/github/astronphp/collection)
[![](https://img.shields.io/github/issues/astronphp/collection.svg)](https://github.com/astronphp/collection/issues)
[![](https://img.shields.io/github/contributors/astronphp/collection.svg)](https://github.com/astronphp/collection/graphs/contributors)

## Instalação

``composer require astronphp/collection``

## Guia do Usuário

* [__construct](#construct)
* [unshift](#unshift)
* [push](#push)
* [set](#set)
* [get](#get)
* [isset](#isset)
* [empty](#empty)
* [unset](#unset)
* [length](#length)
* [shift](#shift)
* [pop](#pop)
* [first](#first)
* [last](#last)
* [each](#each)
* [for](#for)
* [walk](#walk)
* [sum](#sum)
* [contains](#contains)
* [map](#map)
* [filter](#filter)
* [reduce](#reduce)
* [join](#join)
* [random](#random)
* [shuffle](#shuffle)
* [flip](#flip)
* [keys](#keys)
* [values](#values)
* [column](#column)
* [chunk](#chunk)
* [unique](#unique)
* [coalesce](#coalesce)
* [merge](#merge)
* [reverse](#reverse)
* [search](#search)
* [lower](#lower)
* [upper](#upper)
* [toArray](#toarray)
* [toJson](#tojson)
* [sort](#sort)
* [rsort](#rsort)
* [asort](#asort)
* [arsort](#arsort)
* [ksort](#ksort)
* [krsort](#krsort)
* [union](#union)
* [diff](#diff)
* [outer](#outer)
* [intersect](#intersect)
* [cartesian](#cartesian)
* [isCollection](#iscollection)
* [combine](#combine)
* [range](#range)

## construct

```php
public function __construct($content = [])
```

Recebe opcionalmente um array ou um objeto, que será convertido internamente.

```php

use Astronphp\Collection\Collection;

$collection1 = new Collection();
$collection2 = new Collection(['lorem' => 'ipsum']);
$collection3 = new Collection(new \DateTime('now'));

var_dump($collection1, $collection2, $collection3);

/*
object(Astronphp\Collection\Collection)[3]
  protected 'content' => array (size = 0)
  protected 'length'  => int 0

object(Astronphp\Collection\Collection)[2]
  protected 'content' => array (size=1)
    'lorem' => string 'ipsum' (length=5)
  protected 'length' => int 1

object(Astronphp\Collection\Collection)[4]
  protected 'content' => array (size=3)
      'date' => string '2019-09-17 14:42:47.000000' (length=26)
      'timezone_type' => int 3
      'timezone' => string 'UTC' (length=3)
  protected 'length' => int 3
*/

```

## unshift

```php
public function unshift(...$values): self
```

Adiciona valores no início da coleção.

```php
use Astronphp\Collection\Collection;

$collection = new Collection();
$collection->unshift('lorem');
$collection->unshift('ipsum', 'dolor');

var_dump($collection);

/*
object(Astronphp\Collection\Collection)[3]
  protected 'content' => 
    array (size=3)
      0 => string 'ipsum' (length=5)
      1 => string 'dolor' (length=5)
      2 => string 'lorem' (length=5)
  protected 'length' => int 3
*/
```

## push

```php
public function push(...$values): self
```

Adiciona valores ao final da coleção.

```php
use Astronphp\Collection\Collection;

$collection = new Collection();
$collection->push('lorem');
$collection->push('ipsum', 'dolor');

var_dump($collection);

/*
object(Astronphp\Collection\Collection)[3]
  protected 'content' => 
    array (size=3)
      0 => string 'lorem' (length=5)
      1 => string 'ipsum' (length=5)
      2 => string 'dolor' (length=5)
  protected 'length' => int 3
*/

```

## set

```php
public function set(string $key, $value): self
```

Associa uma chave à um valor.

```php
use Astronphp\Collection\Collection;

$collection = new Collection();
$collection->set('lorem', 'ipsum');
$collection->set('dolor.amet', 'consectetur');

var_dump($collection);

/*
object(Astronphp\Collection\Collection)[3]
  protected 'content' => 
    array (size=2)
      'lorem' => string 'ipsum' (length=5)
      'dolor' => 
        array (size=1)
          'amet' => string 'consectetur' (length=11)
  protected 'length' => int 2
*/
```

## get

```php
public function get(string $key)
```

Recupera valores da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection();
$collection->set('lorem', 'ipsum');
$collection->set('dolor.amet', 'consectetur');

$collection->get('lorem'); // ipsum
$collection->get('dolor.amet'); // consectetur

```

## isset

```php
public function isset(string $key): bool
```

Verifica chaves não inicializadas ou com valor nulo

```php
use Astronphp\Collection\Collection;

$collection = new Collection();
$collection->set('lorem', 'ipsum');

$collection->isset('lorem'); // true
$collection->isset('dolor'); // false

```

## empty

```php
public function empty(string $key): bool
```

Verifica chaves vazias

```php
use Astronphp\Collection\Collection;

$collection = new Collection();

$collection->set('lorem', 1);
$collection->set('ipsum', 0);

$collection->empty('lorem'); // false
$collection->empty('ipsum'); // true

```

## unset

```php
public function unset(string $key)
```

Remove chaves

```php
use Astronphp\Collection\Collection;

$collection = new Collection();
$collection->set('lorem', 'ipsum');

var_dump($collection);

/*
object(Astronphp\Collection\Collection)[3]
  protected 'content' => 
    array (size=1)
      'lorem' => string 'ipsum' (length=5)
  protected 'length' => int 1
*/

$collection->unset('lorem');

var_dump($collection);

/*
object(Astronphp\Collection\Collection)[3]
  protected 'content' => 
    array (size=0)
      empty
  protected 'length' => int 0
*/

```

## length

```php
public function length(): int
```

Recupera o tamanho da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
$collection->length(); // 5

```

## shift

```php
public function shift()
```

Remove o primeiro elemento da coleção retornando o elemento removido

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
$collection->shift(); // 1

```

## pop

```php
public function pop()
```

Remove o ultimo elemento da coleção retornando o elemento removido

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
$collection->pop(); // 5

```

## first

```php
public function first()
```

Recupera o primeiro item da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
$collection->first(); // 1

```

## last

Recupera o último item da coleção

```php
public function last()
```

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
$collection->last(); // 5

```

## each

```php
public function each(callable $callback)
```

Percorre toda a coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem' => 'ipsum', 'dolor' => 'amet']);
$collection->each(function($key, $value) {
    var_dump($key, $value);
});

/*
string 'lorem' (length=5)
string 'ipsum' (length=5)

string 'dolor' (length=5)
string 'amet' (length=4)
*/

```

## for

```php
public function for(int $start, int $step, callable $callback)
```

Percorre a coleção em passos

```php
use Astronphp\Collection\Collection;

$collection = new Collection([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
$collection->for(0, 2, function($key, $value) {
    var_dump($value);
});

/* int 0, int 2, int 4, int 6, int 8, int 10 */

```

## walk

Percorre a coleção recursivamente

```php
public function walk(callable $callback, $type = \RecursiveIteratorIterator::LEAVES_ONLY)
```

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem', ['ipsum', 'dolor'], ['sit' => ['amet' => 'consectetur']]]);
$collection->walk(function($key, $value) {
    var_dump($key, $value);
});

/*
int 0
string 'lorem' (length=5)
int 0
string 'ipsum' (length=5)
int 1
string 'dolor' (length=5)
string 'amet' (length=4)
string 'consectetur' (length=11)
*/

```

## sum

```php
public function sum()
```

Soma todos os elementos da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
$collection->sum(); // 15

```

## contains

```php
public function contains($value): bool
```

Verifica se um dado valor existe na coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem', 'ipsum', 'dolor']);
$collecion->contains('dolor'); // true

```

## map

```php
public function map(callable $callback): self
```

Aplica um callback em todos os elementos da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem', 'ipsum', 'dolor']);
var_dump($collection->map(function($key, $value) {
    return [$key => strtoupper($value)];
}));

/*
object(Astronphp\Collection\Collection)[4]
  protected 'content' => 
    array (size=3)
      0 => string 'LOREM' (length=5)
      1 => string 'IPSUM' (length=5)
      2 => string 'DOLOR' (length=5)
  protected 'length' => int 3
*/

```

## filter

```php
public function filter(callable $callback): self
```

Filtra a coleção utilizando um callback

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5, 6, 7, 8, 9]);
var_dump($collection->filter(function($key, $value) {
    return $value > 5;
}));

/*
object(Astronphp\Collection\Collection)[4]
  protected 'content' => 
    array (size=4)
      5 => int 6
      6 => int 7
      7 => int 8
      8 => int 9
  protected 'length' => int 4
*/

```

## reduce

```php
public function reduce(callable $callback): self
```

Reduz a coleção a um único valor

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
$result     = $collection->reduce(function($a, $b) {
    return $a + $b;
});

var_dump($result); // int 15

```

## join

```php
public function join(string $glue)
```

Junta os elementos em uma string

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
var_dump($collection->join('-')); // string '1-2-3-4-5'

```

## random

```php
public function random(int $num = 1)
```

Recupera elementos aleatórios da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
$collection->random(); // 3

```

## shuffle

```php
public function shuffle(): self
```

Embaralha os elementos da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
var_dump($collection->shuffle());

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=5)
      0 => int 3
      1 => int 1
      2 => int 5
      3 => int 2
      4 => int 4
  protected 'length' => int 5
*/

```

## flip

```php
public function flip(): self
```

Inverte a relação entre chaves e valores da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem', 'ipsum', 'dolor']);
var_dump($collection->flip());

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=3)
      'lorem' => int 0
      'ipsum' => int 1
      'dolor' => int 2
  protected 'length' => int 3
*/

```

## keys

```php
public function keys(): self
```

Retorna uma coleção apenas com as chaves da coleção anterior

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem' => 'ipsum', 'dolor' => 'amet']);
var_dump($collection->keys());

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=2)
      0 => string 'lorem' (length=5)
      1 => string 'dolor' (length=5)
  protected 'length' => int 2
*/

```

## values

```php
public function values(): self
```

Retorna uma coleção apenas com os valores da coleção anterior

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem' => 'ipsum', 'dolor', 'amet']);
var_dump($collection->values());

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=2)
      0 => string 'ipsum' (length=5)
      1 => string 'amet' (length=4)
  protected 'length' => int 2
*/

```

## column

```php
public function column($key, $index = null)
```

Recupera dados de uma coluna da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
    [
        'lorem' => 'ipsum',
        'dolor' => 'amet',
    ],
    [
        'lorem' => 'dolor',
        'dolor' => 'consectetur',
    ],
]);

var_dump($collection->column('lorem'));

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=2)
      0 => string 'ipsum' (length=5)
      1 => string 'dolor' (length=5)
  protected 'length' => int 2
*/

```

## chunk

```php
public function chunk(int $size, bool $preserve_keys = false): self
```

Divide a coleção em partes iguais

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5, 6, 7, 8, 9]);
var_dump($collection->chunk(3));

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=3)
      0 => 
        array (size=3)
          0 => int 1
          1 => int 2
          2 => int 3
      1 => 
        array (size=3)
          0 => int 4
          1 => int 5
          2 => int 6
      2 => 
        array (size=3)
          0 => int 7
          1 => int 8
          2 => int 9
  protected 'length' => int 3
*/

```

## unique

```php
public function unique(int $flags = SORT_STRING): self
```

Remove duplicatas

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 1, 2, 3, 4, 5, 2, 3, 4]);
var_dump($collection->unique());

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=5)
      0 => int 1
      1 => int 2
      2 => int 3
      6 => int 4
      7 => int 5
  protected 'length' => int 5
*/

```

## coalesce

```php
public function coalesce()
```

Retorna o primeiro valor não nulo encontrado

```php
use Astronphp\Collection\Collection;

$collection = new Collection([null, null, null, 'lorem', null, null]);
var_dump($collection->coalesce()); // string 'lorem'

```

## merge

```php
public function merge();
```

Mescla todas as dimensões da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
    ['lorem' => 'ipsum'],
    ['dolor' => 'sit'],
    ['amet'  => 'consectetur'],
]);

var_dump($collection->merge());

/*
object(Astronphp\Collection\Collection)[4]
  protected 'content' => 
    array (size=3)
      'lorem' => string 'ipsum' (length=5)
      'dolor' => string 'sit' (length=3)
      'amet' => string 'consectetur' (length=11)
  protected 'length' => int 3
*/

```

## reverse

```php
public function reverse($preserve_keys = null): self
```

Inverte a coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
var_dump($collection->reverse());

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=5)
      0 => int 5
      1 => int 4
      2 => int 3
      3 => int 2
      4 => int 1
  protected 'length' => int 5
*/

```

## search

```php
public function search($value, bool $strict = null)
```

Retorna a chave do valor solicitado

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem' => 'ipsum', 'dolor' => 'amet']);
var_dump($collection->search('ipsum')); // 'lorem'

```

## lower

```php
public function lower(): self
```

Transforma recursivamente o case de todas as chaves da coleção para minúsculo

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['Lorem' => 'Ipsum', 'Dolor' => 'Amet']);
var_dump($collection->upper());

/*
object(Astronphp\Collection\Collection)[3]
  protected 'content' => 
    array (size=2)
      'LOREM' => string 'Ipsum' (length=5)
      'DOLOR' => string 'Amet' (length=4)
  protected 'length' => int 2
*/

```

## upper

```php
public function upper(): self
```

Transforma recursivamente o case de todas as chaves da coleção para maiúsculo

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['Lorem' => 'Ipsum', 'Dolor' => 'Amet']);
var_dump($collection->lower());

/*
object(Astronphp\Collection\Collection)[3]
  protected 'content' => 
    array (size=2)
      'lorem' => string 'Ipsum' (length=5)
      'dolor' => string 'Amet' (length=4)
  protected 'length' => int 2
*/

```

## toArray

```php
public function toArray()
```

Recupera o array interno da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([1, 2, 3, 4, 5]);
var_dump($collection->toArray());

/*
array (size=5)
  0 => int 1
  1 => int 2
  2 => int 3
  3 => int 4
  4 => int 5
*/

```

## toJson

```php
public function toJson()
```

Retorna o conteúdo da coleção em uma string JSON

```php
use Astronphp\Collection\Collection;

$collection = new Collection(['lorem' => 'ipsum', 'dolor' => 'amet']);
var_dump($collection->toJson()); // string '{"lorem":"ipsum","dolor":"amet"}'

```

## sort

```php
public function sort()
```

Ordena os valores da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([3, 4, 8, 7, 1, 5]);
$collection->sort(); //[1,3,4,5,7,8]

```

## rsort

```php
public function rsort()
```

Ordena os valores da coleção em ordem inversa

```php
use Astronphp\Collection\Collection;

$collection = new Collection([3, 4, 8, 7, 1, 5]);
$collection->rsort(); //[8,7,5,4,3,1]

```

## asort

```php
public function asort()
```

Ordena os valores da coleção mantendo a associação

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
    'lorem' => 'ipsum',
    'dolor' => 'amet',
    'sit' => 'consectetur'
]);
$collection->asort(); //["dolor" => "amet","sit" => "consectetur","lorem" => "ipsum"]

```

## arsort

```php
public function arsort()
```

Ordena os valores da coleção em ordem inversa mantendo a associação

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
    'lorem' => 'ipsum',
    'dolor' => 'amet',
    'sit' => 'consectetur'
]);
$collection->arsort(); // ["lorem" => "ipsum","sit" => "consectetur","dolor" => "amet"]

```

## ksort

```php
public function ksort()
```

Ordena os valores da coleção pelas chaves

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
    'lorem' => 'ipsum',
    'dolor' => 'amet',
    'sit' => 'consectetur'
]);
$collection->ksort(); //["dolor" => "amet","lorem" => "ipsum","sit" => "consectetur"]

```

## krsort

```php
public function krsort()
```

Ordena os valores da coleção pelas chaves em ordem inversa

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
    'lorem' => 'ipsum',
    'dolor' => 'amet',
    'sit' => 'consectetur'
]);
$collection->krsort(); //["sit" => "consectetur","lorem" => "ipsum","dolor" => "amet"]

```

## union

```php
public function union()
```

Realiza a união entre todos os conjuntos da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
    [1, 2, 3],
    [3, 4, 5],
]);

$collection->union(); // [1, 2, 3, 4, 5]

```

## diff

```php
public function diff()
```

Realiza a diferença entre todos os conjuntos da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
   [1, 2, 3],
   [3, 4, 5],
]);

$collection->diff(); // [1, 2]

$collection = new Collection([
   [3, 4, 5],
   [1, 2, 3],
]);


```

## outer

```php
public function outer()
```

Realiza a diferença total entre conjuntos

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
   [1, 2, 3],
   [3, 4, 5],
]);

$collection->outer(); // [[1, 2], [4, 5]]

```

## intersect

```php
public function intersect()
```

Realiza a intersecção entre todos os conjuntos da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
   [1, 2, 3, 4],
   [3, 4, 5, 6],
]);

$collection->intersect(); // [3, 4]

```

## cartesian

```php
public function cartesian()
```

Realiza o produto cartesiano entre todos os conjuntos da coleção

```php
use Astronphp\Collection\Collection;

$collection = new Collection([
   [1, 2, 3],
   [3, 4, 5],
]);

$collection->cartesian(); // [[1,3], [1,4], [1,5], [2,3], [2,4], [2,5], [3,3], [3,4], [3,5]]

```

## isCollection

```php
public static function isCollection(): bool
```

```php
use Astronphp\Collection\Collection;

Collection::isCollection(new Collection()); // true

Collection::isCollection(10); // false

```

## combine

```php
public function combine(): self
```

```php
use Astronphp\Collection\Collection;

$array = ['lorem', 'ipsum', 'dolor'];

$collection = new Collection([1, 2, 3]);

var_dump(Collection::combine($array, $collection));

/*
object(Astronphp\Collection\Collection)[2]
  protected 'content' => 
    array (size=3)
      'lorem' => int 1
      'ipsum' => int 2
      'dolor' => int 3
  protected 'length' => int 3
*/

```

## range

```php
public static function range($start, $end, $step = 1): self
```

```php
use Astronphp\Collection\Collection;

Collection::range($start = 10, $end = 20, $step = 2); // [10, 12, 14, 16, 18, 20] 

Collection::range($start = 'A', $end = 'F'); // ["A", "B", "C", "D", "E", "F"]
```
