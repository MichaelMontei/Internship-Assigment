<?php namespace Main\View;

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

        if(Authentication::getInstance()->isAuthenticated()) {
            $myAccount = (new Item('user/profile', t('My account')))->setIcon('user');

            $myAccount->addChild((new Item('user/profile', t('My profile')))->setIcon('user'));
            $myAccount->addChild((new Item('user/change-password', t('Change password')))->setIcon('user'));

            foreach($this->getAdminItems() as $item) {
                $myAccount->addChild($item);
            }

            $myAccount->addChild((new Item('user/logout', t('Log out')))->setIcon('sign-out'));
            $items[] = $myAccount;
        } else {
            $items[] = (new Item('user/login', t('Login')))->setIcon('sign-out');

        }

        return $items;
    }

    /**
     * @param string $gridId
     * @param string $icon
     * @param string $title
     * @return Item
     */
    protected function getGridItem($gridId, $icon, $title)
    {
        $item = new Item('ai/grid/' . $gridId, $title);
        $item->setIcon($icon);
        return $item;
    }

    /**
     * @return bool|User
     */
    protected function getAuthUser()
    {
        $auth = Authentication::getInstance();
        if ( ! $auth->isAuthenticated()) {
            return false;
        }
        return $auth->getAuthUser();
    }

    /**
     * Menu item: admin
     *
     * @param array $items
     * @return array
     */
    protected function getAdminItems(): array
    {
        $items = [];
        // If admin access has been globally blocked, stop already
        if ( ! Gatekeeper::hasAccessTo('admin')) {
            return $items;
        }

        if (Gatekeeper::hasAccessTo('ai:user')) {
            $items[] = $this->getGridItem('user', 'list', t('Admin: users'));
        }

        if (Gatekeeper::hasAccessTo('locales')) {
            $items[] = (new Item('locale/export', t('Admin: export translation files')))->setIcon('export');
            $items[] = (new Item('locale/import', t('Admin: import translation files')))->setIcon('import');
        }

        return $items;
    }
}
