<?php

namespace Main\Module\Sync\View;

use App\Teamleader\TeamleaderCompany;
use M\DataObject\ResultSet;
use M\Exception\InvalidArgumentException;
use M\View\View;

class Sync extends View {

    protected function _getRequired(): array
    {
        return [
            'teamleaderid',
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setTeamLeaderId(ResultSet $_teamLeaderId): self
    {
        $this->_setVariable('teamleaderid', $_teamLeaderId);
        return $this;
    }
}