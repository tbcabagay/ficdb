<?php

namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class SbAdminSidebarWidget extends Widget
{
    public $items;

    public function init()
    {
        parent::init();
        if (empty($this->items)) {
            $this->items = [];
        }
    }

    public function run()
    {
        $listItems = Html::ul($this->items, [
            'encode' => false,
            'id' => 'side-menu',
            'class' => 'nav'
        ]);

        $innerDiv = Html::tag('div', $listItems, [
            'class' => 'sidebar-nav navbar-collapse',
        ]);

        $outerDiv = Html::tag('div', $innerDiv, [
            'class' => 'navbar-default sidebar',
            'role' => 'navigation',
        ]);

        return $outerDiv;
    }
}