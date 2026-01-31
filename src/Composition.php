<?php

namespace Slendium\Compositor;

use Traversable;

/**
 * Holds the results and metadata of a composition.
 *
 * @since 1.0
 * @template TComponent of Component
 * @template TOutput
 * @extends Traversable<TOutput>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Composition extends Traversable {

	/**
	 * A list of component classes encountered during composition.
	 * @since 1.0
	 * @var list<class-string<TComponent>>
	 */
	public array $componentClasses { get; }

}
