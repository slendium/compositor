<?php

namespace Slendium\Compositor\Html;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Formattable {

	/**
	 * @since 1.0
	 * @return iterable<string>
	 */
	public function generateHtml(): iterable;

}
