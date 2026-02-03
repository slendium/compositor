<?php

namespace Slendium\Compositor\Base\Html;

use Closure;
use Override;
use Stringable;

use Slendium\Compositor\Html\Formattable;

/**
 * Accepts a callback which returns text to escape for HTML output, delaying the output generation
 * until the very last moment.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EscapedTextCallback implements Formattable {

	/** @since 1.0 */
	public function __construct(

		/**
		 * @since 1.0
		 * @var Closure():(Stringable|string)
		 */
		public Closure $callback,

	) { }

	#[Override]
	public function generateHtml(): iterable {
		yield EscapedText::escape(($this->callback)());
	}

}
