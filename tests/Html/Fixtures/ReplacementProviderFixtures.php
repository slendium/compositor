<?php

namespace Slendium\CompositorTests\Html\Fixtures;

use Override;

use Slendium\Compositor\Replaceable;
use Slendium\Compositor\Base\ReplacementProvider;
use Slendium\Compositor\Html\Component;
use Slendium\Compositor\Html\Formattable;

class ReplacementProviderFixtures {

	/** @var ReplacementProvider<HtmlComponent|Formattable|literal-string|float|int> */
	private static ?ReplacementProvider $noOpReplacer = null;

	/** @return ReplacementProvider<HtmlComponent|Formattable|literal-string|float|int> */
	public static function noOpReplacer(): ReplacementProvider {
		return self::$noOpReplacer ??= self::createNoOpReplacer();
	}

	/** @return ReplacementProvider<HtmlComponent|Formattable|literal-string|float|int> */
	private static function createNoOpReplacer(): ReplacementProvider {
		return new class implements ReplacementProvider {
			#[Override]
			public function replace(Replaceable $replaceable): mixed {
				if ($replaceable instanceof Component || $replaceable instanceof Formattable) {
					return $replaceable;
				}
				return '';
			}
		};
	}

}
