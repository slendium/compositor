# Slendium Compositor

A framework-agnostic PHP library for generating (hyper)text documents from a component tree.

* PHPDoc type annotations for static analyzers with a clear distinction between literal and non-literal
  strings, the latter of which are automatically escaped
* Two-phase mechanism: expensive operations can be aggregated before the (hyper)text is generated
* Composition-based, does not depend on inheritance or on global state
* Track the resources (JS/CSS) needed for the components used
* Reusability of components

## Installation

Requires **PHP >= 8.5**. Simply run `composer install slendium/compositor` to add the base functionality
to your project. See also:

* [slendium/common-components](https://github.com/slendium/common-components) - a package that defines
  some common HTML components for the compositor
* [slendium/slendium-static](https://github.com/slendium/slendium-static) - a static site generator


## Examples

### Basic example

The example is a bit contrived (in real world code a component would be designed differently), but
it shows how components only need to declare what to display in two cases (object found or not found)
and don't need to know about database queries or caches. Additionally it shows how the entire tree
can be generated dynamically without requiring complex initialization to ensure all objects are present.

```php
// a component that displays the name property of an object that has to be requested from the database
class ObjectNameComponent implements Component {

	public function __construct(public string $id) { }

	#[Override]
	public function composeHtml(): iterable {
		yield '<div>';
		yield new DatabaseObjectCallback(requestedId: $this->id, callback: function (?object $object) {
			if ($object !== null) {
				yield from [ '<span>', new Icon('my_icon'), $object->name, '</span>' ];
			} else {
				yield '<span class="error">Object not found!<span>';
			}
		});
		yield '</div>';
	}

}

// in practice this would be a framework service or something similar
$objectProvider = get_object_provider();

// set up the HTML compositor, use two-phase to allow optimization of the intermediate representation
// a further optimization would be to ensure objects with different ID's are all requested in a single query
$compositor = CompositorFactory::twoPhase(new class($objectProvider) implements ReplacementProvider {

	/** @var array<string,?object> */
	private array $objectCache = [ ];

	public function __construct(public ObjectProvider $objectProvider) { }

	#[Override]
	public function replace(Localizable|Replaceable|Error $part): iterable {
		if ($part instanceof DatabaseObjectCallback) {
			if (!\array_key_exists($this->objectCache, $part->requestedId)) {
				$this->objectCache[$part->requestedId] = $this->objectProvider->request($part->requestedId);
			}
			return $part->evaluate($this->objectCache[$part->requestedId]);
		}
		return null;
	}

});

// create the tree of components: both components would yield a DatabaseObjectCallback where the first
// instance would trigger a query and the second would reuse the cached object
$tree = new Container([ new ObjectNameComponent('1'), new ObjectDescriptionComponent('1') ]);

// compose the tree
$composition = $compositor->compose($tree);

// if desired, JS and CSS can be generated dynamically based on the components actually in the tree
// more commonly the JS and CSS are included using fixed links in the <head> section
$libraries = $composition->generateLibraries();
echo '<script>', generate_javascript($libraries), '</script>';
echo '<style>', generate_css($libraries), '</script>';

// output the HTML
foreach ($composition as $htmlPart) {
	echo $htmlPart;
}
```
