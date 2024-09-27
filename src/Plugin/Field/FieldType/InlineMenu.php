<?php

namespace Drupal\inline_menu\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'inline_menu' field type.
 *
 * @FieldType(
 *   id = "inline_menu",
 *   label = @Translation("Inline Menu"),
 *   module = "inline_menu",
 *   description = @Translation("Creates an inline menu field."),
 *   default_widget = "inline_menu_widget",
 *   default_formatter = "inline_menu_formatter"
 * )
 */
class InlineMenu extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    return [
      'columns' => [
        'title' => [
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
        'url' => [
          'type' => 'text',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
        'nest_level' => [
          'type' => 'int',
          'size' => 'tiny',
          'not null' => FALSE,
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties['title'] = DataDefinition::create('string')->setLabel(t('Menu Item Title'));
    $properties['url'] = DataDefinition::create('string')->setLabel(t('Menu Link URL'));
    $properties['nest_level'] = DataDefinition::create('integer')->setLabel(t('Nest Level'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('title')->getValue();
    return $value === NULL || $value === '';
  }

}
