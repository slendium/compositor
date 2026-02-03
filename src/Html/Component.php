<?php

namespace Slendium\Compositor\Html;

use Slendium\Localization\Localizable;

use Slendium\Compositor\Component as IComponent;
use Slendium\Compositor\Replaceable;

/**
 * @since 1.0
 * @phpstan-type CompositionType Replaceable|Formattable|self|literal-string|float|int
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
	 * @return iterable<CompositionType|Localizable<CompositionType>>
	 */
	public function composeHtml(): iterable;

}
