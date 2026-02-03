<?php

namespace Slendium\Compositor\Base;

use IteratorAggregate;
use Override;
use Traversable;

use Slendium\Compositor\Component;
use Slendium\Compositor\Base\CompositorAdapter;

/**
 * Provides metadata about a completed composition.
 *
 * @since 1.0
 * @template TComponent of Component
 * @template TPart
 * @template TOutput
 * @extends BaseComposition<TComponent,TOutput>
 * @implements IteratorAggregate<TOutput>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class PartialComposition extends BaseComposition implements IteratorAggregate {

	#[Override]
	public function getIterator(): Traversable {
		foreach ($this->parts as $part) {
			yield from $this->adapter->generateOutput($part);
		}
	}

	/**
	 * @since 1.0
	 * @param list<class-string<TComponent>> $componentClasses
	 */
	public function __construct(

		array $componentClasses,

		/**
		 * @since 1.0
		 * @var list<TPart>
		 */
		private readonly array $parts,

		/**
		 * @since 1.0
		 * @template TPart
		 * @var CompositorAdapter<TComponent,TPart,TOutput> $adapter
		 */
		private readonly CompositorAdapter $adapter,

	) {
		parent::__construct($componentClasses);
	}

}
