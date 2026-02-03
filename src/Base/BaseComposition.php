<?php

namespace Slendium\Compositor\Base;

use Override;
use ReflectionClass;

use Slendium\Compositor\Component;
use Slendium\Compositor\ComponentLibrary;
use Slendium\Compositor\Composition as IComposition;
use Slendium\Compositor\UseLibrary;

/**
 * @since 1.0
 * @template TComponent of Component
 * @template TOutput
 * @implements IComposition<TComponent,TOutput>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
abstract class BaseComposition implements IComposition {

	/** @since 1.0 */
	public function __construct(

		/** @var list<class-string<TComponent>> */
		#[Override]
		public readonly array $componentClasses,

	) { }

	/**
	 * @since 1.0
	 * @return iterable<ComponentLibrary>
	 */
	public function generateLibraries(): iterable {
		$uniqueLibraries = [ ];
		foreach ($this->generateLibraryUses() as $useLibrary) {
			$uniqueLibraries[$useLibrary->libraryClass] = $useLibrary;
		}
		foreach ($uniqueLibraries as $useLibrary) {
			yield $useLibrary->instantiateLibrary();
		}
	}

	/** @return iterable<UseLibrary> */
	private function generateLibraryUses(): iterable {
		foreach ($this->componentClasses as $componentClass) {
			foreach (new ReflectionClass($componentClass)->getAttributes(UseLibrary::class) as $attribute) {
				yield $attribute->newInstance();
			}
		}
	}

}
