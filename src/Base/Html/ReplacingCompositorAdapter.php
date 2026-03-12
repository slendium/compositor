<?php

namespace Slendium\Compositor\Base\Html;

use Exception;
use Override;

use Slendium\Localization\Localizable;

use Slendium\Compositor\Component;
use Slendium\Compositor\Replaceable;
use Slendium\Compositor\Base\CompositorAdapter;
use Slendium\Compositor\Html\Component as HtmlComponent;
use Slendium\Compositor\Html\Formattable;
use Slendium\Compositor\Html\ReplacementProvider;

/**
 * @since 1.0
 * @phpstan-import-type PrimaryPart from HtmlComponent
 * @implements CompositorAdapter<HtmlComponent,PrimaryPart,string>
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class ReplacingCompositorAdapter implements CompositorAdapter {

	/** @since 1.0 */
	public function __construct(private readonly ReplacementProvider $replacer) { }

	#[Override]
	public function composeComponent(Component $component): iterable {
		foreach ($component->composeHtml() as $part) {
			if ($part instanceof Replaceable || $part instanceof Localizable || $part instanceof Exception) {
				$part = $this->replacer->replace($part);
			}
			if ($part !== null) {
				yield $part;
			}
		}
	}

	#[Override]
	public function composeException(Exception $exception): iterable {
		$part = $this->replacer->replace($exception);
		if ($part !== null) {
			yield $part;
		}
	}

	#[Override]
	public function composePart(mixed $part): iterable {
		if ($part instanceof Formattable) {
			yield from $part->generateHtml();
		} else {
			yield (string)$part;
		}
	}

}
