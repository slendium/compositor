<?php

namespace Slendium\Compositor\Html;

/**
 * @since 1.0
 * @phpstan-import-type CompoundPart from Component
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Container extends Component {

	/**
	 * Appends contents to the container, interpreting strings as literal HTML.
	 * @since 1.0
	 * @param CompoundPart $part
	 */
	public function appendHtml(mixed ...$part): static;

	/**
	 * Appends contents to the container, interpreting strings as text to be escaped.
	 * @since 1.0
	 * @param CompoundPart|string $part
	 */
	public function appendText(mixed ...$part): static;

}
