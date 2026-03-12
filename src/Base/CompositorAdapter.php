<?php

namespace Slendium\Compositor\Base;

use Exception;

use Slendium\Compositor\Component;

/**
 * Defines conversions from components and their intermediate parts to an output type.
 *
 * @since 1.0
 * @template TComponent of Component
 * @template TIntermediate
 * @template TOutput
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface CompositorAdapter {

	/**
	 * @since 1.0
	 * @param TComponent $component
	 * @return iterable<TComponent|TIntermediate>
	 */
	public function composeComponent(Component $component): iterable;

	/**
	 * @since 1.0
	 * @return iterable<TIntermediate>
	 */
	public function composeException(Exception $exception): iterable;

	/**
	 * @since 1.0
	 * @param TIntermediate $part
	 * @return iterable<TOutput>
	 */
	public function composePart(mixed $part): iterable;

}
