<?php

namespace Slendium\Compositor\Base\Html;

use Override;

use Slendium\Compositor\Html\Formattable;

/**
 * An escaped attribute value for use in an HTML document (in UTF-8).
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class EscapedAttr implements Formattable {

	/**
	 * Escapes an attribute value to an HTML-safe string.
	 * @since 1.0
	 * @see https://archive.ph/rbmZ1
	 */
	public static function escape(string $value): string {
		return \str_replace([ '&', '"', "'" ], [ '&amp;', '&quot;', '&#39;' ], $value);
	}

	/** @since 1.0 */
	public function __construct(private string $value) { }

	#[Override]
	public function generateHtml(): iterable {
		yield self::escape($this->value);
	}

}
