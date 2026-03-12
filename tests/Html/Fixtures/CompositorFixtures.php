<?php

namespace Slendium\CompositorTests\Html\Fixtures;

use Override;

use Slendium\Localization\Localizable;
use Slendium\Localization\Localizer;

use Slendium\Compositor\Html\Component as HtmlComponent;
use Slendium\Compositor\Base\TwoPhaseCompositor;
use Slendium\Compositor\Base\Html\CompositorFactory;

use Slendium\CompositorTests\Common\Fixtures\LocalizerFixtures;

/**
 * @internal
 * @phpstan-import-type PrimaryPart from HtmlComponent
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class CompositorFixtures {

	/** @var ?TwoPhaseCompositor<HtmlComponent,PrimaryPart,string> */
	private static ?TwoPhaseCompositor $twoPhaseEnglishNoReplace = null;

	/** @return TwoPhaseCompositor<HtmlComponent,PrimaryPart,string> */
	public static function twoPhaseEnglishNoReplace(): TwoPhaseCompositor {
		return self::$twoPhaseEnglishNoReplace ??= self::createTwoPhaseEnglishNoReplaceCompositor();
	}

	/** @return TwoPhaseCompositor<HtmlComponent,PrimaryPart,string> */
	private static function createTwoPhaseEnglishNoReplaceCompositor(): TwoPhaseCompositor {
		return CompositorFactory::createReplacingTwoPhaseCompositor(ReplacementProviderFixtures::englishNoOp());
	}

	private function __construct() { }

}
