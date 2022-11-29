<?php

namespace Main\Module\Tigron\Model;

use App\Tigron\TigronInvoiceLineMapper;
use App\Tigron\TigronLine;
use App\Tigron\TigronLineMapper;
use GuzzleHttp\Exception\GuzzleException;
use M\DataObject\FilterWhere;
use Main\Module\Tigron\View\Tigron;
use Tigron\Cp\Invoice;

class TigronInvoice
{
    /* -- PROPERTIES -- */

    private int $_number;

    /* -- CONSTRUCTOR -- */

    public function __construct(int $number)
    {
        $this->setNumber($number);
        $this->getLines($number);
    }

    /* -- GETTERS -- */

    public function getNumber(): int
    {
        return $this->_number;
    }

    /**
     *
     * @param $number
     * @return array
     */
    public function getLines($number): array
    {
        // Output array needed?
        $out = [];

        // Get the invoice by the number
        $invoice = Invoice::get_by_number($this->_number);
        //dd($invoice); die;

        // Loop through the details and make a new InvoiceLine
        foreach ($invoice->details['items'] as $invoiceItem) {

            // New invoiceLine and set all the attributes for the view
            $line = new TigronInvoiceLine();
            $line->setName($invoiceItem['name']);
            $line->setAmount($invoiceItem['price']);
            $line->setIgnore(true);
            $line->setTeamLeaderId(true);

            // We get the domain name out of the Invoice Line based on Regex.
            $domain = new TigronInvoiceLineText($invoiceItem['name']);
            $domain->getDomain();
            //dd($domain); die;

            // Status Code and Client ID are filled in later
            //$statusCode = 1;

            // For filter to check if we already have an item of  the same name/description
            $checkName = $invoiceItem['name'];

            // New mapper after Tim's explanation storing the data for comparison
            $tigronLine = (new TigronLineMapper())
                ->addFilter(new FilterWhere('name', $checkName))
                ->getOne();

            if ( ! $tigronLine) {
                $tigronLine = new TigronLine();
            }

            $tigronLine->setInvoiceNumber($invoiceItem['invoice_id']);
            $tigronLine->setName($invoiceItem['name']);
            //$tigronLine->setStatusCode($statusCode);
            //$tigronLine->setClientId();
            $tigronLine->save();
            //dd($tigronLine); die;


            /*$testing = new TigronTeamLeaderMatch();
            $testing->getAuthorization();
            $testing->access();
            $testing->getTeamLeaderID();
            dd($testing); die;*/

            $out[] = $line;

            //dd($line);
            //echo $line->getName() . '<br />';
            //echo $line->getAmount() . '<br />';
        }
        return $out;
    }


    /* -- SETTERS -- */

    public function setNumber(int $number): TigronInvoice
    {
        $this->_number = $number;
        return $this;
    }
}