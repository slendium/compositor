<?php

namespace Slendium\Compositor\Base\Html;

use Exception;

use Slendium\Compositor\Base\TwoPhaseCompositor;
use Slendium\Compositor\Base\Html\ReplacingCompositorAdapter;
use Slendium\Compositor\Html\Component;
use Slendium\Compositor\Html\ReplacementProvider;

/**
 * @since 1.0
 * @phpstan-import-type PrimaryPart from Component
 * @author C. Fahner
 * @copyright Slendium 2026
 */
final class CompositorFactory {

	/**
	 * Creates a {@see TwoPhaseCompositor} with a {@see ReplacingCompositorAdapter}.
	 *
	 * @since 1.0
	 * @param ReplacementProvider $replacementProvider
	 * @return TwoPhaseCompositor<Component,PrimaryPart,string>
	 */
	public static function createReplacingTwoPhaseCompositor(ReplacementProvider $replacementProvider): TwoPhaseCompositor {
		return new TwoPhaseCompositor(new ReplacingCompositorAdapter($replacementProvider));
	}

}
