<?php

namespace Slendium\Compositor\Base;

use Override;

use Slendium\Localization\Localizable;
use Slendium\Localization\Localizer;

use Slendium\Compositor\Component;
use Slendium\Compositor\Composition;
use Slendium\Compositor\Compositor;
use Slendium\Compositor\Replaceable;

/**
 * A compositor that generates the result in two phases, allowing the intermediate results to be
 * analyzed and optimized.
 *
 * Components may return {@see Localizable}s, which may contain {@see Replaceable}s, components or
 * parts (but not other Localizables). Replaceables may only be replaced with components or valid
 * parts, not Localizables or Replaceables.
 *
 * @since 1.0
 * @template TComponent of Component
 * @template TPart
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

	/** @return PartialComposition<TComponent,TPart,TOutput> */
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

		/** @var CompositorAdapter<TComponent,TPart,TOutput> */
		private CompositorAdapter $adapter,

		/** @var ReplacementProvider<TComponent,TPart> */
		private ReplacementProvider $replacementProvider,

		private Localizer $localizer,

		/** @var int<0,max> */
		private int $maxDepth = self::DEFAULT_MAX_DEPTH,

	) { }

	/**
	 * @param TComponent $component
	 * @return iterable<TPart>
	 */
	private function unwindTree(Component $component, int $depth): iterable {
		if ($depth >= $this->maxDepth) {
			return;
		}

		$this->componentClasses[\get_class($component)] = true;
		foreach ($this->adapter->getDescendants($component) as $part) {
			if ($part instanceof Localizable) {
				$part = $this->localizer->localize($part); // @phpstan-ignore argument.type (bug or feature? see https://phpstan.org/r/301f358e-c426-4f09-8c75-38eef5fe69c4)
			}
			if ($part instanceof Replaceable) {
				$part = $this->replacementProvider->replace($part);
			}
			if ($part instanceof Component) {
				yield from $this->unwindTree($part, $depth + 1); // @phpstan-ignore argument.type (part will always be TComponent)
			} else if ($part !== null) {
				yield $part;
			}
		}
	}

}
