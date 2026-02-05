<?php

namespace Slendium\CompositorTests\Html\Components;

use Override;

use Slendium\Compositor\ComponentLibrary;

class Library extends ComponentLibrary {

	#[Override]
	public function getResourceDirectories(): iterable {
		yield __DIR__;
	}

}
