<?php

namespace Slendium\Compositor\Base\Html;

use Override;

use Slendium\Compositor\Component;
use Slendium\Compositor\Base\CompositorAdapter as ICompositorAdapter;
use Slendium\Compositor\Html\Component as HtmlComponent;
use Slendium\Compositor\Html\Formattable;

/**
 * @implements ICompositorAdapter<HtmlComponent,Formattable|literal-string|float|int,string>
 * @since 1.0
 * @author C. Fahner
 * @copyright Slendium 2026
 */
class CompositorAdapter implements ICompositorAdapter {

	#[Override]
	public function getDescendants(Component $component): iterable {
		yield from $component->composeHtml();
	}

	#[Override]
	public function generateOutput(mixed $part): iterable {
		if ($part instanceof Formattable) {
			yield from $part->generateHtml();
		} else {
			yield (string)$part;
		}
	}

}
