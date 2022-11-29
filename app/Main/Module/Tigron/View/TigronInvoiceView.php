<?php

namespace Main\Module\Tigron\View;

use M\Exception\InvalidArgumentException;
use M\View\View;
use Main\Module\Tigron\Model\TigronInvoice;


class TigronInvoiceView extends View
{
    protected function _getRequired(): array
    {
        return [
            'invoice',
        ];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function setInvoice(TigronInvoice $invoice): TigronInvoiceView
    {
        $this->_setVariable('invoice', $invoice);
        return $this;
    }
}
