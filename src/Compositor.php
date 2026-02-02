<?php

namespace Slendium\Compositor;

/**
 * Composes a tree of components into its associated output format.
 *
 * Some formats can have associated resources (eg. CSS or JavaScript) which components can declare
 * using {@see UseLibrary} pointing to a {@see ComponentLibrary}.
 *
 * @since 1.0
 * @see Base\TwoPhaseCompositor A compositor with an optimization step in between
 * @template TComponent of Component
 * @template TComposition of Composition
 * @author C. Fahner
 * @copyright Slendium 2026
 */
interface Compositor {

	/**
	 * @since 1.0
	 * @param TComponent $root
	 * @return TComposition
	 */
	public function compose(Component $root): Composition;

}
