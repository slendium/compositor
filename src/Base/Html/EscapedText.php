<?php

namespace Slendium\Compositor\Base\Html;

use Override;

use Slendium\Compositor\Html\Formattable;

/**
 * Escapes text for use in an HTML document (in UTF-8).
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EscapedText implements Formattable {

	/**
	 * Escapes text to an HTML-safe string.
	 * @since 1.0
	 */
	public static function escape(string $text): string {
		return \str_replace([ '&', '"', '<', '>' ], [ '&amp;', '&quot;', '&lt;', '&gt;' ], $text);
	}

	/** @since 1.0 */
	public function __construct(

		private string $text,

	) { }

	#[Override]
	public function generateHtml(): iterable {
		yield self::escape($this->text);
	}

}
