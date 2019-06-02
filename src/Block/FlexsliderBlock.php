<?php

namespace Cwchong\ElementalFlexsliderBlock\Block;

use Cwchong\ElementalFlexsliderBlock\Models\Slide;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\ORM\FieldType\DBField;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;

class FlexsliderBlock extends BaseElement {

    private static $table_name = 'C_EFB_FlexsliderBlock';
    private static $icon = 'font-icon-block-carousel';

    /**
     * Set to false to prevent an in-line edit form from showing in an elemental area. Instead the element will be
     * clickable and a GridFieldDetailForm will be used.
     *
     * @config
     * @var bool
     */
    private static $inline_editable = false;

    private static $has_many = [
        'Slides' => Slide::class,
    ];

    public function getCMSFields() {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $fields->removeByName('Slides'); // remove the tab as well
            $config = GridFieldConfig_RecordEditor::create();
            $config->addComponent($sortable = new GridFieldSortableRows('SortOrder'));
            $sortable->setAppendToTop(true);
            $gridField = GridField::create('Slides', 'Slides', $this->Slides(), $config);
            $fields->push($gridField);
        });
        return parent::getCMSFields();
    }

    public function getType() {
        return 'Flexslider';
    }

    // public function getSummary()
    // {
    //     return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    // }
    // protected function provideBlockSchema()
    // {
    //     $blockSchema = parent::provideBlockSchema();
    //     $blockSchema['content'] = $this->getSummary();
    //     return $blockSchema;
    // }

    public function getSummary() {
        $firstSlide = $this->Slides()->first();
        if($firstSlide) {
            return DBField::create_field('HTMLText', $firstSlide->Caption)->Summary(20);
        }
        return '';
    }

    // return meta info for summary section of ElementEditor
    protected function provideBlockSchema() {
        $blockSchema = parent::provideBlockSchema();
        if($this->Slides()) {
            $blockSchema['content'] = $this->getSummary();
        }
        return $blockSchema;
    }

    // // return thumbnail for use in gridfield preview
    // public function getSummaryThumbnail() {
    //     $data = [];
    //     if ($this->Image() && $this->Image()->exists()) {
    //         // Stretch to maximum of 36px either way then trim the extra off
    //         if ($this->Image()->getOrientation() === Image_Backend::ORIENTATION_PORTRAIT) {
    //             $data['Image'] = $this->Image()->ScaleWidth(36)->CropHeight(36);
    //         } else {
    //             $data['Image'] = $this->Image()->ScaleHeight(36)->CropWidth(36);
    //         }
    //     }
    //     return $this->customise($data)->renderWith(__CLASS__ . '/SummaryThumbnail')->forTemplate();
    // }

}