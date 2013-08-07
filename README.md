##Polyglot Template Test

Tests written in a Polyglot format so that cross platform templating languages can be tested across different language implementations without the need to rewrite as many tests and hopefully create consistency between languages. This will make users and designers comfortable with working and interacting across different backend platforms.

####Current Supported Languages and Libraries
- Liquid (Partial)
   - Liquid (https://github.com/Shopify/liquid) [Ruby]
   - php-liquid (https://github.com/harrydeluxe/php-liquid) [PHP]
   - liquid-node (https://github.com/sirlantis/liquid-node) [Javascript]
   - Swig (https://github.com/paularmstPolygotrong/swig) [Javascript]
   - Twig (https://github.com/fabpot/Twig) [PHP]
   
            


##Results - 8th August 2013

Below is the table of results from each library test against the polyglot test files. For specific failures please run the tests locally.


<table>
  <tr>
    <th>Project</th>
    <th>Language</th>
    <th>Test</th>
    <th>Pass</th>
    <th>Fail</th>
    <th>Coverage</th>
  </tr>
  <tr>
    <td>Liquid</td>
    <td>Ruby</td>
    <td>Liquid</td>
    <td>56</td>
    <td>0</td>
    <td>100%</td>
  </tr>
  <tr>
    <td>php-liquid</td>
    <td>PHP</td>
    <td>Liquid</td>
    <td>31</td>
    <td>25</td>
    <td>55%</td>
  </tr>
  <tr>
    <td>liquid-node</td>
    <td>Javascript</td>
    <td>Liquid</td>
    <td>18</td>
    <td>38</td>
    <td>32%</td>
  </tr>
  <tr>
    <td>Swig</td>
    <td>Javascript</td>
    <td>Liquid</td>
    <td>14</td>
    <td>42</td>
    <td>25%</td>
  </tr>
  <tr>
    <td>Twig</td>
    <td>PHP</td>
    <td>Liquid</td>
    <td>17</td>
    <td>39</td>
    <td>30%</td>
  </tr>
</table>

##TO DO

### Liquid

- ~~Implement Loader for Liquid (Ruby)~~
- ~~Implement Loader for php-liquid~~
- ~~Implement Loader for liquid-node~~
- ~~Implement Loader for Swig~~
- ~~Implement Loader for Twig~~
- ~~tags/break_tag_test.rb~~
- ~~tags/continue_tag_test.rb~~
- ~~tags/for_tag_test.rb~~
- tags/html_tag_test.rb
- tags/if_else_tag_test.rb
- tags/include_tag_test.rb
- tags/increment_tag_test.rb
- tags/raw_tag_test.rb
- tags/standard_tag_test.rb
- tags/statements_test.rb
- tags/unless_else_tag_test.rb
- assign_test.rb
- blank_test.rb
- block_test.rb
- capture_test.rb
- condition_test.rb
- context_test.rb
- drop_test.rb
- error_handling_test.rb
- file_system_test.rb
- filter_test.rb
- hash_ordering_test.rb
- module_ex_test.rb
- output_test.rb
- parsing_quirks_test.rb
- regexp_test.rb
- security_test.rb
- standard_filter_test.rb
- strainer_test.rb
- template_test.rb
- variable_test.rb 

### Core

- ~~Find a generic method to run Hash/Object/Array, Template and Output Tests~~
- Find a generic method to handle Exception testing.
- Find a generic method to handle Closures/Anonymous Functions.
- Write Generic Loader Libraries instead of current simple test scripts.
- Bring Test Results in to a Central Application/GUI.
- Report Table should show which syntax is valid/invalid for each implementation.
- Auto Build results page and publish to Github Pages.
- Auto Pull Latest Version of Each Library on Test Run.


### Mustache

- Find Existing Tests and Setup To Do List
- Implement Loader for Mustache.php
- Implement Loader for Mustache.js
- Implement Loader for Mustache (Ruby)
- Implement Loader for Pystache
- Implement Loader for Mustache.erl
- Implement Loader for Template-Mustache (Perl)
- Implement Loader for GRMustache
- Implement Loader for Mustache.java
- Implement Loader for Nustache
- Implement Loader for jMustache
- Implement Loader for Plustache
- Implement Loader for Mustache.go
- Implement Loader for Hige
- Implement Loader for Mustang
- Implement Loader for Mustache.as
- Implement Loader for Mustache.cfc
- Implement Loader for Scalate
- Implement Loader for Clostache
- Implement Loader for Mustache (Fantom)
- Implement Loader for Milk
- Implement Loader for Mustache4d
- Implement Loader for Mu

### Django

- Find Existing Tests and Setup To Do List
- Implement Loader for Django
- Implement Loader for Jinja2
- Implement Loader for Swig
- Implement Loader for Twig
- Implement Loader for Template::Swig
- Implement Loader for Liquid

### Twig

- Find Existing Tests and Setup To Do List
- Implement Loader for Django
- Implement Loader for Jinja2
- Implement Loader for Swig
- Implement Loader for Twig
- Implement Loader for Template::Swig
- Implement Loader for Liquid

