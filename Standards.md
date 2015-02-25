# Trackr Code Quality Standards
## Why?
The Trackr Code Quality Standards were created to establish code format rules for contributors to follow when making changes and/or additions to Trackr. These rules are in place to prevent the individual contributors from using their own development style and ultimately making the Trackr source a mess of different styles thrown together.

## Function & Variables names:
*  Must have an underscore(_) between each word
  * Correct Examples: $example_variable, $another_variable, example_function(), another_example()
  * Incorrect Examples: $exampleVariable,  $examplevariable, ExampleFunction(), exampleFunction()
* Must be all lower-case characters unless using an abbreviation
  * Correct Examples: $example_variable, $another_variable, correct_example(), correct_PHP()
  * Incorrect Examples: $Example_Variable,  $EXAMPLE_VARIABLE, incorrect_Example()

## Arrays:
* When initializing/insert values of arrays that use a Key => Value pair, and you're initialize it with/inserting multiple values you must put each Key => Value pair on a separate line. If you're only inserting/initializing one value then the Key => Value pair may be placed on the same line you create the array or set the value.
  * Correct Examples:
  ```php
  $example_array = array(
      'Key' => 'Value',
      'SecondKey' => 'SecondValue',
  );
  $example_array['example'] = array(
      'NewKey' => 'Example',
      'KeyTest' => 'Test',
  );
  $example_array = array('Key' => 'Value');
  $example_array['NewKey'] = array('Test' => 'Value');
  ```

## Files:
* Files must not contain any redundant closing tags

## Classes & Class Files:
* Class files must contain just one class per file

## Class & Class File names:
* Class files must use the same name as the class they contain
  * Correct Examples: ExampleClass in ExampleClass.php, Group in Group.php, AnotherExampleClass in AnotherExampleClass.php
  * Incorrect Examples: exampleClass in Example.php, group in Group.php, AnotherexampleClass in anotherexampleclass.php
* Class names must be in upper camel case.
  * Correct Examples: ExampleClass, Group, AnotherExampleClass
  * Incorrect Examples: exampleClass, group, AnotherexampleClass
  
## Methods/Operators to use
* Do NOT use deprecated methods
* Use instanceof instead of is_a()
  * Correct Examples:
  ```php
  if($variable instanceof Class) {
      //Do something
  }
  if(!($variable instanceof Class)) {
      //Do something
  }
  ```
  * Incorrect Examples:
  ```php
  if(is_a($variable, 'Class')) {
      //Do something
  }
  if(!is_a($variable, 'Class')) {
      //Do something
  }
  ```

##Trackr Unused & Deprecated Functions
* Any unused functions should be marked as deprecated using a PHPDoc Comment with the @deprecated tag.
* Deprecated methods shall be removed after being deprecated for a no more and no less than one Trackr release.
* In the event that majority of the Trackr users would like a deprecated method to stay;
  * It may be unmarked as deprecated,
  * or it may stay in the Trackr source longer than one release.
  * *The choice is entirely up to the discretion of the core Trackr developers.*

##General Style
* Indentation should be done with four spaces, not tabs.
* Do not  place spaces before or after the concatenation operator(".")
* Place a space before and after the concatenating assignment operator(".=")
* Always use the clean_input() method on user provided values
* Always use PHP_EOL instead of specifying a line separator

##Last Modified
The Trackr Code Quality Standards were last modified on February 25th, 2015.