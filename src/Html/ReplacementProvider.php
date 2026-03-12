<?php

namespace Slendium\Compositor\Html;

use Exception;

use Slendium\Localization\Localizable;

use Slendium\Compositor\Replaceable;

/**
 * Provides implementation-specific replacements for parts that are not valid HTML composition output.
 *
 * {@see Replaceable}'s can themselves be valid parts and implementations may decide to keep them in place.
 *
 * @since 1.0
 * @phpstan-import-type PrimaryPart from Component
 * @phpstan-import-type LocalizablePart from Component
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface ReplacementProvider {

	/**
	 * @since 1.0
	 * @param Replaceable|LocalizablePart|Exception $part
	 * @return PrimaryPart|null
	 */
	public function replace(Replaceable|Localizable|Exception $part): Component|Formattable|string|float|int|null;

}
