# StubZero
The generation of object wrappers for fast creation of prototype objects-models with fill data by type.

### In progress


### Usage 
* For model classes only

#### For example auto generate User model
```php
$t = Generator::create(User::class);

var_dump($t);
```

```sh
stubzero git:(master) ✗ php -q example.php
object(test\data\User)#4 (7) {
  ["name":"test\data\User":private]=>
  string(12) "Daniella Orn"
  ["tel":"test\data\User":private]=>
  string(150) "Molestias alias officiis officia iusto sit aut. Aut soluta ut est nulla ut explicabo dignissimos. Et soluta a dolor laboriosam aliquid illum deserunt."
  ["email":"test\data\User":private]=>
  string(24) "allison.ernser@gmail.com"
  ["verifyNum":"test\data\User":private]=>
  string(19) "723-630-1828 x96255"
  ["status":"test\data\User":private]=>
  string(4) "nemo"
  ["updateStatus":"test\data\User":private]=>
  string(36) "3911ccbb-02ba-3def-9dd2-1ad9982aa70b"
  ["places":"test\data\User":private]=>
  array(11) {
    [0]=>
    string(2) "et"
    [1]=>
    string(5) "animi"
    [2]=>
    string(4) "odit"
    [3]=>
    string(3) "sed"
    [4]=>
    string(5) "ullam"
    [5]=>
    string(3) "qui"
    [6]=>
    string(2) "ad"
    [7]=>
    string(4) "quam"
    [8]=>
    string(10) "voluptatum"
    [9]=>
    string(5) "porro"
    [10]=>
    string(4) "iure"
  }
}

```
