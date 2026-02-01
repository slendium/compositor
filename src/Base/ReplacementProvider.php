<?php

namespace Slendium\Compositor\Base;

use Slendium\Compositor\Component;
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
	 * @param Replaceable $part
	 * @return TComponent|TPart|null
	 */
	public function replace(Replaceable $part): mixed;

}
