<?php namespace Ai\Grid;

use Ai\Def\Button;
use Ai\Def\Buttons;
use Ai\Def\Columns;
use Ai\Filter\Applier;
use Ai\Filter\Population;
use Ai\Form\Population\Items;
use Ai\View\Cell\Cell;
use Ai\View\Cell\DataObject;
use Ai\View\Cell\Toggle;
use App\Acl\Gatekeeper;
use App\Ai\Def\ColumnAttributes;
use App\Shared\Interfaces\DefinesSoftDeletionMapper;
use App\User\User;
use M\DataObject\Interfaces\Mapper;
use M\DataObject\Interfaces\ObjectInterface;
use M\Locale\Locale;
use M\Locale\MessageCatalog;
use Ai\View\Cell\Translations;
use Ai\Def\Column;
use User\Authentication;

abstract class MainGrid extends \Ai\Def\Grid
{
    /* -- PROPERTIES -- */

    /**
     * @var bool
     */
    private $_addedTranslationColumn;

    /**
     * Currently authenticated user
     *
     * @var User
     */
    private $authUser;

    /* -- PUBLIC -- */

    /**
     * @return \Ai\Def\Columns
     */
    public function getColumns()
    {
        $columns = parent::getColumns();

        if(! $this->_addedTranslationColumn) {
            if($this->getMapper()->getDefinition()->getTable()->getColumns()->hasLocalized()) {
                foreach(MessageCatalog::getStorage()->getInstalledLocales() as $locale) {
                    $columns->append(
                        new Column('translations-' . $locale, strtoupper($locale), 'getId', new Translations(), 80));
                }
            }
            $this->_addedTranslationColumn = true;
        }

        return $columns;
    }

    /**
     * @return \Ai\Def\Selection
     */
    public function getSelection()
    {
        $selection = parent::getSelection();
        $selection->setAllowSelections(count($this->getButtonsSelection()));
        return $selection;
    }

    /**
     * @return Buttons
     */
    public function getButtons()
    {
        $buttons = new Buttons();

        if (Gatekeeper::canCreate($this->getId())) {
            $btn = $this->getNewObjectButton();
            if ($btn) {
                $buttons->append($btn);
            }
        }

        return $buttons;
    }

    /**
     * @param ObjectInterface $dataObject
     * @return Buttons
     */
    public function getButtonsForInstance(ObjectInterface $dataObject)
    {
        $buttons = new Buttons();

        if (Gatekeeper::canEdit($this->getId())) {
            $btn = $this->getEditObjectButton($dataObject);
            if ($btn) {
                $buttons->append($btn);
            }
        }

        if (Gatekeeper::canDelete($this->getId())) {
            $btn = $this->getDeleteObjectButton($dataObject);
            if ($btn) {
                $buttons->append($btn);
            }
        }

        return $buttons;
    }

    /* -- PRIVATE/PROTECTED -- */

    /**
     * @return User
     */
    protected function getAuthUser()
    {
        if (is_null($this->authUser)) {
            $this->authUser = Authentication::getInstance()->getAuthUser();
        }
        return $this->authUser;
    }

    /**
     * Returns a column for a dataobject
     *
     * Note: should the mapper implement the interface DefinesSoftDeletionMapper,
     * then the deleted(false) filter will be applied inside this function!
     *
     * @param string $id
     * @param string $title
     * @param string $getter
     * @param Mapper $mapper
     * @return Column
     */
    protected function objectColumn($id, $title, $getter, Mapper $mapper, $valueGetter = 'getTitle', $cellView = 'Text'): Column
    {
        if ($mapper instanceof DefinesSoftDeletionMapper) {
            $mapper->addFilterDeleted(false);
        }

        return new Column($id, $title, $getter, new DataObject($mapper, 'getById', $valueGetter), $cellView);
    }

    /**
     * @param string $titleUntranslated
     * @return Button
     */
    protected function getNewObjectButton($titleUntranslated = 'New'): ?Button
    {
        return new Button(
            'new',
            t($titleUntranslated) . ' <i class=\'fa fa-plus fa-fw\'></i>',
            '',
            'ai/form/edit/' . $this->getId()
        );
    }

    /**
     * @param ObjectInterface $object
     * @return Button
     */
    protected function getEditObjectButton(ObjectInterface $object): ?Button
    {
        return new Button(
            'edit',
            t('Edit'),
            t('Edit this item'),
            'ai/form/edit/' . $this->getId() . '/' . $object->getHashIdEncrypted()
        );
    }

    /**
     * @param ObjectInterface $object
     * @return Button
     */
    protected function getDeleteObjectButton(ObjectInterface $object): ?Button
    {
        return new Button(
            'del',
            t('Delete'),
            t('Delete this item'),
            'ai/action/delete/' . $this->getId() . '/' . $object->getHashIdEncrypted(),
            true,
            null,
            t('Are you sure you wish to delete this item?')
        );
    }

    /**
     * @param Columns $columns
     * @return Columns
     */
    protected function addDateColumns(Columns $columns)
    {
        $columns->append(new Column('createdAt', t('Created at'), 'getCreatedAt', (new \Ai\View\Cell\Date())->setDateFormat('dd/MM/y HH:mm')));
        $columns->append(new Column('updatedAt', t('Updated at'), 'getUpdatedAt', (new \Ai\View\Cell\Date())->setDateFormat('dd/MM/y HH:mm')));

        return $columns;
    }
}