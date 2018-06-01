<?php

namespace gorriecoe\Action\Models;

use gorriecoe\Link\Models\Link;
use gorriecoe\Preview\View\Preview;
use SilverStripe\Assets\Image;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;

/**
 * Action
 *
 * @package silverstripe-preview
 */
class Action extends Link
{
    /**
     * Defines the database table name
     * @var string
     */
    private static $table_name = 'Action';

    /**
     * Singular name for CMS
     * @var string
     */
    private static $singular_name = 'Action';

    /**
     * Plural name for CMS
     * @var string
     */
    private static $plural_name = 'Actions';

    /**
     * Database fields
     * @var array
     */
    private static $db = [
        'ActionTitle' => 'Text',
        'ActionSummary' => 'Text',
        'ActionLabel' => 'Varchar(255)'
    ];

    /**
     * Has_one relationship
     * @var array
     */
    private static $has_one = [
        'ActionImage' => Image::class
    ];

    /**
     * Relationship version ownership
     * @var array
     */
    private static $owns = [
        'ActionImage'
    ];

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image',
        'Title' => 'Title',
        'LinkURL' => 'Link'
    ];

    protected $preview = null;

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->replaceField(
            'Title',
            TextareaField::create(
                'ActionTitle',
                _t(Parent::class . '.TITLE', 'Title')
            )
            ->setRows(1)
        );
        $fields->addFieldsToTab(
            'Root.Main',
            [
                UploadField::create(
                    'ActionImage',
                    _t(__CLASS__ . '.IMAGE', 'Image')
                )
                ->setAllowedExtensions(['jpg','png','gif']),
                TextareaField::create(
                    'ActionSummary',
                    _t(__CLASS__ . '.SUMMARY', 'Summary')
                )
                ->setRows(4),
                TextField::create(
                    'ActionLabel',
                    _t(__CLASS__ . '.LABEL', 'Label')
                )
            ]
        );

        return $fields;
    }

    public function getPreview()
    {
        $preview = $this->preview;
        if ($preview) {
            return $preview;
        }
        $type = $this->Type;
        if ($this->getRelationType($type) == 'has_one' && $component = $this->getComponent($type)) {
            if ($component->exists() && $component->hasMethod('getPreview')) {
                $preview = $component->Preview;
                $preview->Owner = $this;
            } else {
                $preview = Preview::create($this);
            }
        } else {
            $preview = Preview::create($this);
        }

        $preview->Image = ['ActionImage'];
        $preview->Title = ['ActionTitle'];
        $preview->Label = ['ActionLabel'];
        $preview->Summary = ['ActionSummary'];
        $this->preview = $preview;
        return $preview;
    }

    public function __get($name)
    {
        if ($this->Preview->{$name}) {
            return $this->Preview->{$name};
        }
        $value = parent::__get($name);
        $this->extend('update' . $name, $value);
        return $value;
    }

    /**
     * CMS accessor for getImage()
     * @return Image
     */
    public function Image()
    {
        return $this->Image;
    }

    /**
     * Renders an HTML anchor tag for this link
     * @return HTML
     */
    public function forTemplate()
    {
        return $this->renderWith('Action');
    }
}
