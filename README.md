# Silverstripe action
Adds basic call to action modal.

## Installation
Composer is the recommended way of installing SilverStripe modules.
```
composer require gorriecoe/silverstripe-action
```

## Requirements

- silverstripe/cms ^4.0
- gorriecoe/silverstripe-link ^1.0
- gorriecoe/silverstripe-preview ^1.0

## Maintainers

- [Gorrie Coe](https://github.com/gorriecoe)

## Usage

```php

use gorriecoe\Action\Models\Action;
...

class Page extends SiteTree
{
    private static $many_many = [
        'Actions' => Action::class
    ];

    private static $many_many_extraFields = [
        'Actions' => [
            'Sort' => 'Int'
        ]
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldsToTab(
            'Root.Main',
            [
                GridField::create(
                    'Actions',
                    'Actions',
                    $this->Actions(),
                    GridFieldConfig_RecordEditor::create()
                        ->addComponent(new GridFieldOrderableRows('Sort'))
                )
            ]
        );
    }
}
```

```
<% loop Actions.sort('Sort ASC') %>
    <% with Preview %>
        <div class="call-to-action">
            {$Image.Fill(300,200)}
            <h2>
                {$Title}
            </h2>
            <p>
                {$Summary.Summary}
            </p>
            <a href="{$LinkURL}">
                {$Label}
            </a>
        </div>
    <% end_with %>
<% end_loop %>
```
