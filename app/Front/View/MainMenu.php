<?php namespace Front\View;

use App\User\User;
use M\Menu\Item;
use M\Menu\Menu;
use App\Acl\Gatekeeper;
use User\Authentication;

/**
 * Class MainMenu
 *
 * @package Main
 */
class MainMenu extends Menu
{
    /* -- PROPERTIES -- */

    /**
     * @var array
     */
    private $children;

    /* -- PUBLIC -- */

    /**
     * @return \ArrayIterator
     */
    public function getItems()
    {
        return new \ArrayIterator($this->getChildren());
    }

    /* -- PRIVATE/PROTECTED -- */

    /**
     * @return array
     */
    protected function getChildren(): array
    {
        if (is_null($this->children)) {
            $this->children = $this->initChildren();
        }
        return $this->children;
    }

    /**
     * @return array
     */
    protected function initChildren(): array
    {
        $items = [];

        $items[] = (new Item('', t('Home')))->setIcon('home');

        return $items;
    }
}
