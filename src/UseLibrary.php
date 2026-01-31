<?php

namespace Slendium\Compositor;

use Attribute;

/**
 * An attribute that can be used on `Component`s to indicate they are part of a library.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
final class UseLibrary {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var class-string<ComponentLibrary>
		 */
		public readonly string $libraryClass,

	) { }

	/** @since 1.0 */
	public function instantiateLibrary(): ComponentLibrary {
		return new $this->libraryClass;
	}

}
