<?php

namespace Astronphp\Collection;

use Astronphp\Collection\ObjectParser;

use Astronphp\Collection\Interfaces\Set;
use Astronphp\Collection\Interfaces\Sortable;

class Collection implements \Countable, Sortable, Set
{
    use \Astronphp\Collection\Traits\SetTrait;
    use \Astronphp\Collection\Traits\SortableTrait;

    const COLLECTION_TO_ARRAY = 0;
    const ARRAY_TO_COLLECTION = 1;

    protected $content;
    protected $length;

    /**
     * @param  mixed $content
     *
     * @return void
     */
    public function __construct($content = [])
    {
        $this->content = $this->construct($content);
        $this->count();
    }
  
    /**
     * Parse the __construct argument received
     *
     * @param  mixed $content
     *
     * @return array
     */
    private function construct($content): array {
        if ($content instanceof static) {
            return $content->toArray();
        }
  
        if (is_object($content)) {
            $parser = new ObjectParser($content);
            return $parser->parse();
        }
  
        if (is_array($content)) {
            return static::check($content);
        }
  
        throw new \InvalidArgumentException('Invalid Type: Argument must be an array or object.');
    }

    /**
     * Set the content of the array by reference
     *
     * @param  array $array
     *
     * @return self
     */
    public function setByReference(array &$array = null): self
    {
        $array = $array ?? [];
        $this->content =& $array;
        $this->count();
        return $this;
    }

    /**
     * Count all elements of the collection
     * 
     * @param int $mode
     *
     * @return int
     */
    public function count(int $mode = COUNT_NORMAL): int
    {
        if ($mode === COUNT_RECURSIVE) {
            return count($this->content, COUNT_RECURSIVE);
        }

        $this->length = count($this->content);
        return $this->length;
    }

    /**
     * Insert the values on the beginning of the collection
     *
     * @param  mixed $values
     *
     * @return self
     */
    public function unshift(...$values): self
    {
        array_unshift($this->content, ...static::check($values));
        $this->increment(count($values));
        return $this;
    }

    /**
     * Insert the values on the final of the collection
     *
     * @param  mixed $values
     *
     * @return self
     */
    public function push(...$values): self
    {
        array_push($this->content, ...static::check($values));
        $this->increment(count($values));
        return $this;
    }

    /**
     * Perform a simplified for loop
     *
     * @param  int      $i
     * @param  int      $add
     * @param  callable $callback
     * @param  int      $mode
     *
     * @return void
     */
    public function for(int $i, int $add, callable $callback)
    {
        $keys   = array_keys($this->content);
        $count  = count($this->content);

        for ($i; ($add >= 0 ? $i < $count : $i >= 0); $i += $add) {
            $value = $this->return($this->content[$keys[$i]]);
            $callback($keys[$i], $value);
        }
    }

    /**
     * Perform a foreach loop
     *
     * @param  callable $callback
     * @param  int      $mode
     *
     * @return void
     */
    public function each(callable $callback)
    {
        foreach ($this->content as $key => $value) {
            $value = $this->return($value);
            $callback($key, $value);
        }
    }

    /**
     * Apply a callback in all elements of the collection
     *
     * @param  callable $callback
     * @param  int      $type
     * @param  int      $mode
     *
     * @return void
     */
    public function walk(callable $callback, $type = \RecursiveIteratorIterator::LEAVES_ONLY)
    {
        $iterator = new \RecursiveArrayIterator($this->content);
        foreach (new \RecursiveIteratorIterator($iterator, $type) as $key => $value) {
            $value = $this->return($value);
            $callback($key, $value);
        }
    }

    /**
     * Sum all values in the collection
     *
     * @return mixed
     */
    public function sum()
    {
        return array_sum($this->content);
    }

    /**
     * Check if the value exist in the collection
     * 
     * @param mixed $value
     *
     * @return bool
     */
    public function contains($value): bool
    {
        return in_array(static::parse($value), $this->content);
    }

    /**
     * Applies the callback to all elements
     *
     * @param  callable $callback
     * @param  int      $mode
     *
     * @return self
     */
    public function map(callable $callback): self
    {
        $return = [];
        foreach ($this->content as $key => $value) {
            $value  = $this->return($value);
            $result = $callback($key, $value);
            $value  = reset($result);
            $return[key($result)] = is_array($value) ? static::check($value) : static::parse($value);
        }
        return $this->return($return);
    }

    /**
     * Filter the collection using a callable function
     *
     * @param  callable $callback
     * @param  int      $mode
     *
     * @return self
     */
    public function filter(callable $callback): self
    {
        $return = [];
        foreach ($this->content as $key => $value) {
            $value = $this->return($value);
            if ($callback($key, $value)) {
                $return[$key] = $value;
            }
        }
        return $this->return($return);
    }

    /**
     * Reduce the collection to a single value
     *
     * @param  callable $callback
     * @param  int      $mode
     *
     * @return self
     */
    public function reduce(callable $callback)
    {
        $content  = $this->content;
        $previous = array_shift($content);
        while ($next = array_shift($content)) {
            $previous = $this->return($previous);
            $next     = $this->return($next);
            $previous = $callback($previous, $next);
        }
        return $this->return($previous);
    }

    /**
     * Remove the first element from the collection, and return the removed value
     *
     * @return mixed
     */
    public function shift()
    {
        $this->decrement();
        return $this->return(array_shift($this->content));
    }

    /**
     * Remove the last element from the collection, and return the removed value
     *
     * @return mixed
     */
    public function pop()
    {
        $this->decrement();
        return $this->return(array_pop($this->content));
    }

    /**
     * Join collection's elements into string
     *
     * @return string
     */
    public function join(string $glue)
    {
        return implode($glue, $this->content);
    }

    /**
     * Get a random element of the array
     *
     * @param int $num
     */
    public function random(int $num = 1)
    {
        return $this->return($this->get(array_rand($this->content, $num)));
    }

    /**
     * Shuffle the array
     * 
     * @return self
     */
    public function shuffle(): self
    {
        $content = $this->content;
        shuffle($content);
        return $this->return($content);
    }

    /**
     * Exchange all keys with their associated values
     *
     * @return self
     */
    public function flip(): self
    {
        return $this->return(array_flip($this->content));
    }

    /**
     * Return a object with all the keys of the collection
     *
     * @return self
     */
    public function keys(): self
    {
        return $this->return(array_keys($this->content));
    }

    /**
     * Return a object with all the values of the collection
     *
     * @return self
     */
    public function values(): self
    {
        return $this->return(array_values($this->content));
    }

    /**
     * Return the values from a single column
     *
     * @param  mixed $key
     * @param  mixed $index
     *
     * @return self
     */
    public function column($key, $index = null)
    {
        return $this->return(array_column($this->content, $key, $index));
    }
    
    /**
     * Split the collection into parts
     *
     * @param  int $size
     * @param  bool $preserve_keys
     *
     * @return self
     */
    public function chunk(int $size, bool $preserve_keys = false): self
    {
        return $this->return(array_chunk($this->content, $size, $preserve_keys));
    }

    /**
     * Remove duplicated values
     *
     * @return self
     */
    public function unique(int $flags = SORT_STRING): self
    {
        return $this->return(array_unique($this->content, $flags));
    }

    /**
     * Return the first non null value
     *
     * @return mixed
     */
    public function coalesce()
    {
        foreach ($this->content as $value) {
            if (!is_null($value)) {
                return $this->return($value);
            }
        }
        return null;
    }

    /**
     * Merge all sublevels of the collection into one
     *
     * @return self
     */
    public function merge(): self
    {
        return $this->reduce(function($a, $b) {
            return array_merge($a->toArray(), $b->toArray());
        });
    }

    /**
     * Reverse the order of the collection
     *
     * @return self
     */
    public function reverse($preserve_keys = null): self
    {
        return $this->return(array_reverse($this->content, $preserve_keys));
    }

    /**
     * Return a key from a value in collection if it exists
     */
    public function search($value, bool $strict = null)
    {
        return array_search(static::parse($value), $this->content, $strict);
    }

    /**
     * Return the first element of the collection
     *
     * @return void
     */
    public function first()
    {
        return $this->return(reset($this->content));
    }

    /**
     * Return the last element of the collection
     *
     * @return void
     */
    public function last()
    {
        return $this->return(end($this->content));
    }

    /**
     * Change the case of all keys in the collection to lower case
     *
     * @return self
     */
    public function lower(): self
    {
        $lower = function(&$array) use (&$lower) {
            $array = array_change_key_case($array, CASE_LOWER);
            foreach ($array as $key => $value)
                if (is_array($value)) $lower($array[$key]);
        };
        $lower($this->content);
        return $this;
    }

    /**
     * Change the case of all keys in the collection to upper case
     *
     * @return self
     */
    public function upper(): self
    {
        $upper = function(&$array) use (&$upper) {
            $array = array_change_key_case($array, CASE_UPPER);
            foreach ($array as $key => $value)
                if (is_array($value)) $upper($array[$key]);
        };
        $upper($this->content);
        return $this;
    }

    /**
     * Get the value associated a given key or keys
     *
     * @param  mixed $keys
     *
     * @return mixed
     */
    public function get(string $key)
    {
        if (!$this->isset($key)) { return null; }
        $keys = explode('.', $key);
        $element =& $this->content;
        while (count($keys) > 0) {
            $element =& $element[array_shift($keys)];
        }
        return $this->return($element);
    }

    /**
     * Insert a value in a associated key
     *
     * @param  string $key
     * $param  mixed $value
     *
     * @return mixed
     */
    public function set(string $key, $value): self
    {
        $keys = explode('.', $key);
        $element  =& $this->content;
        while (count($keys) > 0) {
            $element =& $element[array_shift($keys)];
        }
        $element = is_array($value) ? static::check($value) : static::parse($value);
        $this->increment();
        return $this;
    }

     /**
     * Determine if a key is set and it's value is not null
     *
     * @param  mixed $key
     *
     * @return bool
     */
    public function isset($key): bool
    {
        $keys = explode('.', $key);
        $element  =& $this->content;
        while (count($keys) > 0) {
            if (!isset($element[$keys[0]])) {
                return false;
            }
            $element =& $element[array_shift($keys)];
        }
        return isset($element);
    }

    /**
     * Determine wheter a position in collection is empty
     *
     * @param  mixed $key
     *
     * @return bool
     */
    public function empty($key): bool
    {
        $keys = explode('.', $key);
        $element  =& $this->content;
        while (count($keys) > 0) {
            if (empty($element[$keys[0]])) {
                return true;
            }
            $element =& $element[array_shift($keys)];
        }
        return empty($element);
    }

    /**
     * Unset a given position of the collection
     *
     * @param  mixed $key
     *
     * @return void
     */
    public function unset($key)
    {
        $keys = explode('.', $key);
        $element  =& $this->content;
        while (count($keys) > 1) {
            if (!isset($element[$keys[0]])) {
                return false;
            }
            $element =& $element[array_shift($keys)];
        }
        unset($element[$keys[0]]);
        $this->decrement();
    }

    /**
     * Return the length of the collection
     *
     * @return array
     */
    public function length(): int
    {
        return $this->length;
    }

    /**
     * Return the internal content of the collection
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->content;
    }

    /**
     * Return the json string of the collection
     *
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode($this->content, $options);
    }

    /**
     * Return a new object if value is an object, else return the value
     *
     * @return mixed
     */
    protected function return($content)
    {
        return static::parse($content, self::ARRAY_TO_COLLECTION);
    }

    /**
     * Increment the length property
     *
     * @return void
     */
    private function increment(int $value = 1)
    {
        $this->length += $value;
    }

    /**
     * Decrement the length property
     *
     * @return void
     */
    private function decrement(int $value = 1)
    {
        $this->length -= $value;
    }

    // ================================================================= //
    // ======================= STATIC METHODS =========================== //
    // ================================================================= //

    /**
     * Verify whether a element is an Collection object
     *
     * @param  mixed $object
     *
     * @return bool
    */
    public static function isCollection($object): bool
    {
        return $object instanceof static;
    }

    /**
     * Combine two collections, using the first for keys and the second for values
     *
     * @param  mixed $keys
     * @param  mixed $values
     *
     * @return self
     */
    public static function combine($keys, $values): self
    {
        return new static(array_combine(static::parse($keys), static::parse($values)));
    }

     /**
     * Create a collection, containing a range of elements
     *
     * @param  mixed $start
     * @param  mixed $end
     * @param  int   $step
     *
     * @return self
     */
    public static function range($start, $end, $step = 1): self
    {
        return new static(range($start, $end, $step));
    }

   /**
    * Check all elements in an array and when it is a Collection, get its internal value
    *
    * @param  array $content
    *
    * @return array
    */
    private static function check(array $content): array
    {
        foreach ($content as $key => $value) {
            $content[$key] = is_array($value) ? static::check($value) : static::parse($value);
        }
        return $content;
    }

    /**
    * Parse a value according with the received mode
    *
    * @param  mixed $value
    *
    * @return mixed
    */
    private static function parse($value, int $mode = self::COLLECTION_TO_ARRAY)
    {
         if ($mode === self::ARRAY_TO_COLLECTION) {
             return is_array($value) ? new static($value) : $value;
         }
 
         if ($mode === self::COLLECTION_TO_ARRAY) {
             return $value instanceof static ? $value->toArray() : $value;
         }
 
        return $value;
    }
}
