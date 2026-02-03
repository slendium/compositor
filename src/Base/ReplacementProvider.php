<?php

namespace Slendium\Compositor\Base;

use Slendium\Localization\Localizable;

use Slendium\Compositor\Component;
use Slendium\Compositor\Error;
use Slendium\Compositor\Replaceable;

/**
 * Provides replacements for composition parts that are replaceable.
 *
 * Replaceables can itself be valid parts and implementations may decide to keep them in place.
 *
 * @since 1.0
 * @template TComponent of Component
 * @template TPart
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface ReplacementProvider {

	/**
	 * @since 1.0
	 * @template T
	 * @param Localizable<T>|Replaceable|Error $part
	 * @return ($part is Error ? TPart|null : TComponent|TPart|null)
	 */
	public function replace(Localizable|Replaceable|Error $part): mixed;

}
