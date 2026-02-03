<?php

namespace Slendium\CompositorTests\Html\Components;

use Override;

use Slendium\Compositor\Html\Component;
use Slendium\Compositor\Html\Formattable;

class FormattableComponent implements Component {

	public function __construct(public Formattable $content) { }

	#[Override]
	public function composeHtml(): iterable {
		yield $this->content;
	}

}
