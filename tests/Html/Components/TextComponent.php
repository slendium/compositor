<?php

namespace Slendium\CompositorTests\Html\Components;

use Override;

use Slendium\Compositor\Html\Component;
use Slendium\Compositor\Base\Html\EscapedText;

class TextComponent implements Component {

	#[Override]
	public function composeHtml(): iterable {
		yield new EscapedText($this->text);
	}

	public function __construct(

		private string $text,

	) { }

}
