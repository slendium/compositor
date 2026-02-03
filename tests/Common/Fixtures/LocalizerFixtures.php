<?php

namespace Slendium\CompositorTests\Common\Fixtures;

use Override;

use Slendium\Localization\Localizable;
use Slendium\Localization\Localizer;

class LocalizerFixtures {

	private static ?Localizer $englishLocalizer = null;

	public static function englishLocalizer(): Localizer {
		return self::$englishLocalizer ?? self::createEnglishLocalizer();
	}

	private static function createEnglishLocalizer(): Localizer {
		return new class implements Localizer {
			#[Override]
			public function localize(Localizable $localizable): mixed {
				return $localizable['en'] ?? null;
			}
		};
	}

}
