<?php

namespace Slendium\Compositor\Base;

use Exception;
use Override;

use Slendium\Localization\Localizable;

use Slendium\Compositor\Component;
use Slendium\Compositor\Composition;
use Slendium\Compositor\Compositor;
use Slendium\Compositor\Replaceable;

/**
 * A compositor that generates the result in two phases, allowing the intermediate results to be
 * analyzed and optimized.
 *
 * @since 1.0
 * @template TComponent of Component
 * @template TIntermediate
 * @template TOutput
 * @implements Compositor<TComponent,PartialComposition<TOutput>>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class TwoPhaseCompositor implements Compositor {

	/** @since 1.0 */
	const DEFAULT_MAX_DEPTH = 512;

	/** @var array<class-string<TComponent>,true> */
	private array $componentClasses;

	/** @return PartialComposition<TComponent,TIntermediate,TOutput> */
	#[Override]
	public function compose(Component $root): PartialComposition {
		$this->componentClasses = [ ];
		$partialTree = \iterator_to_array($this->unwindTree($root, 0), preserve_keys: false);
		return new PartialComposition(
			componentClasses: \array_keys($this->componentClasses),
			parts: $partialTree,
			adapter: $this->adapter,
		);
	}

	/** @since 1.0 */
	public function __construct(

		/** @var CompositorAdapter<TComponent,TIntermediate,TOutput> */
		private CompositorAdapter $adapter,

		/** @var int<0,max> */
		private int $maxDepth = self::DEFAULT_MAX_DEPTH,

	) { }

	/**
	 * @param TComponent $component
	 * @return iterable<TIntermediate>
	 */
	private function unwindTree(Component $component, int $depth): iterable {
		if ($depth >= $this->maxDepth) {
			yield from $this->adapter->composeException(new Exception('Maximum depth reached'));
			return;
		}

		$this->componentClasses[\get_class($component)] = true;
		foreach ($this->adapter->composeComponent($component) as $part) {
			if ($part instanceof Component) {
				yield from $this->unwindTree($part, $depth + 1); // @phpstan-ignore argument.type (part will always be TComponent)
			} else {
				yield $part;
			}
		}
	}

}
