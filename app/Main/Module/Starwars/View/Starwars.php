<?php

namespace Main\Module\Starwars\View;

use M\Exception\InvalidArgumentException;
use M\View\View;

class Starwars extends View {

    protected function _getRequired(): array
    {
        return [
            'starwars',
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setChars(\App\Starwars\Starwars $starwars): self
    {
        $this->_setVariable('starwars', $starwars);
        return $this;
    }
}