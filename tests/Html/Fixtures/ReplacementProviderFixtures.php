<?php

namespace Slendium\CompositorTests\Html\Fixtures;

use Exception;
use Override;

use Slendium\Localization\Localizable;
use Slendium\Localization\Base\Locale;

use Slendium\Compositor\Replaceable;
use Slendium\Compositor\Html\Component as HtmlComponent;
use Slendium\Compositor\Html\Formattable;
use Slendium\Compositor\Html\ReplacementProvider;

/**
 * @internal
 * @phpstan-import-type LocalizablePart from HtmlComponent
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class ReplacementProviderFixtures {

	private static ?ReplacementProvider $englishNoOp = null;

	/**
	 * Creates a replacement provider which:
	 * * localizes Localizables to english
	 * * keeps Components and Formattables in place
	 * * throws exceptions given to its
	 * * removes everything else
	 */
	public static function englishNoOp(): ReplacementProvider {
		return self::$englishNoOp ??= self::createEnglishNoOp();
	}

	private static function createEnglishNoOp(): ReplacementProvider {
		return new class implements ReplacementProvider {

			#[Override]
			public function replace(Replaceable|Localizable|Exception $part): HtmlComponent|Formattable|null {
				if ($part instanceof Localizable) {
					return $part[new Locale('en')] ?? null; // @phpstan-ignore return.type (Localizable[Locale] should return valid part)
				}
				if ($part instanceof Exception) {
					throw $part;
				}
				return $part instanceof Formattable
					? $part
					: null;
			}

		};
	}

}
