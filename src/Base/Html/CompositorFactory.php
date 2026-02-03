<?php

namespace Slendium\Compositor\Base\Html;

use Slendium\Localization\Localizer;

use Slendium\Compositor\Compositor;
use Slendium\Compositor\Base\ReplacementProvider;
use Slendium\Compositor\Base\TwoPhaseCompositor;
use Slendium\Compositor\Html\Component;
use Slendium\Compositor\Html\Formattable;

/**
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class CompositorFactory {

	/**
	 * Creates a {@see Compositor} that accepts {@see Component}s to turn into HTML.
	 *
	 * @since 1.0
	 * @param ReplacementProvider<Component,Formattable|literal-string|float|int> $replacementProvider
	 * @return TwoPhaseCompositor<Component,Formattable|literal-string|float|int,string>
	 */
	public static function createTwoPhase(ReplacementProvider $replacementProvider): TwoPhaseCompositor {
		return new TwoPhaseCompositor(
			adapter: new CompositorAdapter,
			replacementProvider: $replacementProvider,
		);
	}

}
