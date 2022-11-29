<?php namespace Ai\Grid;

use Ai\Def\Buttons;
use Ai\Def\Column;
use Ai\Def\Columns;
use Ai\View\Cell\Date;
use Ai\View\Cell\Toggle;
use App\Acl\Gatekeeper;
use App\Product\ProductMapper;
use App\User\UserMapper;
use M\DataObject\FilterOrder;
use M\DataObject\FilterWhere;
use M\DataObject\Interfaces\Mapper;
use M\DataObject\Interfaces\ObjectInterface;
use Ai\Filter\TextContains;

/**
 * Product
 */
class User extends MainGrid
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setTitle(t('Users'));

        $this->getFilterUi()
            ->setIsPersistent(true)
            ->setFilters(new \Ai\Filter\Collection([
                new TextContains('email', t('Email address'), \Ai\Filter\Applier::constructWithColumn('email'), false),
                new TextContains('company', t('Company'), \Ai\Filter\Applier::constructWithColumn('company'), false),
            ]));
        $this->setColumns(new Columns([
            new Column('email', t('Email address'), 'getEmail'),
            new Column('name', t('Full name'), 'getFullName'),
            new Column('company', t('Company'), 'getCompany'),
            new Column('dateCreated', t('Date created'), 'getDateCreated', new Date('dd/MM/YYYY HH:mm')),
            new Column('active', t('Active?'), 'getActive', new Toggle('active', [t('Inactive'), t('Active')])),
        ]));
    }

    /**
     * @return Buttons
     */
    public function getButtons()
    {
        $buttons = new Buttons();
        return $buttons;
    }

    /**
     * @param ObjectInterface $dataObject
     * @return Buttons
     */
    public function getButtonsForInstance(ObjectInterface $dataObject)
    {
        $buttons = new Buttons();
        return $buttons;
    }

    /**
     * Mapper
     *
     * @return Mapper
     */
    public function getMapper()
    {
        return (new UserMapper())
            ->addFilter(new FilterOrder('id', 'DESC'));
    }
}