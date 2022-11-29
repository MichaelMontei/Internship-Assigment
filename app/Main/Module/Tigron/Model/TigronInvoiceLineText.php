<?php

namespace Main\Module\Tigron\Model;

use App\Tigron\TigronInvoiceLineMapper;
use Main\Module\Tigron\Model\TigronTeamLeaderMatch;

class TigronInvoiceLineText
{
    private string $line;
    private ? string $domain = null;
    private ? TigronTeamLeaderMatch $match = null;

    public function  __construct(string $line)
    {
        $this->line = $line;
    }

    public function getDomain(): ? string
    {
        if ( ! is_null($this->domain)) {
            return $this->domain;
        }

        $matches = [];
        if (preg_match('/[a-z0-9\-_]+\.(be|com|eu|nl|net|org)/i', $this->getLineText(), $matches) == 1) {
            $this->domain = $matches[0];
        }
        return $this->domain;
    }

    public function getLineText(): string
    {
        return $this->line;
    }

    public function getTeamleaderMatch(): ? TigronTeamLeaderMatch
    {
        if ( ! is_null($this->match)) {
            return $this->match;
        }

        $mapper = new TigronInvoiceLineMapper();
        $mapper->addFilterLatestMatchesFirst();

        $domain = $this->getDomain();
        if( ! $domain) {
            $mapper->addFilterLineText($this->getLineText());
        }else {
            $mapper->addFilterDomain($this->getDomain());
        }
        $this->match = $mapper->getOne();
        return $this->match;
    }
}