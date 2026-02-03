<?php

namespace Slendium\CompositorTests\Html\Fixtures;

use Override;

use Slendium\Localization\Localizable;
use Slendium\Localization\Localizer;

use Slendium\Compositor\Compositor;
use Slendium\Compositor\Base\Html\CompositorFactory;

use Slendium\CompositorTests\Common\Fixtures\LocalizerFixtures;

class CompositorFixtures {

	/** @var ?Compositor<HtmlComponent,string> */
	private static ?Compositor $twoPhaseEnglishNoReplace = null;

	/** @return Compositor<HtmlComponent,string> */
	public static function twoPhaseEnglishNoReplace(): Compositor {
		return self::$twoPhaseEnglishNoReplace ??= self::createTwoPhaseEnglishNoReplaceCompositor();
	}

	/** @return Compositor<HtmlComponent,string> */
	private static function createTwoPhaseEnglishNoReplaceCompositor(): Compositor {
		return CompositorFactory::createTwoPhase(
			replacementProvider: ReplacementProviderFixtures::englishNoOp()
		);
	}

	private function __construct() { }

}
