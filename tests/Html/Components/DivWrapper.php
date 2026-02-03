<?php

namespace Slendium\CompositorTests\Html\Components;

use Override;

use Slendium\Compositor\Html\Component;

class DivWrapper implements Component {

	public function __construct(

		private Component $wrappee,

	) { }

	#[Override]
	public function composeHtml(): iterable {
		yield from [ '<div>', $this->wrappee, '</div>' ];
	}

}
