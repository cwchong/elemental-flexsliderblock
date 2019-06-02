<?php

namespace Cwchong\ElementalFlexsliderBlock\Models;

use Cwchong\ElementalFlexsliderBlock\Block\FlexsliderBlock;
use gorriecoe\Link\Models\Link;
use gorriecoe\LinkField\LinkField;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\ORM\DataObject;

class Slide extends DataObject {
    
    private static $table_name = 'C_EFB_Slide';

    private static $db = [
        'Tag' => 'Varchar(255)',
        'Title' => 'Text',
        'Caption' => 'HTMLText',
        'SortOrder' => 'Int',
    ];

    private static $defaults = [
        'Tag' => 'Latest_',
    ];

    private static $has_one = [
        'FlexsliderBlock' => FlexsliderBlock::class,
        'ReadmoreLink' => Link::class,
        'Image' => Image::class,
    ];

    private static $summary_fields = [
        'Tag' => 'Tag',
        'Title' => 'Title',
    ];

    private static $owns = [
        'Image'
    ];

    private static $default_sort = 'SortOrder ASC';
    
    public function getCMSFields() {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName('FlexsliderBlockID');
            $fields->removeByName('ReadmoreLinkID');
            $fields->removeByName('SortOrder');

            $fields->addFieldToTab('Root.Main', LinkField::create('ReadmoreLink', 'Readmore Link', $this));
            
            /** @var TextareaField $titleField */
            $titleField = $fields->fieldByName('Root.Main.Title');
            $titleField->setRows(2);

            /** @var UploadField $uploadField */
            $uploadField = $fields->fieldByName('Root.Main.Image');
            $uploadField->setFolderName('slides')->setAllowedFileCategories('image');

            /** @var HTMLEditorField $captionField */
            $captionField = $fields->fieldByName('Root.Main.Caption');
            $captionField->setRows(5);
        });
        return parent::getCMSFields();
    }

}