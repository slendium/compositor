<?php

namespace Slendium\Compositor\Base\Html;

use Override;

use Slendium\Compositor\Html\Formattable;

/**
 * Character data to be included in the output HTML without escaping.
 *
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final readonly class UnescapedCharacterData implements Formattable {

	/** @since 1.0 */
	public function __construct(

		private string $characterData,

	) { }

	#[Override]
	public function generateHtml(): iterable {
		yield $this->characterData;
	}

}
