<?php

namespace Slendium\Compositor\Base;

use Slendium\Localization\Localizable;

use Slendium\Compositor\Component;
use Slendium\Compositor\Error;
use Slendium\Compositor\Replaceable;

/**
 * Defines conversions from components and their composed parts to an output type.
 *
 * @since 1.0
 * @template TComponent of Component
 * @template TPart
 * @template TOutput
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface CompositorAdapter {

	/**
	 * @since 1.0
	 * @param TComponent $component
	 * @return iterable<Replaceable|TComponent|TPart|Error|Localizable<Replaceable|TComponent|TPart|Error>>
	 */
	public function getDescendants(Component $component): iterable;

	/**
	 * @since 1.0
	 * @param TPart $part
	 * @return iterable<TOutput>
	 */
	public function generateOutput(mixed $part): iterable;

}
