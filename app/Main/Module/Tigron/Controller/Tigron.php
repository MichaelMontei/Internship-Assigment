<?php

namespace Main\Module\Tigron\Controller;


use M\DataObject\ResultSet;
use M\Exception\InvalidArgumentException;
use Main\Module\Tigron\Model\TigronInvoice;
use App\Tigron\TigronMapper;
use Main\Controller\Main;
use Main\Module\Tigron\View\TigronInvoiceView;


class Tigron extends Main
{
    /**
     * @throws InvalidArgumentException
     */
    public function index()
    {
        (new \Main\Module\Tigron\View\Tigron())
            ->setTest($this->getTigronInfo())
            ->addWrap($this->_getWrap(
                t('FAQ'),
                ''
            ))
            ->display();
    }

    /**
     * @throws InvalidArgumentException
     */
    public function invoice(int $number)
    {

        //@ We make a new Tigroninvoice with the number parameter
        $tigronInvoice = new TigronInvoice($number);

        //@ Make a new View where we set the view (tigroninvoice we just made)
        $view = new TigronInvoiceView();
        $view->setInvoice($tigronInvoice);
        $view->addWrap($this->_getWrap(
            t('Invoice @number', [ '@number' => $tigronInvoice->getNumber() ]),
            ''
        ));
        $view->display();
    }

    private function getTigronInfo(): ResultSet
    {
        return (new TigronMapper())
            ->getAll();
    }
}