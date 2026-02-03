<?php

namespace Slendium\CompositorTests\Html\Fixtures;

use Exception;
use Override;

use Slendium\Localization\Localizable;

use Slendium\Compositor\Error;
use Slendium\Compositor\Replaceable;
use Slendium\Compositor\Base\ReplacementProvider;
use Slendium\Compositor\Html\Component;
use Slendium\Compositor\Html\Formattable;

class ReplacementProviderFixtures {

	/** @var ReplacementProvider<HtmlComponent|Formattable|literal-string|float|int> */
	private static ?ReplacementProvider $englishNoOp = null;

	/**
	 * Creates a replacement provider which:
	 * * localizes Localizables to english
	 * * keeps Components and Formattables in place
	 * * converts errors to thrown exceptions
	 * * removes everything else
	 *
	 * @return ReplacementProvider<HtmlComponent|Formattable|literal-string|float|int>
	 */
	public static function englishNoOp(): ReplacementProvider {
		return self::$englishNoOp ??= self::createEnglishNoOp();
	}

	/** @return ReplacementProvider<HtmlComponent|Formattable|literal-string|float|int> */
	private static function createEnglishNoOp(): ReplacementProvider {
		return new class implements ReplacementProvider {
			#[Override]
			public function replace(Localizable|Replaceable|Error $part): mixed {
				return match(true) {
					$part instanceof Localizable => $part['en'] ?? null,
					$part instanceof Error => throw new Exception($part->message),
					$part instanceof Component || $part instanceof Formattable => $part,
					default => null
				};
			}
		};
	}

}
