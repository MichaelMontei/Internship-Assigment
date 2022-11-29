<?php

namespace App\Tigron;

use App\Shared\DataObject\MapperWithTimestamps;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;
use App\Shared\Traits\MapperWithSoftDeletes;
use Main\Module\Tigron\Model\TigronInvoiceLineText;

class TigronInvoiceLineMapper extends MapperWithTimestamps implements DefinesSoftDeletionMapper
{
    use MapperWithSoftDeletes;


    /* -- PUBLIC -- */
    public function addFilterLatestMatchesFirst(): TigronInvoiceLineMapper
    {
        $mapper = new TigronInvoiceLineMapper();
        $mapper->addFilter(new \M\DataObject\FilterOrder('date', 'DESC'));
        return $mapper;
    }

    /**
     * @param string $getLineText
     * @return TigronInvoiceLineMapper
     */
    public function addFilterLineText(string $getLineText): TigronInvoiceLineMapper
    {
        $mapper = new TigronInvoiceLineMapper();
        $mapper->addFilter(new \M\DataObject\FilterWhere('lineText', $this->getLineText()));
        return $mapper;
    }

    /**
     * @param string|null $getDomain
     * @return TigronInvoiceLineMapper
     */
    public function addFilterDomain(? string $getDomain): TigronInvoiceLineMapper
    {
        $mapper = new TigronInvoiceLineMapper();
        $mapper->addFilter(new \M\DataObject\FilterWhere('domain', $this->getDomain()));
        return $mapper;
    }
}