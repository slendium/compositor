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
  some common web components for the compositor
* [slendium/slendion](https://github.com/slendium/slendion) - a static site generator


## Examples

Work in progress.
