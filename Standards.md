# Trackr Code Quality Standards
## Function & Variables names:
*  Must have an underscore(_) between each word
  * Correct Examples: $example_variable, $another_variable, example_function(), another_example()
  * Incorrect Examples: $exampleVariable,  $examplevariable, ExampleFunction(), exampleFunction()
* Must be all lower-case characters unless using an abbreviation
  * Correct Examples: $example_variable, $another_variable, correct_example(), correct_PHP()
  * Incorrect Examples: $Example_Variable,  $EXAMPLE_VARIABLE, incorrect_Example()

## Arrays:
* When initializing/insert values of arrays that use a Key => Value pair, and you're initialize it with/inserting multiple values you must put each Key => Value pair on a seperate line. If you're only inserting/initializing one value then the Key => Value pair may be placed on the same line you create array or set the value.
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

##General Style
* Do not  place spaces before or after the concatenation operator(".")
* Place a space before and after the concatenating assignment operator(".=")
* Always use the clean_input() method on user provided values