<?php

namespace Slendium\Compositor\Html;

use Exception;

use Slendium\Localization\Localizable;

use Slendium\Compositor\Component as IComponent;
use Slendium\Compositor\Replaceable;

/**
 * @since 1.0
 * @phpstan-type PrimaryPart Formattable|literal-string|float|int
 * @phpstan-type LocalizablePart Localizable<Replaceable|Formattable|self|string|float|int>
 * @phpstan-type CompoundPart Replaceable|Exception|self|PrimaryPart|LocalizablePart
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Component extends IComponent {

	/**
	 * Composes the HTML.
	 *
	 * Literal strings are assumed to be safe HTML that does not need to be escaped.
	 *
	 * @since 1.0
	 * @return iterable<CompoundPart>
	 */
	public function composeHtml(): iterable;

}
