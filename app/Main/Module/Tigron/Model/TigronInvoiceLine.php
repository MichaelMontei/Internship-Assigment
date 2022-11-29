<?php

namespace Main\Module\Tigron\Model;

class TigronInvoiceLine
{
    /* -- PROPERTIES -- */

    private ?string $_name;
    private ?string $_teamleaderid;
    private ?float $_amount;
    private $_flag;

    /* -- GETTERS -- */

    public function getName(): ? string
    {
        return $this->_name;
    }

    public function getTeamLeaderId(): ? string
    {
        return $this->_teamleaderid;
    }

    public function getAmount(): ? float
    {
        return $this->_amount;
    }

    public function getIgnore(): ? bool
    {
        return $this->_flag;
    }

    /* -- SETTERS -- */

    public function setName($name): TigronInvoiceLine
    {
        $this->_name = $name;
        return $this;
    }

    public function setTeamLeaderId($teamleader): TigronInvoiceLine
    {
        $this->_teamleaderid = $teamleader;
        return $this;
    }

    public function setAmount($amount): TigronInvoiceLine
    {
        $this->_amount = $amount;
        return $this;
    }

    public function setIgnore($flag): TigronInvoiceLine
    {
        $this->_flag = $flag;
        return $this;
    }
}
